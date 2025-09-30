<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PizzasIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_pizzas_index_requires_authentication(): void
    {
        $response = $this->get('/pizzas');
        $response->assertRedirect('/login');
    }

    public function test_pizzas_index_shows_and_has_admin_named_links(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/pizzas');
        $response->assertStatus(200);

        $response->assertSee(route('admin.pizzas.create'), false);
    }
}
