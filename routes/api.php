<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResource('tasks', TaskController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('product-categories', ProductCategoryController::class);
        Route::apiResource('product-variants', ProductVariantController::class);
        Route::apiResource('vendors', VendorController::class);

        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    });

    Route::get('/halo', function () {
        return 'halo Laravel';
    });
});
