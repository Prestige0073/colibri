<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Catalogue;
use App\Models\CartItem;
use App\Models\Commande;
use App\Models\CommandeItem;

class CommandeCodTest extends TestCase
{
    use RefreshDatabase;

    public function test_cod_route_creates_commande_and_items_and_clears_cart()
    {
        // create a user
        $user = User::factory()->create();

        // create catalogue item
        $catalogue = Catalogue::factory()->create([
            'titre' => 'Livre Test',
            'prix' => 1500,
        ]);

        // add to cart
        CartItem::create([
            'user_id' => $user->id,
            'catalogue_id' => $catalogue->id,
            'quantite' => 2,
        ]);

        $payload = [
            'items' => [[
                'catalogue_id' => $catalogue->id,
                'titre' => $catalogue->titre,
                'quantite' => 2,
                'prix' => $catalogue->prix,
            ]],
            'total' => 3000,
            'idempotency_key' => 'test-key-123',
            'nom' => 'Client Test',
            'tel' => '123456789'
        ];

        $response = $this->actingAs($user)->postJson(route('commande.cod'), $payload);

        $response->assertStatus(200)->assertJson(['success' => true]);

        $this->assertDatabaseHas('commandes', [
            'user_id' => $user->id,
            'total' => 3000,
        ]);

        $commande = Commande::where('idempotency_key', 'test-key-123')->first();
        $this->assertNotNull($commande);

        $this->assertDatabaseHas('commande_items', [
            'commande_id' => $commande->id,
            'catalogue_id' => $catalogue->id,
            'quantite' => 2,
            'titre' => $catalogue->titre,
        ]);

        // cart must be empty
        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $user->id,
        ]);
    }
}
