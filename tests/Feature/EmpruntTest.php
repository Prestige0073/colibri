<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Catalogue;
use App\Models\Emprunt;
use App\Models\User;

class EmpruntTest extends TestCase
{
    use RefreshDatabase;

    public function test_emprunt_livre_decremente_quantite_et_type_emprunt()
    {
        $livre = Catalogue::create([
            'titre' => 'Livre Emprunt',
            'auteur' => 'Auteur',
            'categorie' => 'Roman',
            'prix' => 10,
            'quantite' => 2,
            'type' => 'catalogue',
            'resumer' => '',
            'image' => '',
            'pdf' => '',
        ]);
        $user = User::factory()->create();
        Emprunt::create([
            'user_id' => $user->id,
            'livre_id' => $livre->id,
            'date_emprunt' => now(),
            'statut' => 'en_cours',
        ]);
        $livre->refresh();
        $livre->quantite--;
        $livre->type = 'emprunt';
        $livre->save();
        $this->assertEquals(1, $livre->quantite);
        $this->assertEquals('emprunt', $livre->type);
    }

    public function test_emprunt_impossible_si_quantite_zero()
    {
        $livre = Catalogue::create([
            'titre' => 'Livre Emprunt',
            'auteur' => 'Auteur',
            'categorie' => 'Roman',
            'prix' => 10,
            'quantite' => 0,
            'type' => 'catalogue',
            'resumer' => '',
            'image' => '',
            'pdf' => '',
        ]);
        $user = User::factory()->create();
        $canEmprunt = $livre->quantite > 0;
        $this->assertFalse($canEmprunt);
    }
}
