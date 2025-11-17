<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\QrCodeService;

class AdminProductController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function index()
    {
        return Product::paginate(15);
    }

    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();

        $product = Product::create([
            'qr_code' => $this->qrCodeService->generateUniqueQrCode(),
            'product_name' => $validatedData['product_name'],
            'batch_number' => $validatedData['batch_number'],
        ]);

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();

        $product->update($validatedData);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }

    public function generateQrCode(Product $product)
    {
        // In a real application, this would return a QR code image.
        // For now, it returns the QR code string.
        return response()->json(['qr_code' => $product->qr_code]);
    }
}
