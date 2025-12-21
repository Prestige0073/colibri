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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->text('question');
            $table->enum('type', ['qcm', 'vrai_faux', 'choix_multiple'])->default('qcm')->comment('qcm=une seule réponse, choix_multiple=plusieurs réponses');
            $table->integer('points')->default(1)->comment('Points attribués pour cette question');
            $table->integer('ordre')->default(0);
            $table->text('explication')->nullable()->comment('Explication affichée après la réponse');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
