<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('api_token')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Public read-only catalog endpoints
Route::get('/products', [CatalogController::class, 'products']);
Route::get('/jual-accounts', [CatalogController::class, 'jualAccounts']);
Route::get('/home', [CatalogController::class, 'home']);


