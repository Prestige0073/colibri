<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Catalogue;
use App\Models\CartItem;

class PanierRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_user_can_ajouter_au_panier()
    {
    $user = User::factory()->create();
        $livre = Catalogue::factory()->create();
        $response = $this->actingAs($user)->post('/panier/ajouter', [
            'catalogue_id' => $livre->id,
            'quantite' => 1,
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'catalogue_id' => $livre->id,
        ]);
    }

    public function test_user_can_supprimer_du_panier()
    {
        $user = User::factory()->create();
        $livre = Catalogue::factory()->create();
        $item = CartItem::create([
            'user_id' => $user->id,
            'catalogue_id' => $livre->id,
            'quantite' => 1,
        ]);
        $response = $this->actingAs($user)->delete('/panier/supprimer/' . $item->id);
        $response->assertRedirect();
        $this->assertDatabaseMissing('cart_items', [
            'id' => $item->id,
        ]);
    }

    public function test_user_can_payer_panier()
    {
        $user = User::factory()->create();
        $livre = Catalogue::factory()->create();
        CartItem::create([
            'user_id' => $user->id,
            'catalogue_id' => $livre->id,
            'quantite' => 1,
        ]);
        $response = $this->actingAs($user)->post('/panier/payer');
        $response->assertRedirect();
        // On peut ajouter une vérification sur la commande si elle existe
    }
}
