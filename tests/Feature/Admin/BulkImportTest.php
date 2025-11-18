<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BulkImportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    public function test_it_imports_products_from_a_csv_file()
    {
        $file = UploadedFile::fake()->createWithContent(
            'products.csv',
            "product_name,batch_number,status\n" .
            "Test Product 1,12345,original\n" .
            "Test Product 2,67890,fake"
        );

        $response = $this->post('/admin/products/import', [
            'file' => $file,
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'product_name' => 'Test Product 1',
            'batch_number' => '12345',
            'status' => 'original',
        ]);

        $this->assertDatabaseHas('products', [
            'product_name' => 'Test Product 2',
            'batch_number' => '67890',
            'status' => 'fake',
        ]);
    }
}
