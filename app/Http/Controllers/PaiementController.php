<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormationInscription;
use Illuminate\Support\Facades\Auth;
use App\Mail\User\PaymentConfirmation;
use App\Mail\User\OrderConfirmation;
use App\Mail\Admin\NewPayment;
use App\Mail\Admin\NewOrder;
use Illuminate\Support\Facades\Mail;

class PaiementController extends Controller
{
    /**
     * Traiter le paiement via Kkiapay
     */
    public function kkiapay($inscription)
    {
        $inscription = FormationInscription::findOrFail($inscription);

        // Vérifier que l'inscription appartient à l'utilisateur connecté
        if ($inscription->user_id !== Auth::id()) {
            abort(403);
        }

        $formation = $inscription->formation;
        $montant = $inscription->montant_paye;

        return view('paiement.kkiapay', compact('inscription', 'formation', 'montant'));
    }

    /**
     * Callback Kkiapay - Vérifier et valider le paiement
     */
    public function kkiapayCallback(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $inscriptionId = $request->input('inscription_id');

        // TODO: Vérifier la transaction auprès de Kkiapay API
        // Pour l'instant, on valide directement (à modifier en production)

        $inscription = FormationInscription::findOrFail($inscriptionId);

        $inscription->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
        ]);

        // Envoyer les emails de confirmation de paiement
        try {
            Mail::to($inscription->user->email)->queue(new PaymentConfirmation($inscription));
            Mail::to(config('mail.from.address'))->queue(new NewPayment($inscription));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email paiement formation: ' . $e->getMessage());
        }

        return redirect()->route('formation.show', $inscription->formation_id)
            ->with('success', 'Paiement effectué avec succès! Bienvenue dans la formation.');
    }

    /**
     * Traiter le paiement via Lygos
     */
    public function lygos($inscription)
    {
        $inscription = FormationInscription::findOrFail($inscription);

        if ($inscription->user_id !== Auth::id()) {
            abort(403);
        }

        $formation = $inscription->formation;
        $montant = $inscription->montant_paye;

        return view('paiement.lygos', compact('inscription', 'formation', 'montant'));
    }

    /**
     * Callback Lygos - Vérifier et valider le paiement
     */
    public function lygosCallback(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $inscriptionId = $request->input('inscription_id');

        // TODO: Vérifier la transaction auprès de Lygos API

        $inscription = FormationInscription::findOrFail($inscriptionId);

        $inscription->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
        ]);

        // Envoyer les emails de confirmation de paiement
        try {
            Mail::to($inscription->user->email)->queue(new PaymentConfirmation($inscription));
            Mail::to(config('mail.from.address'))->queue(new NewPayment($inscription));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email paiement formation: ' . $e->getMessage());
        }

        return redirect()->route('formation.show', $inscription->formation_id)
            ->with('success', 'Paiement effectué avec succès! Bienvenue dans la formation.');
    }

    /**
     * Traiter le paiement via PayPal
     */
    public function paypal($inscription)
    {
        $inscription = FormationInscription::findOrFail($inscription);

        if ($inscription->user_id !== Auth::id()) {
            abort(403);
        }

        $formation = $inscription->formation;
        $montant = $inscription->montant_paye;

        return view('paiement.paypal', compact('inscription', 'formation', 'montant'));
    }

    /**
     * Callback PayPal - Vérifier et valider le paiement
     */
    public function paypalCallback(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $inscriptionId = $request->input('inscription_id');

        // TODO: Vérifier la transaction auprès de PayPal API

        $inscription = FormationInscription::findOrFail($inscriptionId);

        $inscription->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
        ]);

        // Envoyer les emails de confirmation de paiement
        try {
            Mail::to($inscription->user->email)->queue(new PaymentConfirmation($inscription));
            Mail::to(config('mail.from.address'))->queue(new NewPayment($inscription));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email paiement formation: ' . $e->getMessage());
        }

        return redirect()->route('formation.show', $inscription->formation_id)
            ->with('success', 'Paiement effectué avec succès! Bienvenue dans la formation.');
    }

    /**
     * Annulation du paiement
     */
    public function annuler($inscription)
    {
        $inscription = FormationInscription::findOrFail($inscription);

        if ($inscription->user_id !== Auth::id()) {
            abort(403);
        }

        return redirect()->route('formation.paiement', $inscription->formation_id)
            ->with('warning', 'Paiement annulé. Vous pouvez réessayer avec un autre moyen de paiement.');
    }

    // ========== Paiements pour les commandes (livres) ==========

    /**
     * Traiter le paiement Kkiapay pour une commande
     */
    public function catalogueKkiapay($commande)
    {
        $commande = \App\Models\Commande::findOrFail($commande);

        if ($commande->user_id !== Auth::id()) {
            abort(403);
        }

        $montant = $commande->total;

        return view('paiement.catalogue.kkiapay', compact('commande', 'montant'));
    }

    /**
     * Callback Kkiapay pour commande
     */
    public function catalogueKkiapayCallback(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $commandeId = $request->input('commande_id');

        $commande = \App\Models\Commande::findOrFail($commandeId);

        $commande->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
            'statut' => 'confirmee',
        ]);

        // Envoyer les emails de confirmation
        try {
            Mail::to($commande->user->email)->queue(new OrderConfirmation($commande));
            Mail::to(config('mail.from.address'))->queue(new NewOrder($commande));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email paiement commande: ' . $e->getMessage());
        }

        // Vider le panier de l'utilisateur
        Auth::user()->cartItems()->delete();

        return redirect()->route('account.commandes')
            ->with('success', 'Paiement effectué avec succès! Votre commande est confirmée.');
    }

    /**
     * Traiter le paiement Lygos pour une commande
     */
    public function catalogueLygos($commande)
    {
        $commande = \App\Models\Commande::findOrFail($commande);

        if ($commande->user_id !== Auth::id()) {
            abort(403);
        }

        $montant = $commande->total;

        return view('paiement.catalogue.lygos', compact('commande', 'montant'));
    }

    /**
     * Callback Lygos pour commande
     */
    public function catalogueLygosCallback(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $commandeId = $request->input('commande_id');

        $commande = \App\Models\Commande::findOrFail($commandeId);

        $commande->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
            'statut' => 'confirmee',
        ]);

        // Envoyer les emails de confirmation
        try {
            Mail::to($commande->user->email)->queue(new OrderConfirmation($commande));
            Mail::to(config('mail.from.address'))->queue(new NewOrder($commande));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email paiement commande: ' . $e->getMessage());
        }

        // Vider le panier de l'utilisateur
        Auth::user()->cartItems()->delete();

        return redirect()->route('account.commandes')
            ->with('success', 'Paiement effectué avec succès! Votre commande est confirmée.');
    }

    /**
     * Traiter le paiement PayPal pour une commande
     */
    public function cataloguePaypal($commande)
    {
        $commande = \App\Models\Commande::findOrFail($commande);

        if ($commande->user_id !== Auth::id()) {
            abort(403);
        }

        $montant = $commande->total;

        return view('paiement.catalogue.paypal', compact('commande', 'montant'));
    }

    /**
     * Callback PayPal pour commande
     */
    public function cataloguePaypalCallback(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $commandeId = $request->input('commande_id');

        $commande = \App\Models\Commande::findOrFail($commandeId);

        $commande->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
            'statut' => 'confirmee',
        ]);

        // Envoyer les emails de confirmation
        try {
            Mail::to($commande->user->email)->queue(new OrderConfirmation($commande));
            Mail::to(config('mail.from.address'))->queue(new NewOrder($commande));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email paiement commande: ' . $e->getMessage());
        }

        // Vider le panier de l'utilisateur
        Auth::user()->cartItems()->delete();

        return redirect()->route('account.commandes')
            ->with('success', 'Paiement effectué avec succès! Votre commande est confirmée.');
    }
}
