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
        Schema::create('formation_inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            $table->decimal('montant_paye', 10, 2);
            $table->enum('statut', ['en_cours', 'termine', 'abandonne'])->default('en_cours');
            $table->integer('progression')->default(0); // Pourcentage de progression (0-100)
            $table->timestamp('date_inscription')->useCurrent();
            $table->timestamp('date_fin')->nullable();
            $table->boolean('paiement_valide')->default(false);
            $table->string('reference_paiement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formation_inscriptions');
    }
};
