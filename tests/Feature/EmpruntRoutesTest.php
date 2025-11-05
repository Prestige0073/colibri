<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Emprunt;
use App\Models\Catalogue;


class EmpruntRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_user_can_emprunter_un_livre()
    {
        $user = User::factory()->create();
        $livre = Catalogue::factory()->create();
        $response = $this->actingAs($user)->post('/bibliotheque/emprunter', [
            'livre_id' => $livre->id,
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('emprunts', [
            'user_id' => $user->id,
            'livre_id' => $livre->id,
        ]);
    }

    public function test_user_can_delete_emprunt()
    {
        $user = User::factory()->create();
        $livre = Catalogue::factory()->create();
        $emprunt = Emprunt::create([
            'user_id' => $user->id,
            'livre_id' => $livre->id,
            'date_emprunt' => now(),
            'statut' => 'en_cours',
        ]);
        $response = $this->actingAs($user)->delete('/emprunts/' . $emprunt->id);
        $response->assertRedirect();
        $this->assertDatabaseMissing('emprunts', [
            'id' => $emprunt->id,
        ]);
    }

    public function test_user_cannot_delete_other_user_emprunt()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $livre = Catalogue::factory()->create();
        $emprunt = Emprunt::create([
            'user_id' => $user1->id,
            'livre_id' => $livre->id,
            'date_emprunt' => now(),
            'statut' => 'en_cours',
        ]);
        $response = $this->actingAs($user2)->delete('/emprunts/' . $emprunt->id);
        $response->assertRedirect();
        $this->assertDatabaseHas('emprunts', [
            'id' => $emprunt->id,
        ]);
    }
}
