<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PizzaWhiteValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->seed();
    }

    public function test_white_pizza_cannot_have_tomato_on_store(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $whiteCategory = Category::where('slug', 'bianche')->firstOrFail();
        $tomato = Ingredient::where('slug', 'pomodoro')->firstOrFail();

        $payload = [
            'name' => 'Bianca con pomodoro',
            'price' => 8.50,
            'category_id' => $whiteCategory->id,
            'ingredients' => [$tomato->id],
        ];

        $response = $this->post(route('admin.pizzas.store'), $payload);
        $response->assertSessionHasErrors(['ingredients']);
    }

    public function test_white_pizza_without_tomato_passes(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $whiteCategory = Category::where('slug', 'bianche')->firstOrFail();
        $mozzarella = Ingredient::where('slug', 'mozzarella')->firstOrFail();

        $payload = [
            'name' => 'Bianca mozzarella',
            'price' => 7.00,
            'category_id' => $whiteCategory->id,
            'ingredients' => [$mozzarella->id],
        ];

        $response = $this->post(route('admin.pizzas.store'), $payload);
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect(route('admin.pizzas.index'));
    }

    public function test_red_pizza_with_tomato_passes(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $classiche = Category::where('slug', 'classiche')->firstOrFail();
        $tomato = Ingredient::where('slug', 'pomodoro')->firstOrFail();

        $payload = [
            'name' => 'Rossa al pomodoro',
            'price' => 6.50,
            'category_id' => $classiche->id,
            'ingredients' => [$tomato->id],
        ];

        $response = $this->post(route('admin.pizzas.store'), $payload);
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect(route('admin.pizzas.index'));
    }
}
