<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use App\Models\OnlineShopProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        // Create and authenticate a user
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /** @test */
    public function it_can_display_all_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->get('/category');

        $response->assertStatus(200);
        $response->assertViewIs('category.index');
        $response->assertViewHas('categories');
    }

    /** @test */
    public function it_can_show_category_with_products_from_two_online_shops()
    {
        $category = Category::factory()->create();

        $colesProduct = OnlineShopProduct::factory()->create([
            'online_shop_id' => 1,
            'category_id' => $category->id,
        ]);

        $woolworthsProduct = OnlineShopProduct::factory()->create([
            'online_shop_id' => 2,
            'category_id' => $category->id,
        ]);

        $response = $this->get('/category/' . $category->id);

        $response->assertStatus(200);
        $response->assertViewIs('category.show');
        $response->assertViewHas('category', $category);
        $response->assertViewHas('colesProducts', function ($collection) use ($colesProduct) {
            return $collection->contains($colesProduct);
        });
        $response->assertViewHas('woolworthsProducts', function ($collection) use ($woolworthsProduct) {
            return $collection->contains($woolworthsProduct);
        });
    }


    /** @test */
    public function it_can_display_the_create_category_form()
    {
        $response = $this->get('/category/create');

        $response->assertStatus(200);
        $response->assertViewIs('category.create');
    }

    /** @test */
    public function it_can_create_a_new_category()
    {
        $response = $this->post('/category', [
            'name' => 'New Category',
            'description' => 'Description for new category'
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'description' => 'Description for new category'
        ]);

        $response->assertRedirect(route('category.index'));
        $response->assertSessionHas('success', 'Category created successfully.');
    }

    /** @test */
    public function it_can_display_the_edit_category_form()
    {
        $category = Category::factory()->create();

        $response = $this->get('/category/' . $category->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('category.edit');
        $response->assertViewHas('category', $category);
    }

    /** @test */
    public function it_can_update_an_existing_category()
    {
        $category = Category::factory()->create();

        $response = $this->put('/category/' . $category->id, [
            'name' => 'Updated Category',
            'description' => 'Updated description for category'
        ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Category',
            'description' => 'Updated description for category'
        ]);

        $response->assertRedirect(route('category.index'));
        $response->assertSessionHas('success', 'Category updated successfully.');
    }
}
