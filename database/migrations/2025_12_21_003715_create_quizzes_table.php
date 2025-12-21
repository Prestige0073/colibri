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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable()->constrained('modules')->onDelete('cascade');
            $table->foreignId('formation_id')->nullable()->constrained('formations')->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->integer('duree_minutes')->nullable()->comment('Durée en minutes pour compléter le quiz');
            $table->integer('note_passage')->default(50)->comment('Note minimale pour réussir (en %)');
            $table->integer('nombre_tentatives')->default(3)->comment('Nombre de tentatives autorisées');
            $table->boolean('afficher_reponses')->default(true)->comment('Afficher les bonnes réponses après la soumission');
            $table->boolean('melanger_questions')->default(false)->comment('Mélanger l\'ordre des questions');
            $table->boolean('melanger_options')->default(false)->comment('Mélanger l\'ordre des options');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
