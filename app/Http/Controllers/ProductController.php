<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'qr' => 'required|string'
        ]);

        $qr = $request->qr;

        $product = Product::where('qr_code', $qr)->first();

        if (!$product) {
            return response()->json([
                'status' => 'fake',
                'message' => 'QR code not found'
            ]);
        }

        if ($product->scan_count >= 1) {
            return response()->json([
                'status' => 'suspicious',
                'message' => 'QR was scanned before (possible clone)',
                'product' => $product
            ]);
        }

        $product->update([
            'scan_count' => $product->scan_count + 1,
            'last_scan' => Carbon::now()
        ]);

        return response()->json([
            'status' => 'original',
            'product' => $product
        ]);
    }
}

