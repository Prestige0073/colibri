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
        Schema::table('user_module_progression', function (Blueprint $table) {
            $table->decimal('video_watch_percentage', 5, 2)->default(0)->after('completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_module_progression', function (Blueprint $table) {
            $table->dropColumn('video_watch_percentage');
        });
    }
};
