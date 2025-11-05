<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CatalogueSeeder extends Seeder
{
    public function run(): void
    {
        $catalogues = [];
        // 9 catalogues classiques
        for ($i = 1; $i <= 9; $i++) {
            $catalogues[] = [
                'titre' => "Livre exemple $i",
                'auteur' => "Auteur $i",
                'categorie' => 'Littérature',
                'prix' => rand(10, 50),
                'quantite' => rand(1, 20),
                'type' => 'catalogue',
                'type_categorie' => 'catalogue',
                'resumer' => "Résumé du livre exemple $i.",
                'image' => "/img/catalogue$i.jpg",
                'pdf' => "/pdf/catalogue$i.pdf",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // 9 catalogues pour emprunt
        for ($i = 1; $i <= 9; $i++) {
            $catalogues[] = [
                'titre' => "Livre emprunt $i",
                'auteur' => "Auteur $i",
                'categorie' => 'Littérature',
                'prix' => rand(10, 50),
                'quantite' => rand(1, 20),
                'type' => 'emprunt',
                'type_categorie' => 'emprunt',
                'resumer' => "Résumé du livre emprunt $i.",
                'image' => "/img/emprunt$i.jpg",
                'pdf' => "/pdf/emprunt$i.pdf",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('catalogues')->insert($catalogues);
    }
}
