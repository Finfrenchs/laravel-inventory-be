<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//auth
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//company
Route::get('/company', [CompanyController::class, 'show']);
Route::put('/company', [CompanyController::class, 'update']);

//INVENTORY
//categories
Route::apiResource('/categories', App\Http\Controllers\Api\Inventory\CategoryController::class)->middleware('auth:sanctum');
//category update with post
Route::post('/categories/{id}', [App\Http\Controllers\Api\Inventory\CategoryController::class, 'update'])->middleware('auth:sanctum');

//brands
Route::apiResource('/brands', App\Http\Controllers\Api\Inventory\BrandController::class)->middleware('auth:sanctum');

//brand update with post
Route::post('/brands/{id}', [App\Http\Controllers\Api\Inventory\BrandController::class, 'update'])->middleware('auth:sanctum');

//units
Route::apiResource('/units', App\Http\Controllers\Api\Inventory\UnitController::class)->middleware('auth:sanctum');

//warehouses
//warehouse
Route::apiResource('/warehouses', WarehouseController::class)->middleware('auth:sanctum');

//suppliers
Route::apiResource('/suppliers', App\Http\Controllers\Api\Inventory\SupplierController::class)->middleware('auth:sanctum');

//products
Route::apiResource('/products', App\Http\Controllers\Api\Inventory\ProductController::class)->middleware('auth:sanctum');

// post update product
Route::post('/products/{id}', [App\Http\Controllers\Api\Inventory\ProductController::class, 'update'])->middleware('auth:sanctum');

//purchases
Route::apiResource('/purchases', App\Http\Controllers\Api\Inventory\PurchaseController::class)->middleware('auth:sanctum');

//warehouse stocks
Route::apiResource('/warehouse-stocks', App\Http\Controllers\Api\Inventory\WarehouseStockController::class)->middleware('auth:sanctum');

//stock opname
Route::apiResource('stock-opname', App\Http\Controllers\Api\Inventory\StockOpnameController::class)->middleware('auth:sanctum');
