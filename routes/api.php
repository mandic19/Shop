<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\VariantImageController;

Route::middleware(['api', 'throttle:3,1'])->group(function () {
    // Image Routes
    Route::get('/images', [ImageController::class, 'index']);
    Route::post('/images', [ImageController::class, 'store']);
    Route::get('/images/{id}', [ImageController::class, 'show']);
    Route::put('/images/{id}', [ImageController::class, 'update']);
    Route::delete('/images/{id}', [ImageController::class, 'destroy']);

    // Product Routes
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Variant Routes
    Route::get('/variants', [VariantController::class, 'index']);
    Route::post('/products/{product_id}/variants', [VariantController::class, 'store']);
    Route::get('/variants/{id}', [VariantController::class, 'show']);
    Route::put('/variants/{id}', [VariantController::class, 'update']);
    Route::delete('/variants/{id}', [VariantController::class, 'destroy']);

    // Variant Image Routes
    Route::get('/variant-images', [VariantImageController::class, 'index']);
    Route::get('/variant-images/{id}', [VariantImageController::class, 'show']);
    Route::post('/variant-images', [VariantImageController::class, 'store']);
    Route::put('/variant-images/{id}', [VariantImageController::class, 'update']);
    Route::delete('/variant-images/{id}', [VariantImageController::class, 'destroy']);
});
