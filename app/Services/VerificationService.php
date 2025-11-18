<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

/**
 * Service class for product verification.
 */
class VerificationService
{
    /**
     * The QR code service instance.
     *
     * @var \App\Services\QrCodeService
     */
    protected $qrCodeService;

    /**
     * Create a new service instance.
     *
     * @param \App\Services\QrCodeService $qrCodeService
     * @return void
     */
    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Verify a QR code.
     *
     * @param string $qrCode
     * @return array
     */
    public function verify(string $qrCode): array
    {
        if (!$this->qrCodeService->verify($qrCode)) {
            return ['status' => 'fake'];
        }

        $parts = explode('|', $qrCode);
        $productId = $parts[0];

        $product = Product::find($productId);

        if (!$product) {
            return ['status' => 'fake'];
        }

        if ($product->status === 'fake') {
            return ['status' => 'fake'];
        }

        if ($product->scan_count > 0) {
            return ['status' => 'suspicious'];
        }

        return ['status' => 'original'];
    }
}
