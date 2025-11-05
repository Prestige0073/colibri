<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('catalogues', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('auteur');
            $table->string('categorie');
            $table->integer('prix');
            $table->integer('quantite')->default(0);
            $table->string('type')->default('catalogue'); // 'catalogue' ou 'emprunt'
            $table->string('type_categorie')->default('catalogue');
            $table->text('resumer');
            $table->string('image');
            $table->string('pdf');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalogues');
    }
};
