<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('modules', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
            $table->string('video_path')->nullable()->after('image');
            $table->string('video_url')->nullable()->after('video_path');
        });
    }
    public function down() {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['image','video_path','video_url']);
        });
    }
};
