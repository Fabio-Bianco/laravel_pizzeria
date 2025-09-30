<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Usa il database di test migrando le tabelle
        $this->artisan('migrate');
    }

    public function test_categories_index_requires_authentication(): void
    {
        $response = $this->get('/categories');
        $response->assertRedirect('/login');
    }

    public function test_categories_index_shows_and_has_admin_named_links(): void
    {
        // Crea utente e autentica
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/categories');
        $response->assertStatus(200);

        // I link principali nella pagina index dovrebbero usare i nomi admin.*
        // Verifichiamo la presenza delle URL generate da quelle route:
        $response->assertSee(route('admin.categories.create'), false);
    }
}
