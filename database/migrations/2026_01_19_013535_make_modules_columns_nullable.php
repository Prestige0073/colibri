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
        Schema::table('modules', function (Blueprint $table) {
            $table->foreignId('formation_id')->nullable()->change();
            $table->string('titre')->nullable()->change();
            $table->integer('ordre')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->foreignId('formation_id')->nullable(false)->change();
            $table->string('titre')->nullable(false)->change();
            $table->integer('ordre')->nullable(false)->change();
        });
    }
};
