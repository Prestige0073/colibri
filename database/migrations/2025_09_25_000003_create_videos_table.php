<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('url');
            $table->integer('ordre')->default(1);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('videos');
    }
};
