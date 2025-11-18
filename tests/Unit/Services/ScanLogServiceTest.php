<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Models\Scan;
use App\Services\ScanLogService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScanLogServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $scanLogService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->scanLogService = new ScanLogService();
    }

    public function test_it_logs_a_scan_for_an_existing_product()
    {
        $product = Product::factory()->create();
        $qrCode = $product->qr_code;

        $this->scanLogService->log($qrCode, 'device-id', ['lat' => 0, 'lng' => 0], 'user-agent');

        $this->assertDatabaseHas('scans', [
            'product_id' => $product->id,
            'raw_qr_text' => $qrCode,
            'device_id' => 'device-id',
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'scan_count' => 1,
        ]);
    }

    public function test_it_logs_a_scan_for_a_non_existing_product()
    {
        $qrCode = 'invalid-qr-code';

        $this->scanLogService->log($qrCode, 'device-id', ['lat' => 0, 'lng' => 0], 'user-agent');

        $this->assertDatabaseHas('scans', [
            'product_id' => null,
            'raw_qr_text' => $qrCode,
            'device_id' => 'device-id',
        ]);
    }
}
