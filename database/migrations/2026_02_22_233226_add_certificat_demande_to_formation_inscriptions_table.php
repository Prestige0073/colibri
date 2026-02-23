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
        Schema::table('formation_inscriptions', function (Blueprint $table) {
            $table->boolean('certificat_demande')->default(false)->after('paiement_valide');
            $table->timestamp('certificat_demande_at')->nullable()->after('certificat_demande');
        });
    }

    public function down(): void
    {
        Schema::table('formation_inscriptions', function (Blueprint $table) {
            $table->dropColumn(['certificat_demande', 'certificat_demande_at']);
        });
    }
};
