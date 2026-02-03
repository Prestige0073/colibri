<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->boolean('est_gratuit')->default(false)->after('prix');
        });

        // Mettre à jour les formations existantes avec prix = 0 comme gratuites
        DB::table('formations')->where('prix', 0)->update(['est_gratuit' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->dropColumn('est_gratuit');
        });
    }
};
