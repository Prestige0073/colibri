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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->text('objectifs')->nullable();
            $table->string('image')->nullable();
            $table->decimal('prix', 10, 2);
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance']);
            $table->string('duree')->nullable(); // ex: "10 heures"
            $table->integer('nombre_modules')->default(0);
            $table->boolean('active')->default(true);
            $table->string('categorie')->nullable();
            $table->text('prerequis')->nullable();
            $table->integer('note_minimale_certification')->default(70); // Note minimale pour obtenir le certificat
            $table->integer('inscrits_count')->default(0); // Nombre d'inscrits
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
