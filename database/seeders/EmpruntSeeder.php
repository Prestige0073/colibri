<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Catalogue;

class EmpruntSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $livres = Catalogue::all();
        if ($users->count() === 0 || $livres->count() === 0) {
            return;
        }
        $emprunts = [];
        $date = now();
        // On crée 9 emprunts, un par livre, pour un utilisateur aléatoire
        foreach ($livres->take(9) as $i => $livre) {
            $user = $users->random();
            $emprunts[] = [
                'user_id' => $user->id,
                'livre_id' => $livre->id,
                'date_emprunt' => $date->copy()->subDays(rand(1, 30)),
                'date_retour' => null,
                'statut' => 'En cours',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if (count($emprunts)) {
            DB::table('emprunts')->insert($emprunts);
        }
    }
}
