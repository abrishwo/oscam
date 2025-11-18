<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Product Verification
Route::post('/verify', [ProductController::class, 'verify'])->middleware('throttle:10,1');

// Admin Product Management
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', AdminProductController::class);
});

// QR Code Generation
Route::middleware('auth:sanctum')->get('/products/{product}/generate-qr', [AdminProductController::class, 'generateQrCode']);

// Scan Logs
Route::middleware('auth:sanctum')->get('/scan-logs', [App\Http\Controllers\ScanLogController::class, 'index']);
