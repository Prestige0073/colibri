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
        Schema::table('formations', function (Blueprint $table) {
            // Rendre les champs nullable pour permettre la soumission de formulaires vides
            $table->string('titre')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->decimal('prix', 10, 2)->nullable()->change();
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            // Remettre les champs comme non-nullable
            $table->string('titre')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->decimal('prix', 10, 2)->nullable(false)->change();
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance'])->nullable(false)->change();
        });
    }
};
