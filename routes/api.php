<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::prefix('categories')->group( function () {
    Route::get('/', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
    Route::post('/', [\App\Http\Controllers\Api\CategoryController::class, 'store']);
    Route::post('/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'update']);
});

Route::prefix('products')->group( function () {
    Route::get('/', [\App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::get('/my-products', [\App\Http\Controllers\Api\ProductController::class, 'all'])->middleware('auth:sanctum');
    Route::get('/{id}', [\App\Http\Controllers\Api\ProductController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/', [\App\Http\Controllers\Api\ProductController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/{id}', [\App\Http\Controllers\Api\ProductController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{id}', [\App\Http\Controllers\Api\ProductController::class, 'delete'])->middleware('auth:sanctum');
});
