<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Catalogue;

class CatalogueRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_user_can_voir_catalogue()
    {
    $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/catalogue/decouvrir');
        $response->assertStatus(200);
    }

    public function test_user_can_acheter_un_livre()
    {
        $user = User::factory()->create();
        $livre = Catalogue::factory()->create();
        $response = $this->actingAs($user)->get('/catalogue/acheter');
        $response->assertStatus(200);
        // On peut ajouter un test POST si la logique d'achat existe
    }
}
