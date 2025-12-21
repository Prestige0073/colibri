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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_inscription_id')->constrained()->onDelete('cascade');
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('note')->default(0); // Note sur 100
            $table->integer('nombre_questions')->default(0);
            $table->integer('reponses_correctes')->default(0);
            $table->json('reponses')->nullable(); // Stockage des réponses
            $table->timestamp('date_evaluation')->useCurrent();
            $table->boolean('reussie')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
