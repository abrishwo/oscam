<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    public function test_it_returns_a_list_of_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_it_creates_a_product()
    {
        $data = [
            'product_name' => 'Test Product',
            'batch_number' => '12345',
            'status' => 'original',
            'qr_code' => 'qr-code',
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);
    }

    public function test_it_returns_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $product->id]);
    }

    public function test_it_updates_a_product()
    {
        $product = Product::factory()->create();

        $data = [
            'product_name' => 'Updated Product',
        ];

        $response = $this->putJson("/api/products/{$product->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment($data);
    }

    public function test_it_deletes_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(204);
    }
}
