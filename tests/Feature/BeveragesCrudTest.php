<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Beverage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BeveragesCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_index_requires_authentication(): void
    {
        $response = $this->get('/beverages');
        $response->assertRedirect('/login');
    }

    public function test_index_shows_and_has_admin_named_links(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/beverages');
        $response->assertStatus(200);
        $response->assertSee(route('admin.beverages.create'), false);
    }

    public function test_create_store_validation_and_persist(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create
        $response = $this->post(route('admin.beverages.store'), [
            'name' => 'Acqua Naturale Test 0.5L',
            'price' => 1.00,
            'description' => null,
        ]);
        $response->assertRedirect(route('admin.beverages.index'));

        $this->assertDatabaseHas('beverages', [
            'name' => 'Acqua Naturale Test 0.5L',
        ]);

        // Validation unique
        $response2 = $this->post(route('admin.beverages.store'), [
            'name' => 'Acqua Naturale Test 0.5L',
            'price' => 1.20,
        ]);
        $response2->assertSessionHasErrors('name');

        // Price negativo
        $response3 = $this->post(route('admin.beverages.store'), [
            'name' => 'Negativo Bevanda',
            'price' => -1,
        ]);
        $response3->assertSessionHasErrors('price');

        // Name troppo lungo (>255)
        $longName = str_repeat('B', 256);
        $response4 = $this->post(route('admin.beverages.store'), [
            'name' => $longName,
            'price' => 1,
        ]);
        $response4->assertSessionHasErrors('name');
    }

    public function test_update_and_delete(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $beverage = Beverage::create([
            'name' => 'Cola Test 0.33L',
            'slug' => 'cola-test-033l',
            'price' => 2.50,
            'description' => null,
        ]);

        // Update
        $response = $this->put(route('admin.beverages.update', $beverage), [
            'name' => 'Cola Test 0.5L',
            'price' => 3.00,
            'description' => 'Bottiglia 0.5L',
        ]);
        $response->assertRedirect(route('admin.beverages.index'));
        $this->assertDatabaseHas('beverages', [
            'name' => 'Cola Test 0.5L',
            'price' => 3.00,
        ]);

        // Delete
        $response = $this->delete(route('admin.beverages.destroy', $beverage));
        $response->assertRedirect(route('admin.beverages.index'));
        $this->assertDatabaseMissing('beverages', [
            'id' => $beverage->id,
        ]);
    }

    public function test_pagination_and_show_edit_pages(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Seed 15 items
        Beverage::factory()->count(15)->create();

        // Page 1
        $resp1 = $this->get('/beverages?page=1');
    $resp1->assertStatus(200);
    // Verifica presenza del componente di paginazione Bootstrap
    $resp1->assertSee('class="pagination"', false);

        // Show/Edit specific
        $item = Beverage::first();
        $show = $this->get(route('admin.beverages.show', $item));
        $show->assertStatus(200);
        $show->assertSee(e($item->name));

        $edit = $this->get(route('admin.beverages.edit', $item));
        $edit->assertStatus(200);
        $edit->assertSee('Dettagli bevanda');
        $edit->assertSee('name="name"', false);
        $edit->assertSee('name="price"', false);
    }
}
