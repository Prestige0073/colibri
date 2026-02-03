<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reason');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('blocked_at');
            $table->timestamp('unblocked_at')->nullable();
            $table->foreignId('unblocked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['user_id', 'blocked_at']);
        });

        // Table pour les logs de tentatives de capture
        Schema::create('security_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type', 50); // screenshot_attempt, devtools_opened, etc.
            $table->unsignedInteger('document_id')->nullable();
            $table->string('document_type', 50)->nullable(); // catalogue, formation, emprunt
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->json('details')->nullable();
            $table->timestamp('created_at');

            $table->index(['user_id', 'created_at']);
            $table->index(['type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_attempts');
        Schema::dropIfExists('security_blocks');
    }
};
