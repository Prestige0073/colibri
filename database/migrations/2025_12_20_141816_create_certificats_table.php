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
        Schema::create('certificats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_inscription_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            $table->string('numero_certificat')->unique(); // Ex: CERT-2024-00001
            $table->string('fichier_pdf')->nullable(); // Chemin du PDF généré
            $table->integer('note_obtenue');
            $table->timestamp('date_delivrance')->useCurrent();
            $table->boolean('envoye_email')->default(false);
            $table->timestamp('date_envoi_email')->nullable();
            $table->enum('statut', ['genere', 'envoye', 'reclame'])->default('genere');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificats');
    }
};
