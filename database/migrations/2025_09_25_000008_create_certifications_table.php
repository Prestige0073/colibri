<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
            $table->dateTime('date_obtention');
            $table->string('code_certificat')->unique();
            $table->dateTime('validite')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('certifications');
    }
};
