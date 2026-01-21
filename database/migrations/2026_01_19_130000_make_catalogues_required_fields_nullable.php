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
        Schema::table('catalogues', function (Blueprint $table) {
            $table->string('titre')->nullable()->change();
            $table->string('auteur')->nullable()->change();
            $table->string('categorie')->nullable()->change();
            $table->integer('prix')->nullable()->change();
            $table->integer('quantite')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalogues', function (Blueprint $table) {
            $table->string('titre')->nullable(false)->change();
            $table->string('auteur')->nullable(false)->change();
            $table->string('categorie')->nullable(false)->change();
            $table->integer('prix')->nullable(false)->change();
            $table->integer('quantite')->nullable(false)->change();
        });
    }
};
