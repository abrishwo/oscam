<?php

namespace App\Services;

use Illuminate\Support\Str;

class QrCodeService
{
    /**
     * Generate a unique QR code string.
     *
     * In a real application, you would use a library like `simple-qrcode`
     * to generate an actual QR code image. This service currently
     * generates a unique string that can be used as the QR code data.
     *
     * @return string
     */
    public function generateUniqueQrCode(): string
    {
        // Generate a random, unique string to be used as the QR code.
        // A real implementation would also check for collisions.
        return Str::random(32);
    }
}
