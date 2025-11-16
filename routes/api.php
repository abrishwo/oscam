<?php 

use App\Http\Controllers\ProductController;

Route::post('/verify', [ProductController::class, 'verify']);
