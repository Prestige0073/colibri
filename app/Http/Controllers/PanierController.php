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
        $total = $cartItems->sum(fn($i) => $i->catalogue->prix * $i->quantite);
        return view('paiement.show', compact('cartItems', 'total'));
    }
}
