<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ScanLogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    public function test_it_returns_a_list_of_scan_logs()
    {
        Scan::factory()->count(3)->create();

        $response = $this->getJson('/api/scan-logs');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_it_filters_scan_logs_by_batch_number()
    {
        $product = Product::factory()->create(['batch_number' => '12345']);
        Scan::factory()->create(['product_id' => $product->id]);
        Scan::factory()->count(2)->create();

        $response = $this->getJson('/api/scan-logs?batch_number=12345');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
