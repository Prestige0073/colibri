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

        $inscription = FormationInscription::with('user')->findOrFail($inscriptionId);

        // Authentifier l'utilisateur automatiquement s'il ne l'est pas déjà
        if (!Auth::check() || Auth::id() !== $inscription->user_id) {
            Auth::login($inscription->user);
            Log::info('Callback KKiaPay Formation: Utilisateur authentifié automatiquement', [
                'user_id' => $inscription->user_id
            ]);
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

        Log::info('Callback PayPal Formation reçu', [
            'transaction_id' => $transactionId,
            'inscription_id' => $inscriptionId
        ]);

        // Validation des paramètres
        if (!$transactionId || !$inscriptionId) {
            Log::error('Callback PayPal Formation: Paramètres manquants');
            return redirect()->route('formation.modules')
                ->with('error', 'Erreur: Paramètres de paiement manquants');
        }

        $inscription = FormationInscription::with('user')->findOrFail($inscriptionId);

        // Authentifier l'utilisateur automatiquement s'il ne l'est pas déjà
        if (!Auth::check() || Auth::id() !== $inscription->user_id) {
            Auth::login($inscription->user);
            Log::info('Callback PayPal Formation: Utilisateur authentifié automatiquement', [
                'user_id' => $inscription->user_id
            ]);
        }

        // Vérifier si le paiement n'est pas déjà validé
        if ($inscription->paiement_valide) {
            Log::info('Callback PayPal Formation: Paiement déjà validé', [
                'inscription_id' => $inscriptionId
            ]);
            return redirect()->route('formation.show', $inscription->formation_id)
                ->with('info', 'Ce paiement a déjà été validé.');
        }

        // Vérifier la transaction auprès de PayPal API
        $paypalVerified = $this->verifyPayPalTransaction($transactionId, $inscription->montant_paye);

        if (!$paypalVerified) {
            Log::error('Callback PayPal Formation: Transaction non validée par PayPal', [
                'transaction_id' => $transactionId
            ]);
            return redirect()->route('formation.paiement', $inscription->formation_id)
                ->with('error', 'Paiement non validé par PayPal. Veuillez réessayer.');
        }

        // TOUT EST VALIDÉ - On peut maintenant enregistrer le paiement
        $inscription->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
        ]);

        Log::info('Callback PayPal Formation: Paiement validé avec succès', [
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

        $commande = \App\Models\Commande::with('user')->findOrFail($commandeId);

        // Authentifier l'utilisateur automatiquement s'il ne l'est pas déjà
        if (!Auth::check() || Auth::id() !== $commande->user_id) {
            Auth::login($commande->user);
            Log::info('Callback KKiaPay Catalogue: Utilisateur authentifié automatiquement', [
                'user_id' => $commande->user_id
            ]);
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
        // En mode sandbox/développement, on bypass la vérification car l'API peut être instable
        $isSandbox = config('services.kkiapay.sandbox', true);
        $isTestTransaction = str_starts_with($transactionId, 'TEST_') || str_starts_with($transactionId, 'test_');

        if (!$isSandbox && !$isTestTransaction) {
            // EN PRODUCTION: Vérification stricte via API KKiaPay
            if (!$kkiapay->isTransactionSuccessful($transactionId)) {
                Log::error('Callback KKiaPay Catalogue: Transaction non validée par KKiaPay', [
                    'transaction_id' => $transactionId
                ]);
                return redirect()->route('paiement.show')
                    ->with('error', 'Paiement non validé. Veuillez réessayer.');
            }

            // Vérifier le montant de la transaction
            if (!$kkiapay->verifyTransactionAmount($transactionId, $commande->total)) {
                Log::error('Callback KKiaPay Catalogue: Montant incorrect', [
                    'transaction_id' => $transactionId,
                    'expected' => $commande->total
                ]);
                return redirect()->route('paiement.show')
                    ->with('error', 'Erreur: Le montant du paiement ne correspond pas.');
            }
        } else {
            // EN SANDBOX/TEST: Validation automatique
            Log::info('Callback KKiaPay Catalogue: Mode sandbox - validation automatique', [
                'transaction_id' => $transactionId,
                'sandbox' => $isSandbox,
                'is_test' => $isTestTransaction
            ]);
        }

        // TOUT EST VALIDÉ - On peut maintenant enregistrer le paiement
        $commande->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
            'statut' => \App\Models\Commande::STATUT_CONFIRMED,
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
        $cartItemsDeleted = Auth::user()->cartItems()->delete();

        Log::info('Callback KKiaPay Catalogue: Panier vidé', [
            'user_id' => Auth::id(),
            'items_deleted' => $cartItemsDeleted
        ]);

        return redirect()->route('account.commandes', ['payment_success' => $commande->id])
            ->with('success', 'Paiement effectué avec succès! Votre commande est confirmée.')
            ->with('paid_commande_id', $commande->id);
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

        Log::info('Callback PayPal Catalogue reçu', [
            'transaction_id' => $transactionId,
            'commande_id' => $commandeId
        ]);

        // Validation des paramètres
        if (!$transactionId || !$commandeId) {
            Log::error('Callback PayPal Catalogue: Paramètres manquants');
            return redirect()->route('panier.index')
                ->with('error', 'Erreur: Paramètres de paiement manquants');
        }

        $commande = \App\Models\Commande::with('user')->findOrFail($commandeId);

        // Authentifier l'utilisateur automatiquement s'il ne l'est pas déjà
        if (!Auth::check() || Auth::id() !== $commande->user_id) {
            Auth::login($commande->user);
            Log::info('Callback PayPal Catalogue: Utilisateur authentifié automatiquement', [
                'user_id' => $commande->user_id
            ]);
        }

        // Vérifier si le paiement n'est pas déjà validé
        if ($commande->paiement_valide) {
            Log::info('Callback PayPal Catalogue: Paiement déjà validé', [
                'commande_id' => $commandeId
            ]);
            return redirect()->route('account.commandes')
                ->with('info', 'Ce paiement a déjà été validé.');
        }

        // Vérifier la transaction auprès de PayPal API
        $paypalVerified = $this->verifyPayPalTransaction($transactionId, $commande->total);

        if (!$paypalVerified) {
            Log::error('Callback PayPal Catalogue: Transaction non validée par PayPal', [
                'transaction_id' => $transactionId
            ]);
            return redirect()->route('paiement.show')
                ->with('error', 'Paiement non validé par PayPal. Veuillez réessayer.');
        }

        // TOUT EST VALIDÉ - On peut maintenant enregistrer le paiement
        $commande->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
            'statut' => \App\Models\Commande::STATUT_CONFIRMED,
            'payment_method' => 'paypal',
        ]);

        Log::info('Callback PayPal Catalogue: Paiement validé avec succès', [
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

        return redirect()->route('account.commandes', ['payment_success' => $commande->id])
            ->with('success', 'Paiement effectué avec succès! Votre commande est confirmée.')
            ->with('paid_commande_id', $commande->id);
    }

    /**
     * Vérifier une transaction PayPal
     */
    private function verifyPayPalTransaction($transactionId, $expectedAmount)
    {
        try {
            // Configuration PayPal
            $clientId = config('services.paypal.client_id');
            $clientSecret = config('services.paypal.client_secret');
            $sandbox = config('services.paypal.sandbox', true);

            // Si pas de configuration PayPal, on log et on refuse
            if (empty($clientId) || empty($clientSecret)) {
                Log::warning('PayPal: Configuration manquante, vérification impossible');
                return false;
            }

            $baseUrl = $sandbox
                ? 'https://api-m.sandbox.paypal.com'
                : 'https://api-m.paypal.com';

            // Obtenir le token d'accès
            $tokenResponse = \Illuminate\Support\Facades\Http::withBasicAuth($clientId, $clientSecret)
                ->asForm()
                ->post("{$baseUrl}/v1/oauth2/token", [
                    'grant_type' => 'client_credentials'
                ]);

            if (!$tokenResponse->successful()) {
                Log::error('PayPal: Échec obtention token', [
                    'status' => $tokenResponse->status(),
                    'body' => $tokenResponse->body()
                ]);
                return false;
            }

            $accessToken = $tokenResponse->json()['access_token'];

            // Vérifier la transaction
            $orderResponse = \Illuminate\Support\Facades\Http::withToken($accessToken)
                ->get("{$baseUrl}/v2/checkout/orders/{$transactionId}");

            if (!$orderResponse->successful()) {
                Log::error('PayPal: Transaction non trouvée', [
                    'transaction_id' => $transactionId,
                    'status' => $orderResponse->status()
                ]);
                return false;
            }

            $orderData = $orderResponse->json();

            // Vérifier le statut
            if (!in_array($orderData['status'] ?? '', ['COMPLETED', 'APPROVED'])) {
                Log::error('PayPal: Statut transaction invalide', [
                    'transaction_id' => $transactionId,
                    'status' => $orderData['status'] ?? 'unknown'
                ]);
                return false;
            }

            // Vérifier le montant
            $paidAmount = 0;
            if (isset($orderData['purchase_units'][0]['amount']['value'])) {
                $paidAmount = floatval($orderData['purchase_units'][0]['amount']['value']);
            }

            if (abs($paidAmount - $expectedAmount) > 1) {
                Log::error('PayPal: Montant incorrect', [
                    'transaction_id' => $transactionId,
                    'expected' => $expectedAmount,
                    'paid' => $paidAmount
                ]);
                return false;
            }

            Log::info('PayPal: Transaction vérifiée avec succès', [
                'transaction_id' => $transactionId,
                'amount' => $paidAmount
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('PayPal: Exception lors de la vérification', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
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
            'statut' => \App\Models\Commande::STATUT_CONFIRMED,
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

        return redirect()->route('account.commandes', ['payment_success' => $commande->id])
            ->with('success', 'Paiement TEST effectué avec succès! Votre commande est confirmée. (Référence: ' . $reference . ')')
            ->with('paid_commande_id', $commande->id);
    }
}
