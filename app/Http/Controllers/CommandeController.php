<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\CommandeItem;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommandeController extends Controller
{
    public function storeCod(Request $request)
    {
        // Log incoming request for debugging
        Log::info('storeCod called', [
            'user_id' => Auth::id(),
            'payload_keys' => array_keys($request->all()),
        ]);

        $data = $request->validate([
            'nom' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:50',
            'adresse' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.catalogue_id' => 'nullable|integer',
            'items.*.titre' => 'nullable|string|max:255',
            'items.*.quantite' => 'required|integer|min:1',
            'items.*.prix' => 'required|numeric',
            'total' => 'required|numeric',
            'idempotency_key' => 'nullable|string|max:255'
        ]);

        $userId = Auth::id();

        // If idempotency_key provided, check for existing commande
        if (!empty($data['idempotency_key'])) {
            $existing = Commande::where('idempotency_key', $data['idempotency_key'])->first();
            if ($existing) {
                return response()->json([
                    'success' => true,
                    'message' => 'Commande déjà enregistrée (idempotence).',
                    'commande_id' => $existing->id,
                    'contact_phone' => config('app.contact_phone', env('CONTACT_PHONE', '')),
                    'contact_email' => config('app.contact_email', env('CONTACT_EMAIL', '')),
                ]);
            }
        }

        // If user is authenticated, prefer their stored data when fields are missing
        $user = Auth::user();
        $nom = $data['nom'] ?? ($user->name ?? null);
        $tel = $data['tel'] ?? ($user->phone ?? null);
        $adresse = $data['adresse'] ?? ($user->address ?? null);

        // Recompute total server-side to prevent client tampering
        $computedTotal = 0;
        foreach ($data['items'] as $it) {
            $qty = isset($it['quantite']) ? (int)$it['quantite'] : 1;
            $price = isset($it['prix']) ? (float)$it['prix'] : 0.0;
            $computedTotal += $qty * $price;
        }
        // Round to cents/units consistency
        $computedTotal = round($computedTotal, 2);
        $submittedTotal = round((float)$data['total'], 2);
        if ($computedTotal !== $submittedTotal) {
            Log::warning('Total mismatch on storeCod', [
                'user_id' => $userId,
                'computed' => $computedTotal,
                'submitted' => $submittedTotal,
                'payload' => $data,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Le total soumis ne correspond pas au montant calculé. Veuillez rafraîchir le panier.'
            ], 422);
        }

        try {
            $result = DB::transaction(function() use ($data, $userId, $nom, $tel, $adresse) {
                $commande = Commande::create([
                    'user_id' => $userId,
                    'nom' => $nom,
                    'telephone' => $tel,
                    'adresse' => $adresse,
                    'total' => $data['total'],
                    'statut' => 'pending',
                    'idempotency_key' => $data['idempotency_key'] ?? null,
                ]);

                $createdItems = [];
                foreach ($data['items'] as $it) {
                    $catalogueId = isset($it['catalogue_id']) ? (int)$it['catalogue_id'] : null;
                    $titre = $it['titre'] ?? null;
                    $quantite = isset($it['quantite']) ? (int)$it['quantite'] : 1;
                    $prix = isset($it['prix']) ? (float)$it['prix'] : 0.0;

                    $ci = CommandeItem::create([
                        'commande_id' => $commande->id,
                        'catalogue_id' => $catalogueId,
                        'titre' => $titre,
                        'quantite' => $quantite,
                        'prix' => $prix,
                    ]);

                    $createdItems[] = [
                        'id' => $ci->id,
                        'catalogue_id' => $catalogueId,
                        'titre' => $titre,
                        'quantite' => $quantite,
                        'prix' => $prix,
                    ];
                }

                // Vider le panier de l'utilisateur (si connecté)
                if ($userId) {
                    \App\Models\CartItem::where('user_id', $userId)->delete();
                }

                return ['commande' => $commande, 'items' => $createdItems];
            });
            $commande = $result['commande'];
            $createdItems = $result['items'];
    } catch (\Exception $e) {
            // Log the exception and return an error to the client
            Log::error('Erreur création commande COD: '.$e->getMessage(), [
                'exception' => $e,
                'user_id' => $userId ?? null,
                'payload' => $data,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement de la commande. Veuillez réessayer.'
            ], 500);
        }

        // contact info to show in response (could come from config or env)
    // contact info to show in response (prefer app config, otherwise use user's phone/email)
    $contactPhone = config('app.contact_phone', env('CONTACT_PHONE', '')) ?: ($user->phone ?? '');
    $contactEmail = config('app.contact_email', env('CONTACT_EMAIL', '')) ?: ($user->email ?? '');

        // Log created items for debugging
        Log::info('Commande created', [
            'commande_id' => $commande->id,
            'user_id' => $commande->user_id,
            'items' => $createdItems ?? [],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Commande enregistrée (payée à la livraison).',
            'commande_id' => $commande->id,
            'contact_phone' => $contactPhone,
            'contact_email' => $contactEmail,
            'items' => $createdItems ?? [],
        ], 201);
    }

    // Affiche les commandes de l'utilisateur connecté
    public function mesCommandes()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $commandes = Commande::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('account.commandes', compact('commandes'));
    }

    public function show(Commande $commande)
    {
        $user = Auth::user();
        if (!$user || $commande->user_id !== $user->id) {
            abort(403);
        }

        $commande->load('items');
        return view('commandes.show', compact('commande'));
    }
}
