<?php

namespace App\Services;

use App\Models\Product;

/**
 * Service class for generating and verifying QR codes.
 */
class QrCodeService
{
    /**
     * Generate a secure QR code.
     *
     * @param Product $product
     * @return string
     */
    public function generate(Product $product): string
    {
        $payload = "{$product->id}|{$product->batch_number}|" . now()->timestamp;
        $hmac = hash_hmac('sha256', $payload, config('app.key'));
        return "{$payload}|{$hmac}";
    }

    /**
     * Verify a QR code.
     *
     * @param string $qrCode
     * @return bool
     */
    public function verify(string $qrCode): bool
    {
        $parts = explode('|', $qrCode);
        if (count($parts) !== 4) {
            return false;
        }

        [$productId, $batch, $timestamp, $hmac] = $parts;
        $payload = "{$productId}|{$batch}|{$timestamp}";
        $expectedHmac = hash_hmac('sha256', $payload, config('app.key'));

        return hash_equals($expectedHmac, $hmac);
    }
}
