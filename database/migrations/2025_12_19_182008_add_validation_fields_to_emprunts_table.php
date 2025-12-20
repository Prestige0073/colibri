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
        Schema::table('emprunts', function (Blueprint $table) {
            // Ajouter le champ validé_par pour savoir quel admin a validé
            $table->unsignedBigInteger('valide_par')->nullable()->after('statut');
            $table->timestamp('valide_le')->nullable()->after('valide_par');

            // Modifier les valeurs possibles du statut pour inclure 'en_attente'
            // Note: Nous allons mettre à jour les données existantes après
        });

        // Mettre à jour tous les emprunts existants en 'en_cours' pour être validés automatiquement
        DB::statement("UPDATE emprunts SET valide_le = NOW() WHERE statut = 'en_cours'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->dropColumn(['valide_par', 'valide_le']);
        });
    }
};
