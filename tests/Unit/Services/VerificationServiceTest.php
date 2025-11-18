<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Services\QrCodeService;
use App\Services\VerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerificationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $verificationService;
    protected $qrCodeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->qrCodeService = new QrCodeService();
        $this->verificationService = new VerificationService($this->qrCodeService);
    }

    public function test_it_returns_original_for_a_valid_qr_code_with_no_scans()
    {
        $product = Product::factory()->create(['status' => 'original', 'scan_count' => 0]);
        $qrCode = $this->qrCodeService->generate($product);

        $result = $this->verificationService->verify($qrCode);

        $this->assertEquals('original', $result['status']);
    }

    public function test_it_returns_suspicious_for_a_valid_qr_code_with_scans()
    {
        $product = Product::factory()->create(['status' => 'original', 'scan_count' => 1]);
        $qrCode = $this->qrCodeService->generate($product);

        $result = $this->verificationService->verify($qrCode);

        $this->assertEquals('suspicious', $result['status']);
    }

    public function test_it_returns_fake_for_a_fake_product()
    {
        $product = Product::factory()->create(['status' => 'fake']);
        $qrCode = $this->qrCodeService->generate($product);

        $result = $this->verificationService->verify($qrCode);

        $this->assertEquals('fake', $result['status']);
    }

    public function test_it_returns_fake_for_an_invalid_qr_code()
    {
        $result = $this->verificationService->verify('invalid-qr-code');

        $this->assertEquals('fake', $result['status']);
    }
}
