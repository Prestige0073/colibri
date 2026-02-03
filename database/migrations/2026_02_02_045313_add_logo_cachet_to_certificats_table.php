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
        Schema::table('certificats', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('fichier_pdf');
            $table->string('cachet_path')->nullable()->after('logo_path');
            $table->string('signature_path')->nullable()->after('cachet_path');
            $table->string('lieu_delivrance')->default('Cotonou')->after('date_delivrance');
            $table->string('signataire_nom')->default('SEGNIGBINDE A. Camille')->after('lieu_delivrance');
            $table->string('signataire_titre')->default('Directeur Exécutif')->after('signataire_nom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificats', function (Blueprint $table) {
            $table->dropColumn(['logo_path', 'cachet_path', 'signature_path', 'lieu_delivrance', 'signataire_nom', 'signataire_titre']);
        });
    }
};
