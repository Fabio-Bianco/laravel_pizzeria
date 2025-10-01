<?php

namespace Tests\Feature;

use App\Models\Pizza;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PizzaNotesDisplayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_note_shown_when_present_on_index(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $pizza = Pizza::factory()->create(['notes' => 'Senza aglio']);

        $response = $this->get(route('admin.pizzas.index'));
        $response->assertStatus(200);
        $response->assertSee('Nota:', false);
        $response->assertSee('Senza aglio', false);
    }

    public function test_note_not_shown_when_empty_on_index(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $pizza = Pizza::factory()->create(['notes' => null]);

        $response = $this->get(route('admin.pizzas.index'));
        $response->assertStatus(200);
        $response->assertDontSee('Nota:', false);
    }
}
