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
            $table->text('resumer')->nullable()->change();
            $table->string('image')->nullable()->change();
            $table->string('pdf')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalogues', function (Blueprint $table) {
            $table->text('resumer')->nullable(false)->change();
            $table->string('image')->nullable(false)->change();
            $table->string('pdf')->nullable(false)->change();
        });
    }
};
