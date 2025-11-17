<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyProductRequest;
use App\Services\VerificationService;

class ProductController extends Controller
{
    protected $verificationService;

    public function __construct(VerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    public function verify(VerifyProductRequest $request)
    {
        $validatedData = $request->validated();

        $result = $this->verificationService->verifyProduct(
            $validatedData['qr_code'],
            $validatedData['device_id'] ?? null,
            $validatedData['geo_location'] ?? null,
            $validatedData['user_agent'] ?? null
        );

        return response()->json($result);
    }
}
