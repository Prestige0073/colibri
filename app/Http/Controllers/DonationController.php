<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\KkiapayService;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        return view('donation');
    }

    /**
     * Callback KKiaPay - enregistrer le don après paiement réussi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|string',
            'amount' => 'required|integer|min:100',
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email|max:255',
        ]);

        // Vérifier que la transaction n'existe pas déjà
        if (Donation::where('transaction_id', $validated['transaction_id'])->exists()) {
            return response()->json(['message' => 'Don déjà enregistré.'], 200);
        }

        // Le callback success de KKiaPay côté front confirme le paiement
        // On tente aussi une vérification serveur pour plus de sécurité
        $status = 'completed';
        try {
            $kkiapay = new KkiapayService();
            $transaction = $kkiapay->verifyTransaction($validated['transaction_id']);
            if ($transaction && isset($transaction['status'])) {
                $apiStatus = strtoupper($transaction['status']);
                if (in_array($apiStatus, ['FAILED', 'CANCELLED', 'REFUNDED'])) {
                    $status = 'failed';
                }
            }
        } catch (\Exception $e) {
            // En cas d'erreur API, on garde completed car KKiaPay front a confirmé
        }

        $donation = Donation::create([
            'donor_name' => $validated['donor_name'] ?? null,
            'donor_email' => $validated['donor_email'] ?? null,
            'amount' => $validated['amount'],
            'transaction_id' => $validated['transaction_id'],
            'payment_method' => 'kkiapay',
            'status' => $status,
        ]);

        return response()->json([
            'message' => 'Don enregistré avec succès.',
            'donation' => $donation,
        ], 201);
    }

    public function create() {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
