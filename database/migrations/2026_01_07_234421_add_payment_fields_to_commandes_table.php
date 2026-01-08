<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            // Champs pour le paiement KKiaPay et PayPal
            $table->boolean('paiement_valide')->default(false)->after('statut');
            $table->string('reference_paiement')->nullable()->after('paiement_valide');
            $table->string('payment_method')->nullable()->after('reference_paiement'); // 'kkiapay' ou 'paypal'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn(['paiement_valide', 'reference_paiement', 'payment_method']);
        });
    }
};
