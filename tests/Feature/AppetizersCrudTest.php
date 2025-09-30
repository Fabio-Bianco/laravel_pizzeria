<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Appetizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppetizersCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_index_requires_authentication(): void
    {
        $response = $this->get('/appetizers');
        $response->assertRedirect('/login');
    }

    public function test_index_shows_and_has_admin_named_links(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/appetizers');
        $response->assertStatus(200);
        $response->assertSee(route('admin.appetizers.create'), false);
    }

    public function test_create_store_validation_and_persist(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create
        $response = $this->post(route('admin.appetizers.store'), [
            'name' => 'Bruschette Test',
            'price' => 4.20,
            'description' => 'Pane tostato, pomodoro e basilico',
        ]);
        $response->assertRedirect(route('admin.appetizers.index'));

        $this->assertDatabaseHas('appetizers', [
            'name' => 'Bruschette Test',
        ]);

        // Validation unique
        $response2 = $this->post(route('admin.appetizers.store'), [
            'name' => 'Bruschette Test',
            'price' => 5,
        ]);
        $response2->assertSessionHasErrors('name');

        // Price negativo
        $response3 = $this->post(route('admin.appetizers.store'), [
            'name' => 'Negativo',
            'price' => -1,
        ]);
        $response3->assertSessionHasErrors('price');

        // Name troppo lungo (>255)
        $longName = str_repeat('A', 256);
        $response4 = $this->post(route('admin.appetizers.store'), [
            'name' => $longName,
            'price' => 1,
        ]);
        $response4->assertSessionHasErrors('name');
    }

    public function test_update_and_delete(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $appetizer = Appetizer::create([
            'name' => 'Olive Test',
            'slug' => 'olive-test',
            'price' => 3.50,
            'description' => null,
        ]);

        // Update
        $response = $this->put(route('admin.appetizers.update', $appetizer), [
            'name' => 'Olive Ascolane Test',
            'price' => 4.00,
            'description' => 'Fritte',
        ]);
        $response->assertRedirect(route('admin.appetizers.index'));
        $this->assertDatabaseHas('appetizers', [
            'name' => 'Olive Ascolane Test',
            'price' => 4.00,
        ]);

        // Delete
        $response = $this->delete(route('admin.appetizers.destroy', $appetizer));
        $response->assertRedirect(route('admin.appetizers.index'));
        $this->assertDatabaseMissing('appetizers', [
            'id' => $appetizer->id,
        ]);
    }

    public function test_pagination_and_show_edit_pages(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Seed 15 items
        Appetizer::factory()->count(15)->create();

        // Page 1
        $resp1 = $this->get('/appetizers?page=1');
    $resp1->assertStatus(200);
    // Verifica presenza del componente di paginazione Bootstrap
    $resp1->assertSee('class="pagination"', false);

        // Show/Edit specific
        $item = Appetizer::first();
        $show = $this->get(route('admin.appetizers.show', $item));
        $show->assertStatus(200);
        $show->assertSee(e($item->name));

        $edit = $this->get(route('admin.appetizers.edit', $item));
        $edit->assertStatus(200);
        $edit->assertSee('Dettagli antipasto');
        $edit->assertSee('name="name"', false);
        $edit->assertSee('name="price"', false);
    }
}
