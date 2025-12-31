<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipe;

class EquipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $membres = [
            [
                'nom' => 'Élodie Martin',
                'poste' => 'Fondatrice & Présidente',
                'bio' => 'Passionnée par la littérature africaine et francophone, Élodie a fondé Colibri Littéraire pour promouvoir la diversité culturelle à travers le livre.',
                'photo' => 'img/team-1.jpg',
                'email' => 'elodie.martin@colibri-litteraire.org',
                'facebook' => '#',
                'twitter' => '#',
                'linkedin' => '#',
                'ordre' => 1,
                'actif' => true,
            ],
            [
                'nom' => 'Samuel Dupuis',
                'poste' => 'Responsable des projets',
                'bio' => 'Expert en gestion de projets culturels, Samuel coordonne les initiatives de Colibri Littéraire avec passion et rigueur.',
                'photo' => 'img/team-2.jpg',
                'email' => 'samuel.dupuis@colibri-litteraire.org',
                'facebook' => '#',
                'twitter' => '#',
                'linkedin' => '#',
                'ordre' => 2,
                'actif' => true,
            ],
            [
                'nom' => 'Fatima Benali',
                'poste' => 'Bénévole',
                'bio' => 'Bénévole engagée, Fatima contribue activement aux activités de médiation culturelle et d\'animation de l\'association.',
                'photo' => 'img/team-3.jpg',
                'email' => 'fatima.benali@colibri-litteraire.org',
                'facebook' => '#',
                'twitter' => '#',
                'linkedin' => '#',
                'ordre' => 3,
                'actif' => true,
            ],
        ];

        foreach ($membres as $membre) {
            Equipe::create($membre);
        }
    }
}
