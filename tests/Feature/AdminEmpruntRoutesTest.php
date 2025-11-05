<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Catalogue;
use App\Models\Emprunt;

class AdminEmpruntRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_admin_can_voir_emprunts()
    {
    $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get('/admin/emprunts');
        $response->assertStatus(200);
    }

    public function test_admin_can_supprimer_emprunt()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $livre = Catalogue::factory()->create();
        $emprunt = Emprunt::create([
            'user_id' => $admin->id,
            'livre_id' => $livre->id,
            'date_emprunt' => now(),
            'statut' => 'en_cours',
        ]);
        $response = $this->actingAs($admin)->delete('/admin/emprunts/' . $emprunt->id);
        $response->assertRedirect();
        $this->assertDatabaseMissing('emprunts', [
            'id' => $emprunt->id,
        ]);
    }
}
