<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// API Documentation Route
Route::get('/api/docs', function () {
    return view('docs.index');
});

// Admin Panel Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login.post');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/products', [AdminController::class, 'products'])->name('admin.products.index');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
        Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
        Route::get('/products/import', [AdminController::class, 'importProducts'])->name('admin.products.import');
        Route::post('/products/import', [AdminController::class, 'processImport'])->name('admin.products.import.post');
        Route::get('/scan-logs', [AdminController::class, 'scanLogs'])->name('admin.scan-logs.index');
    });
});
