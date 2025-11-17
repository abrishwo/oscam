<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Scan;
use Illuminate\Support\Facades\DB;

class VerificationService
{
    public function verifyProduct(string $qrCode, ?string $deviceId, ?string $geoLocation, ?string $userAgent)
    {
        $product = Product::where('qr_code', $qrCode)->first();

        if (!$product) {
            return ['status' => 'fake', 'message' => 'Product not found.'];
        }

        // Advanced verification logic
        if ($product->scan_count > 0) {
            $lastScan = Scan::where('product_id', $product->id)->latest('scanned_at')->first();
            $timeSinceLastScan = now()->diffInSeconds($lastScan->scanned_at);

            // Suspicious if scanned again within a short time window
            if ($timeSinceLastScan < 60) {
                $this->logScan($product->id, $deviceId, $geoLocation, $userAgent);
                return ['status' => 'suspicious', 'message' => 'Product scanned multiple times in a short period.'];
            }
        }

        DB::transaction(function () use ($product, $deviceId, $geoLocation, $userAgent) {
            $product->increment('scan_count');
            $product->last_scan = now();
            $product->save();
            $this->logScan($product->id, $deviceId, $geoLocation, $userAgent);
        });

        return ['status' => 'original', 'message' => 'Product is genuine.', 'product' => $product];
    }

    protected function logScan(int $productId, ?string $deviceId, ?string $geoLocation, ?string $userAgent)
    {
        Scan::create([
            'product_id' => $productId,
            'device_id' => $deviceId,
            'geo_location' => $geoLocation,
            'user_agent' => $userAgent,
            'scanned_at' => now(),
        ]);
    }
}
