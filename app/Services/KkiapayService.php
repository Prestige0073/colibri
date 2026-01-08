<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class KkiapayService
{
    protected $publicKey;
    protected $privateKey;
    protected $secret;
    protected $sandbox;
    protected $baseUrl;

    public function __construct()
    {
        $this->publicKey = config('services.kkiapay.public_key');
        $this->privateKey = config('services.kkiapay.private_key');
        $this->secret = config('services.kkiapay.secret');
        $this->sandbox = config('services.kkiapay.sandbox', true);

        // URL de l'API KKiaPay
        $this->baseUrl = $this->sandbox
            ? 'https://api-sandbox.kkiapay.me'
            : 'https://api.kkiapay.me';
    }

    /**
     * Vérifier une transaction auprès de l'API KKiaPay
     *
     * @param string $transactionId
     * @return array|null
     */
    public function verifyTransaction($transactionId)
    {
        try {
            Log::info('KKiaPay: Vérification de la transaction', [
                'transaction_id' => $transactionId,
                'sandbox' => $this->sandbox
            ]);

            $response = Http::withHeaders([
                'x-api-key' => $this->privateKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get("{$this->baseUrl}/api/v1/transactions/{$transactionId}");

            if ($response->successful()) {
                $data = $response->json();

                Log::info('KKiaPay: Transaction vérifiée avec succès', [
                    'transaction_id' => $transactionId,
                    'status' => $data['status'] ?? 'unknown'
                ]);

                return $data;
            }

            Log::error('KKiaPay: Erreur lors de la vérification', [
                'transaction_id' => $transactionId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (Exception $e) {
            Log::error('KKiaPay: Exception lors de la vérification', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Vérifier si une transaction est réussie
     *
     * @param string $transactionId
     * @return bool
     */
    public function isTransactionSuccessful($transactionId)
    {
        $transaction = $this->verifyTransaction($transactionId);

        if (!$transaction) {
            return false;
        }

        // Vérifier le statut de la transaction
        $status = $transaction['status'] ?? '';

        return in_array(strtoupper($status), ['SUCCESS', 'SUCCESSFUL', 'COMPLETED']);
    }

    /**
     * Vérifier le montant d'une transaction
     *
     * @param string $transactionId
     * @param float $expectedAmount
     * @return bool
     */
    public function verifyTransactionAmount($transactionId, $expectedAmount)
    {
        $transaction = $this->verifyTransaction($transactionId);

        if (!$transaction) {
            return false;
        }

        $actualAmount = $transaction['amount'] ?? 0;

        // Comparer les montants (tolérance de 1 FCFA pour les arrondis)
        return abs($actualAmount - $expectedAmount) < 1;
    }

    /**
     * Effectuer un remboursement
     *
     * @param string $transactionId
     * @return array|null
     */
    public function refundTransaction($transactionId)
    {
        try {
            Log::info('KKiaPay: Tentative de remboursement', [
                'transaction_id' => $transactionId
            ]);

            $response = Http::withHeaders([
                'x-api-key' => $this->privateKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post("{$this->baseUrl}/api/v1/transactions/{$transactionId}/refund");

            if ($response->successful()) {
                $data = $response->json();

                Log::info('KKiaPay: Remboursement effectué', [
                    'transaction_id' => $transactionId,
                    'data' => $data
                ]);

                return $data;
            }

            Log::error('KKiaPay: Erreur lors du remboursement', [
                'transaction_id' => $transactionId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (Exception $e) {
            Log::error('KKiaPay: Exception lors du remboursement', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Obtenir la clé publique
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Vérifier si le mode sandbox est activé
     *
     * @return bool
     */
    public function isSandbox()
    {
        return $this->sandbox;
    }

    /**
     * Valider les données du webhook
     *
     * @param array $data
     * @return bool
     */
    public function validateWebhook($data)
    {
        // Vérifier que les champs requis sont présents
        $requiredFields = ['transactionId', 'status'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                Log::warning('KKiaPay: Champ manquant dans le webhook', [
                    'field' => $field,
                    'data' => $data
                ]);
                return false;
            }
        }

        // Vérifier la signature si elle est fournie
        if (isset($data['signature']) && $this->secret) {
            $expectedSignature = hash_hmac('sha256', json_encode($data), $this->secret);

            if ($data['signature'] !== $expectedSignature) {
                Log::warning('KKiaPay: Signature invalide', [
                    'expected' => $expectedSignature,
                    'received' => $data['signature']
                ]);
                return false;
            }
        }

        return true;
    }
}
