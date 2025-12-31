<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipe;
use Illuminate\Support\Facades\DB;

class EquipeCompletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider d'abord la table pour éviter les doublons
        DB::table('equipes')->truncate();

        $membres = [
            [
                'nom' => 'Camille SEGNIGBINDE',
                'poste' => 'Présidente',
                'bio' => 'Présidente de Colibri Littéraire, Camille pilote la vision stratégique de l\'association et coordonne les initiatives majeures.',
                'photo' => 'img/team/camille.png',
                'email' => 'camille.segnigbinde@colibri-litteraire.org',
                'ordre' => 1,
                'actif' => true,
            ],
            [
                'nom' => 'Catira DODO',
                'poste' => 'Secrétaire',
                'bio' => 'Secrétaire de l\'association, Catira assure la gestion administrative et la communication interne.',
                'photo' => 'img/team/catira.png',
                'email' => 'catira.dodo@colibri-litteraire.org',
                'ordre' => 2,
                'actif' => true,
            ],
            [
                'nom' => 'Hervé AYEMENE',
                'poste' => 'Trésorier',
                'bio' => 'Trésorier de l\'association, Hervé gère les finances et assure la transparence budgétaire.',
                'photo' => 'img/team/Hervé.png',
                'email' => 'herve.ayemene@colibri-litteraire.org',
                'ordre' => 3,
                'actif' => true,
            ],
            [
                'nom' => 'Prudentienne GBAGUIDI',
                'poste' => 'Membre',
                'bio' => 'Membre active de l\'équipe, Prudentienne contribue aux activités culturelles et de médiation.',
                'photo' => 'img/team/prudentienne.jpg',
                'email' => 'prudentienne.gbaguidi@colibri-litteraire.org',
                'ordre' => 4,
                'actif' => true,
            ],
            [
                'nom' => 'Augustino AGBEMAVO',
                'poste' => 'Membre',
                'bio' => 'Membre de l\'équipe, Augustino participe activement aux projets de l\'association.',
                'photo' => 'img/team/augustino.jpg',
                'email' => 'augustino.agbemavo@colibri-litteraire.org',
                'ordre' => 5,
                'actif' => true,
            ],
            [
                'nom' => 'Rodrigue ATCHAOUE',
                'poste' => 'Membre',
                'bio' => 'Membre de l\'équipe, Rodrigue s\'investit dans les initiatives de promotion du livre africain.',
                'photo' => 'img/team/rodrigue.jpg',
                'email' => 'rodrigue.atchaoue@colibri-litteraire.org',
                'ordre' => 6,
                'actif' => true,
            ],
            [
                'nom' => 'Adèle KIEMA',
                'poste' => 'Membre',
                'bio' => 'Membre de l\'équipe, Adèle contribue aux activités de formation et d\'animation.',
                'photo' => 'img/team/adele.png',
                'email' => 'adele.kiema@colibri-litteraire.org',
                'ordre' => 7,
                'actif' => true,
            ],
            [
                'nom' => 'Idrissa SOW',
                'poste' => 'Membre',
                'bio' => 'Membre de l\'équipe, Idrissa participe aux projets de développement culturel.',
                'photo' => 'img/team/idrissa.jpg',
                'email' => 'idrissa.sow@colibri-litteraire.org',
                'ordre' => 8,
                'actif' => true,
            ],
            [
                'nom' => 'Yawavi MBOUKE',
                'poste' => 'Membre',
                'bio' => 'Membre de l\'équipe, Yawavi s\'engage dans les activités de médiation littéraire.',
                'photo' => 'img/team/yawavi.png',
                'email' => 'yawavi.mbouke@colibri-litteraire.org',
                'ordre' => 9,
                'actif' => true,
            ],
            [
                'nom' => 'Vivien Zanou',
                'poste' => 'Membre',
                'bio' => 'Membre de l\'équipe, Vivien contribue aux projets de l\'association.',
                'photo' => 'img/team/vivien.png',
                'email' => 'vivien.zanou@colibri-litteraire.org',
                'ordre' => 10,
                'actif' => true,
            ],
            [
                'nom' => 'Corneille ANOUMON',
                'poste' => 'Membre',
                'bio' => 'Membre de l\'équipe, Corneille participe aux activités culturelles de l\'association.',
                'photo' => 'img/team/corneille.png',
                'email' => 'corneille.anoumon@colibri-litteraire.org',
                'ordre' => 11,
                'actif' => true,
            ],
        ];

        foreach ($membres as $membre) {
            Equipe::create($membre);
        }

        $this->command->info('11 membres de l\'équipe ont été ajoutés avec succès !');
    }
}
