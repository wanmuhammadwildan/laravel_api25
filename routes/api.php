<?php

use App\Http\Controllers\Api\ProductCategoryController as ApiProductCategoryController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\VendorController;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Resource route akan otomatis membuat 7 route CRUD
Route::resource('tasks', TaskController::class);

Route::prefix('v1')->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::resource('products', ApiProductController::class);
    Route::resource('product-categories', ApiProductCategoryController::class);
    Route::resource('product-variants', ProductVariantController::class);
    
    Route::resource('vendors', VendorController::class);

Route::get('/halo', function () {
    return 'halo Laravel';
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
});

