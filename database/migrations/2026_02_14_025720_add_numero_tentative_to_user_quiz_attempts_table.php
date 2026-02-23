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
        Schema::table('user_quiz_attempts', function (Blueprint $table) {
            $table->unsignedInteger('numero_tentative')->default(1)->after('quiz_id');
        });

        // Mettre à jour les tentatives existantes avec le bon numéro
        $attempts = DB::table('user_quiz_attempts')
            ->orderBy('user_id')
            ->orderBy('quiz_id')
            ->orderBy('created_at')
            ->get();

        $counters = [];
        foreach ($attempts as $attempt) {
            $key = $attempt->user_id . '_' . $attempt->quiz_id;
            if (!isset($counters[$key])) {
                $counters[$key] = 0;
            }
            $counters[$key]++;

            DB::table('user_quiz_attempts')
                ->where('id', $attempt->id)
                ->update(['numero_tentative' => $counters[$key]]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_quiz_attempts', function (Blueprint $table) {
            $table->dropColumn('numero_tentative');
        });
    }
};
