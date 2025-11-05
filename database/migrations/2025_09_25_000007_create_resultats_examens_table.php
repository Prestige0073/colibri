<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('resultats_examens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('examen_id')->constrained('examens')->onDelete('cascade');
            $table->integer('score');
            $table->dateTime('date_passage');
            $table->boolean('reussi')->default(false);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('resultats_examens');
    }
};
