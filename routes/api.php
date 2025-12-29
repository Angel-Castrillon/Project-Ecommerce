<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCatalogController;

Route::post('/products/catalog', [ProductCatalogController::class, 'index']);
