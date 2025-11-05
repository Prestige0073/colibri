<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Catalogue;

class CatalogueTest extends TestCase
{
    use RefreshDatabase;

    public function test_ajout_livre_catalogue_type_catalogue()
    {
        $data = [
            'titre' => 'Test Livre',
            'auteur' => 'Auteur Test',
            'categorie' => 'Roman',
            'prix' => 20,
            'quantite' => 5,
            'resumer' => 'Résumé test',
            'type' => 'catalogue',
            'image' => '',
            'pdf' => '',
        ];
        $livre = Catalogue::create($data);
        $this->assertEquals('catalogue', $livre->type);
        $this->assertEquals(5, $livre->quantite);
    }
}
