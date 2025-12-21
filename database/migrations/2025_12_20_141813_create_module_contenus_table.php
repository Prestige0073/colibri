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
        Schema::create('module_contenus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['video', 'pdf', 'audio', 'image', 'texte']);
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('fichier')->nullable(); // Chemin du fichier uploadé
            $table->text('contenu')->nullable(); // Pour le type texte
            $table->string('duree')->nullable(); // Pour vidéo et audio
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_contenus');
    }
};
