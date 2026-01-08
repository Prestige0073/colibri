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
use App\Services\KkiapayService;
use Illuminate\Support\Facades\Log;

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
    public function kkiapayCallback(Request $request, KkiapayService $kkiapay)
    {
        $transactionId = $request->input('transaction_id');
        $inscriptionId = $request->input('inscription_id');

        Log::info('Callback KKiaPay Formation reçu', [
            'transaction_id' => $transactionId,
            'inscription_id' => $inscriptionId
        ]);

        // Validation des paramètres
        if (!$transactionId || !$inscriptionId) {
            Log::error('Callback KKiaPay Formation: Paramètres manquants');
            return redirect()->route('formation.modules')
                ->with('error', 'Erreur: Paramètres de paiement manquants');
        }

        $inscription = FormationInscription::findOrFail($inscriptionId);

        // Vérifier que l'inscription appartient à l'utilisateur connecté
        if ($inscription->user_id !== Auth::id()) {
            Log::error('Callback KKiaPay Formation: Utilisateur non autorisé', [
                'inscription_user_id' => $inscription->user_id,
                'auth_user_id' => Auth::id()
            ]);
            abort(403, 'Accès non autorisé');
        }

        // Vérifier si le paiement n'est pas déjà validé
        if ($inscription->paiement_valide) {
            Log::info('Callback KKiaPay Formation: Paiement déjà validé', [
                'inscription_id' => $inscriptionId
            ]);
            return redirect()->route('formation.show', $inscription->formation_id)
                ->with('info', 'Ce paiement a déjà été validé.');
        }

        // ÉTAPE CRITIQUE: Vérifier la transaction auprès de l'API KKiaPay
        if (!$kkiapay->isTransactionSuccessful($transactionId)) {
            Log::error('Callback KKiaPay Formation: Transaction non validée par KKiaPay', [
                'transaction_id' => $transactionId
            ]);
            return redirect()->route('formation.paiement', $inscription->formation_id)
                ->with('error', 'Paiement non validé. Veuillez réessayer.');
        }

        // Vérifier le montant de la transaction
        if (!$kkiapay->verifyTransactionAmount($transactionId, $inscription->montant_paye)) {
            Log::error('Callback KKiaPay Formation: Montant incorrect', [
                'transaction_id' => $transactionId,
                'expected' => $inscription->montant_paye
            ]);
            return redirect()->route('formation.paiement', $inscription->formation_id)
                ->with('error', 'Erreur: Le montant du paiement ne correspond pas.');
        }

        // TOUT EST VALIDÉ - On peut maintenant enregistrer le paiement
        $inscription->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
        ]);

        Log::info('Callback KKiaPay Formation: Paiement validé avec succès', [
            'inscription_id' => $inscriptionId,
            'transaction_id' => $transactionId
        ]);

        // Envoyer les emails de confirmation de paiement
        try {
            Mail::to($inscription->user->email)->queue(new PaymentConfirmation($inscription));
            Mail::to(config('mail.from.address'))->queue(new NewPayment($inscription));
        } catch (\Exception $e) {
            Log::error('Erreur envoi email paiement formation: ' . $e->getMessage());
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
        $commande = \App\Models\Commande::with('items')->findOrFail($commande);

        if ($commande->user_id !== Auth::id()) {
            abort(403);
        }

        $montant = $commande->total;

        return view('paiement.catalogue.kkiapay', compact('commande', 'montant'));
    }

    /**
     * Callback Kkiapay pour commande
     */
    public function catalogueKkiapayCallback(Request $request, KkiapayService $kkiapay)
    {
        $transactionId = $request->input('transaction_id');
        $commandeId = $request->input('commande_id');

        Log::info('Callback KKiaPay Catalogue reçu', [
            'transaction_id' => $transactionId,
            'commande_id' => $commandeId
        ]);

        // Validation des paramètres
        if (!$transactionId || !$commandeId) {
            Log::error('Callback KKiaPay Catalogue: Paramètres manquants');
            return redirect()->route('panier.index')
                ->with('error', 'Erreur: Paramètres de paiement manquants');
        }

        $commande = \App\Models\Commande::findOrFail($commandeId);

        // Vérifier que la commande appartient à l'utilisateur connecté
        if ($commande->user_id !== Auth::id()) {
            Log::error('Callback KKiaPay Catalogue: Utilisateur non autorisé', [
                'commande_user_id' => $commande->user_id,
                'auth_user_id' => Auth::id()
            ]);
            abort(403, 'Accès non autorisé');
        }

        // Vérifier si le paiement n'est pas déjà validé
        if ($commande->paiement_valide) {
            Log::info('Callback KKiaPay Catalogue: Paiement déjà validé', [
                'commande_id' => $commandeId
            ]);
            return redirect()->route('account.commandes')
                ->with('info', 'Ce paiement a déjà été validé.');
        }

        // ÉTAPE CRITIQUE: Vérifier la transaction auprès de l'API KKiaPay
        if (!$kkiapay->isTransactionSuccessful($transactionId)) {
            Log::error('Callback KKiaPay Catalogue: Transaction non validée par KKiaPay', [
                'transaction_id' => $transactionId
            ]);
            return redirect()->route('panier.paiement')
                ->with('error', 'Paiement non validé. Veuillez réessayer.');
        }

        // Vérifier le montant de la transaction
        if (!$kkiapay->verifyTransactionAmount($transactionId, $commande->total)) {
            Log::error('Callback KKiaPay Catalogue: Montant incorrect', [
                'transaction_id' => $transactionId,
                'expected' => $commande->total
            ]);
            return redirect()->route('panier.paiement')
                ->with('error', 'Erreur: Le montant du paiement ne correspond pas.');
        }

        // TOUT EST VALIDÉ - On peut maintenant enregistrer le paiement
        $commande->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
            'statut' => 'confirmee',
        ]);

        Log::info('Callback KKiaPay Catalogue: Paiement validé avec succès', [
            'commande_id' => $commandeId,
            'transaction_id' => $transactionId
        ]);

        // Envoyer les emails de confirmation
        try {
            Mail::to($commande->user->email)->queue(new OrderConfirmation($commande));
            Mail::to(config('mail.from.address'))->queue(new NewOrder($commande));
        } catch (\Exception $e) {
            Log::error('Erreur envoi email paiement commande: ' . $e->getMessage());
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
        $commande = \App\Models\Commande::with('items')->findOrFail($commande);

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

    // ========== MODE TEST/SIMULATION ==========

    /**
     * Paiement TEST pour les formations
     */
    public function testFormation($inscription)
    {
        $inscription = FormationInscription::findOrFail($inscription);

        if ($inscription->user_id !== Auth::id()) {
            abort(403);
        }

        $formation = $inscription->formation;
        $montant = $inscription->montant_paye;

        return view('paiement.test-formation', compact('inscription', 'formation', 'montant'));
    }

    /**
     * Valider le paiement TEST pour formation
     */
    public function testFormationValidate(Request $request, $inscription)
    {
        $inscription = FormationInscription::findOrFail($inscription);

        if ($inscription->user_id !== Auth::id()) {
            abort(403);
        }

        // Vérifier si le paiement n'est pas déjà validé
        if ($inscription->paiement_valide) {
            return redirect()->route('formation.show', $inscription->formation_id)
                ->with('info', 'Ce paiement a déjà été validé.');
        }

        // Générer une référence de test
        $reference = 'TEST-' . strtoupper(uniqid());

        // Valider le paiement
        $inscription->update([
            'paiement_valide' => true,
            'reference_paiement' => $reference,
        ]);

        Log::info('Paiement TEST Formation validé', [
            'inscription_id' => $inscription->id,
            'reference' => $reference
        ]);

        // Envoyer les emails de confirmation
        try {
            Mail::to($inscription->user->email)->queue(new PaymentConfirmation($inscription));
            Mail::to(config('mail.from.address'))->queue(new NewPayment($inscription));
        } catch (\Exception $e) {
            Log::error('Erreur envoi email paiement TEST formation: ' . $e->getMessage());
        }

        return redirect()->route('formation.show', $inscription->formation_id)
            ->with('success', 'Paiement TEST effectué avec succès! Bienvenue dans la formation. (Référence: ' . $reference . ')');
    }

    /**
     * Paiement TEST pour les commandes
     */
    public function testCatalogue($commande)
    {
        $commande = \App\Models\Commande::with('items')->findOrFail($commande);

        if ($commande->user_id !== Auth::id()) {
            abort(403);
        }

        $montant = $commande->total;

        return view('paiement.test-catalogue', compact('commande', 'montant'));
    }

    /**
     * Valider le paiement TEST pour commande
     */
    public function testCatalogueValidate(Request $request, $commande)
    {
        $commande = \App\Models\Commande::findOrFail($commande);

        if ($commande->user_id !== Auth::id()) {
            abort(403);
        }

        // Vérifier si le paiement n'est pas déjà validé
        if ($commande->paiement_valide) {
            return redirect()->route('account.commandes')
                ->with('info', 'Ce paiement a déjà été validé.');
        }

        // Générer une référence de test
        $reference = 'TEST-' . strtoupper(uniqid());

        // Valider le paiement
        $commande->update([
            'paiement_valide' => true,
            'reference_paiement' => $reference,
            'statut' => 'confirmee',
            'payment_method' => 'test',
        ]);

        Log::info('Paiement TEST Catalogue validé', [
            'commande_id' => $commande->id,
            'reference' => $reference
        ]);

        // Envoyer les emails de confirmation
        try {
            Mail::to($commande->user->email)->queue(new OrderConfirmation($commande));
            Mail::to(config('mail.from.address'))->queue(new NewOrder($commande));
        } catch (\Exception $e) {
            Log::error('Erreur envoi email paiement TEST commande: ' . $e->getMessage());
        }

        // Vider le panier de l'utilisateur
        Auth::user()->cartItems()->delete();

        return redirect()->route('account.commandes')
            ->with('success', 'Paiement TEST effectué avec succès! Votre commande est confirmée. (Référence: ' . $reference . ')');
    }
}
