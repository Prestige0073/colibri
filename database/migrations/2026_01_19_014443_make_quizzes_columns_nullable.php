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
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('titre')->nullable()->change();
            $table->integer('note_passage')->nullable()->change();
            $table->integer('nombre_tentatives')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('titre')->nullable(false)->change();
            $table->integer('note_passage')->nullable(false)->change();
            $table->integer('nombre_tentatives')->nullable(false)->change();
        });
    }
};
