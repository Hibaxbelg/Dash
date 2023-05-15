<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public array $data;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->data = [
            'name' => 'A new Product',
            'min_pc_number' => 1,
            'price' => 200,
            'price_per_additional_pc' => 50,
        ];
    }

    public function test_unauthenticated_cant_access_products(): void
    {
        $response = $this->getJson('/products');

        $response->assertStatus(401);
    }

    public function test_unauthenticated_user_cannot_create_product(): void
    {
        $response = $this->postJson('/products', $this->data);

        $response->assertStatus(401);
    }

    public function test_create_product_required_field()
    {
        foreach ($this->data as $field => $value) {
            $data = $this->data;
            unset($data[$field]);

            $response = $this->actingAs($this->user)->postJson('/products', $data);

            $response->assertStatus(422);
            $response->assertJsonValidationErrors($field);
        }
    }

    public function test_user_can_create_product()
    {
        $response = $this->actingAs($this->user)->postJson('/products', $this->data);

        $response->assertRedirect();

        $this->assertDatabaseHas('products', $this->data);
    }

    public function test_unauthenticated_user_cannot_update_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->putJson('/products/' . $product->id, $this->data);

        $response->assertStatus(401);
    }

    public function test_update_product_required_field()
    {
        $product = Product::factory()->create();

        foreach ($this->data as $field => $value) {
            $data = $this->data;
            unset($data[$field]);

            $response = $this->actingAs($this->user)->putJson('/products/' . $product->id, $data);

            $response->assertRedirect();
        }
    }

    public function test_user_can_update_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->putJson('/products/' . $product->id, $this->data);

        $response->assertRedirect();

        $this->assertDatabaseHas('products', ['id' => $product->id, ...$this->data]);
    }

    public function test_unauthenticated_user_cannot_delete_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson('/products/' . $product->id);

        $response->assertStatus(401);
    }

    public function test_user_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson('/products/' . $product->id);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
