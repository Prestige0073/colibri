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
            // Ajouter les colonnes manquantes si elles n'existent pas
            if (!Schema::hasColumn('commandes', 'paiement_valide')) {
                $table->boolean('paiement_valide')->default(false)->after('statut');
            }
            if (!Schema::hasColumn('commandes', 'reference_paiement')) {
                $table->string('reference_paiement')->nullable()->after('paiement_valide');
            }
            if (!Schema::hasColumn('commandes', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('reference_paiement');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (Schema::hasColumn('commandes', 'paiement_valide')) {
                $table->dropColumn('paiement_valide');
            }
            if (Schema::hasColumn('commandes', 'reference_paiement')) {
                $table->dropColumn('reference_paiement');
            }
            if (Schema::hasColumn('commandes', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
        });
    }
};
