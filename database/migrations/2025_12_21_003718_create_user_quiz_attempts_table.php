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
        Schema::create('user_quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->json('reponses')->comment('Réponses de l\'utilisateur au format JSON');
            $table->decimal('score', 5, 2)->comment('Score obtenu (en %)');
            $table->integer('points_obtenus')->comment('Points obtenus');
            $table->integer('points_total')->comment('Total des points possibles');
            $table->boolean('reussi')->default(false)->comment('Quiz réussi ou non');
            $table->timestamp('debut_at')->nullable();
            $table->timestamp('fin_at')->nullable();
            $table->integer('duree_secondes')->nullable()->comment('Temps mis pour compléter (en secondes)');
            $table->timestamps();

            $table->index(['user_id', 'quiz_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_quiz_attempts');
    }
};
