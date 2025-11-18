<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyProductRequest;
use App\Services\ScanLogService;
use App\Services\VerificationService;
use Illuminate\Http\Request;

/**
 * Controller for product verification.
 */
class ProductController extends Controller
{
    /**
     * The verification service instance.
     *
     * @var \App\Services\VerificationService
     */
    protected $verificationService;

    /**
     * The scan log service instance.
     *
     * @var \App\Services\ScanLogService
     */
    protected $scanLogService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\VerificationService $verificationService
     * @param \App\Services\ScanLogService $scanLogService
     * @return void
     */
    public function __construct(VerificationService $verificationService, ScanLogService $scanLogService)
    {
        $this->verificationService = $verificationService;
        $this->scanLogService = $scanLogService;
    }

    /**
     * Verify a product.
     *
     * @param \App\Http\Requests\VerifyProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(VerifyProductRequest $request)
    {
        $validated = $request->validated();

        $result = $this->verificationService->verify($validated['qr_code']);
        $this->scanLogService->log(
            $validated['qr_code'],
            $validated['device_id'] ?? null,
            $validated['geo_location'] ?? null,
            $request->header('User-Agent')
        );

        return response()->json($result);
    }
}
