<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Services\QrCodeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifyTest extends TestCase
{
    use RefreshDatabase;

    protected $qrCodeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->qrCodeService = new QrCodeService();
    }

    public function test_it_returns_original_for_a_valid_qr_code()
    {
        $product = Product::factory()->create(['status' => 'original', 'scan_count' => 0]);
        $qrCode = $this->qrCodeService->generate($product);

        $response = $this->postJson('/api/verify', ['qr_code' => $qrCode]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'original']);
    }

    public function test_it_returns_suspicious_for_a_scanned_qr_code()
    {
        $product = Product::factory()->create(['status' => 'original', 'scan_count' => 1]);
        $qrCode = $this->qrCodeService->generate($product);

        $response = $this->postJson('/api/verify', ['qr_code' => $qrCode]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'suspicious']);
    }

    public function test_it_returns_fake_for_a_fake_product()
    {
        $product = Product::factory()->create(['status' => 'fake']);
        $qrCode = $this->qrCodeService->generate($product);

        $response = $this->postJson('/api/verify', ['qr_code' => $qrCode]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'fake']);
    }

    public function test_it_returns_fake_for_an_invalid_qr_code()
    {
        $response = $this->postJson('/api/verify', ['qr_code' => 'invalid-qr-code']);

        $response->assertStatus(200)
            ->assertJson(['status' => 'fake']);
    }
}
