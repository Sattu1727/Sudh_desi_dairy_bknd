<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductInventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get-product-inventory', [ProductInventoryController::class, 'index']); // Fetch all records
Route::post('/add-product-inventory', [ProductInventoryController::class, 'store']); // Create a new record
Route::get('/getbyid-product-inventory/{id}', [ProductInventoryController::class, 'show']); // Fetch a single record
Route::put('/addbyid-product-inventory/{id}', [ProductInventoryController::class, 'update']); // Update a record
// Route::delete('/product-inventory/{id}', [ProductInventoryController::class, 'destroy']); // Delete a record


// product api start
Route::prefix('products')->group(function () {
    Route::get('/get-product', [ProductController::class, 'index']);
    Route::post('/add-product', [ProductController::class, 'store']);
    Route::get('/get-product-id/{id}', [ProductController::class, 'show']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});
// product api end
// product category api start
Route::prefix('categories')->group(function () {
    Route::get('/get-categories', [CategoryController::class, 'index']);
    Route::post('/add-categories', [CategoryController::class, 'store']);
    Route::get('/category/{category_id}', [CategoryController::class, 'showByCategoryId']); // Updated Route
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});
// product category api end