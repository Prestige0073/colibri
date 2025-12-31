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
        Schema::table('user_quiz_attempts', function (Blueprint $table) {
            $table->decimal('score', 5, 2)->nullable()->change();
            $table->integer('points_obtenus')->nullable()->change();
            $table->integer('points_total')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_quiz_attempts', function (Blueprint $table) {
            $table->decimal('score', 5, 2)->nullable(false)->change();
            $table->integer('points_obtenus')->nullable(false)->change();
            $table->integer('points_total')->nullable(false)->change();
        });
    }
};
