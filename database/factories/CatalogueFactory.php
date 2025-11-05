<?php
namespace Database\Factories;

use App\Models\Catalogue;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogueFactory extends Factory
{
    protected $model = Catalogue::class;

    public function definition()
    {
        return [
            'titre' => $this->faker->sentence(3),
            'auteur' => $this->faker->name(),
            'categorie' => $this->faker->word(),
            'resumer' => $this->faker->paragraph(),
            'prix' => $this->faker->numberBetween(10, 50),
            'image' => 'img/livres/livre-1.jpg',
            'pdf' => 'pdf/test.pdf',
            // 'statut' supprimé car non présent dans la table
        ];
    }
}
