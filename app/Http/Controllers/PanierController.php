<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    public function modifier(Request $request, $id)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour modifier votre panier.');
        }
        $item = CartItem::where('id', $id)->where('user_id', $user->id)->first();
        if (!$item) {
            return redirect()->back()->with('error', 'Livre non trouvé dans votre panier.');
        }
        $catalogue = $item->catalogue;
        $quantiteMax = $catalogue ? $catalogue->quantite : 1;
        $item->quantite = min($request->quantite, $quantiteMax);
        $item->save();
        return redirect()->back()->with('success', 'Quantité modifiée !');
    }
    public function ajouter(Request $request)
    {
        // Accepter aussi bien livre_id que catalogue_id
        $livreId = $request->input('livre_id') ?? $request->input('catalogue_id');

        $request->merge(['catalogue_id' => $livreId]);

        $request->validate([
            'catalogue_id' => 'required|exists:catalogues,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous devez être connecté pour ajouter au panier.'
                ], 401);
            }
            return redirect()->back()->with('error', 'Vous devez être connecté pour ajouter au panier.');
        }

        $item = CartItem::where('user_id', $user->id)
            ->where('catalogue_id', $request->catalogue_id)
            ->first();

        $quantiteAjoutee = $request->quantite;
        $catalogue = \App\Models\Catalogue::find($request->catalogue_id);

        if (!$catalogue) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Livre introuvable.'
                ], 404);
            }
            return redirect()->back()->with('error', 'Livre introuvable.');
        }

        $quantiteMax = $catalogue->quantite;

        if ($item) {
            // On ne dépasse pas le stock disponible
            $nouvelleQuantite = min($item->quantite + $quantiteAjoutee, $quantiteMax);

            if ($nouvelleQuantite > $quantiteMax) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stock insuffisant. Disponible: {$quantiteMax}"
                    ], 400);
                }
                return redirect()->back()->with('error', "Stock insuffisant. Disponible: {$quantiteMax}");
            }

            $item->quantite = $nouvelleQuantite;
            $item->save();

            $message = "Quantité mise à jour dans le panier : {$catalogue->titre}";
        } else {
            if ($quantiteAjoutee > $quantiteMax) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stock insuffisant. Disponible: {$quantiteMax}"
                    ], 400);
                }
                return redirect()->back()->with('error', "Stock insuffisant. Disponible: {$quantiteMax}");
            }

            CartItem::create([
                'user_id' => $user->id,
                'catalogue_id' => $request->catalogue_id,
                'quantite' => min($quantiteAjoutee, $quantiteMax),
            ]);

            $message = "'{$catalogue->titre}' ajouté au panier avec succès !";
        }

        // Réponse JSON pour AJAX
        if ($request->wantsJson() || $request->ajax()) {
            $cartCount = $user->cartItems()->sum('quantite');
            return response()->json([
                'success' => true,
                'message' => $message,
                'cartCount' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à votre panier.');
        }
        $items = $user->cartItems()->with('catalogue')->get();
        return view('panier.index', compact('items'));
    }

    public function supprimer($id)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour modifier votre panier.');
        }
        $item = CartItem::where('id', $id)->where('user_id', $user->id)->first();
        if (!$item) {
            return redirect()->back()->with('error', 'Livre non trouvé dans votre panier.');
        }
        $item->delete();
        return redirect()->back()->with('success', 'Livre retiré du panier.');
    }

    public function payer(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour continuer vers le paiement.');
        }

        $cartItems = $user->cartItems()->with('catalogue')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        // Redirige vers la page de paiement avec le panier
        return redirect()->route('paiement.show');
    }

    public function showPaiement()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à la page de paiement.');
        }

        $cartItems = $user->cartItems()->with('catalogue')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        $total = $cartItems->sum(fn($i) => $i->catalogue->prix * $i->quantite);
        return view('panier.paiement', compact('cartItems', 'total'));
    }

    public function traiterPaiement(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:kkiapay,paypal,livraison,test',
        ]);

        $user = Auth::user();
        if (! $user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Veuillez vous connecter pour continuer.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour continuer.');
        }

        $cartItems = $user->cartItems()->with('catalogue')->get();

        if ($cartItems->isEmpty()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Votre panier est vide.'
                ], 400);
            }
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        $paymentMethod = $request->payment_method;

        // Si livraison, créer automatiquement une commande COD
        if ($paymentMethod === 'livraison') {
            try {
                // Préparer les données de la commande
                $total = $cartItems->sum(fn($i) => $i->catalogue->prix * $i->quantite);

                // Préparer les items pour la commande
                $commandeItems = [];
                foreach ($cartItems as $cartItem) {
                    $commandeItems[] = [
                        'catalogue_id' => $cartItem->catalogue_id,
                        'titre' => $cartItem->catalogue->titre,
                        'quantite' => $cartItem->quantite,
                        'prix' => $cartItem->catalogue->prix,
                    ];
                }

                // Créer la commande COD
                $commande = \App\Models\Commande::create([
                    'user_id' => $user->id,
                    'nom' => $user->name,
                    'telephone' => $user->phone ?? '',
                    'adresse' => $user->address ?? '',
                    'total' => $total,
                    'statut' => 'pending',
                    'idempotency_key' => uniqid('cod_', true), // Clé unique pour éviter les doublons
                ]);

                // Créer les items de la commande
                foreach ($commandeItems as $itemData) {
                    \App\Models\CommandeItem::create([
                        'commande_id' => $commande->id,
                        'catalogue_id' => $itemData['catalogue_id'],
                        'titre' => $itemData['titre'],
                        'quantite' => $itemData['quantite'],
                        'prix' => $itemData['prix'],
                    ]);
                }

                // Vider le panier de l'utilisateur
                \App\Models\CartItem::where('user_id', $user->id)->delete();

                // Si requête AJAX, retourner une réponse JSON
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Commande enregistrée avec succès ! Vous payerez à la réception. Notre équipe vous contactera bientôt.',
                        'commande_id' => $commande->id,
                        'redirect_url' => route('account.commandes')
                    ]);
                }

                // Sinon, rediriger vers la page des commandes avec un message de succès
                return redirect()->route('account.commandes')
                    ->with('success', 'Commande #' . $commande->id . ' enregistrée avec succès ! Vous payerez à la réception. Notre équipe vous contactera bientôt.');
            } catch (\Exception $e) {
                \Log::error('Erreur création commande livraison: ' . $e->getMessage());

                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Une erreur est survenue lors de la création de votre commande. Veuillez réessayer.'
                    ], 500);
                }

                return redirect()->route('paiement.show')
                    ->with('error', 'Une erreur est survenue. Veuillez réessayer.');
            }
        }

        // Créer une commande pour le paiement en ligne
        $commande = \App\Models\Commande::create([
            'user_id' => $user->id,
            'total' => $cartItems->sum(fn($i) => $i->catalogue->prix * $i->quantite),
            'statut' => 'en_attente',
            'mode_paiement' => $paymentMethod,
            'paiement_valide' => false,
        ]);

        // Créer les items de commande
        foreach ($cartItems as $cartItem) {
            \App\Models\CommandeItem::create([
                'commande_id' => $commande->id,
                'catalogue_id' => $cartItem->catalogue_id,
                'quantite' => $cartItem->quantite,
                'prix_unitaire' => $cartItem->catalogue->prix,
            ]);
        }

        // Rediriger vers le gestionnaire de paiement approprié
        switch ($paymentMethod) {
            case 'test':
                return redirect()->route('paiement.test.catalogue', ['commande' => $commande->id]);
            case 'kkiapay':
                return redirect()->route('paiement.catalogue.kkiapay', ['commande' => $commande->id]);
            case 'paypal':
                return redirect()->route('paiement.catalogue.paypal', ['commande' => $commande->id]);
            default:
                return redirect()->route('paiement.show')
                    ->with('error', 'Méthode de paiement non reconnue.');
        }
    }
}
