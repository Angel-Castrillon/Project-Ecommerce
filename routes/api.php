<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsUserAuth;

//Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



//Private Routes
Route::middleware(IsUserAuth::class)->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::get('/user', 'getUser');
        Route::post('/logout', 'logout');
        Route::post('/products/catalog', [ProductCatalogController::class, 'index']);
        Route::get('/products/{id}', [ProductCatalogController::class, 'show']);
    });    
});
