<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL ne permet pas de modifier directement un ENUM, il faut utiliser une commande raw
        DB::statement("ALTER TABLE certificats MODIFY COLUMN statut ENUM('genere', 'envoye', 'reclame', 'valide', 'annule') DEFAULT 'genere'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenir à l'ancien ENUM
        DB::statement("ALTER TABLE certificats MODIFY COLUMN statut ENUM('genere', 'envoye', 'reclame') DEFAULT 'genere'");
    }
};
