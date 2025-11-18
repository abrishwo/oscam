<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Services\QrCodeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrCodeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $qrCodeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->qrCodeService = new QrCodeService();
    }

    public function test_it_generates_a_valid_qr_code()
    {
        $product = Product::factory()->create();
        $qrCode = $this->qrCodeService->generate($product);

        $this->assertTrue($this->qrCodeService->verify($qrCode));
    }

    public function test_it_invalidates_a_tampered_qr_code()
    {
        $product = Product::factory()->create();
        $qrCode = $this->qrCodeService->generate($product);

        $tamperedQrCode = "{$qrCode}tampered";

        $this->assertFalse($this->qrCodeService->verify($tamperedQrCode));
    }
}
