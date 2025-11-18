<?php

use App\Http\Controllers\Api\ProductCategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Resource route akan otomatis membuat 7 route CRUD
Route::resource('tasks', TaskController::class);

Route::prefix('v1')->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::resource('products', ProductController::class);
    Route::resource('product-categories', ProductCategoriesController::class);
    
    Route::resource('vendors', VendorController::class);

Route::get('/halo', function () {
    return 'halo Laravel';
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
});

