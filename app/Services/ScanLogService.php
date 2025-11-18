<?php

namespace App\Services;

use App\Models\Scan;
use App\Models\Product;

/**
 * Service class for logging scans.
 */
class ScanLogService
{
    /**
     * Log a scan.
     *
     * @param string $qrCode
     * @param string|null $deviceId
     * @param array|null $geoLocation
     * @param string|null $userAgent
     * @return void
     */
    public function log(string $qrCode, ?string $deviceId, ?array $geoLocation, ?string $userAgent): void
    {
        $product = Product::where('qr_code', $qrCode)->first();

        Scan::create([
            'product_id' => $product->id ?? null,
            'raw_qr_text' => $qrCode,
            'device_id' => $deviceId,
            'geo_location' => $geoLocation,
            'user_agent' => $userAgent,
        ]);

        if ($product) {
            $product->increment('scan_count');
            $product->update(['last_scan' => now()]);
        }
    }
}
