<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AnalyticsController;

Route::middleware('hmac')->group(function () {

    // Customers
    Route::get('/customers', [CustomerController::class, 'index']);

    // Items
    Route::get('/items', [ItemController::class, 'index']);

    // Orders
    Route::post('/orders', [OrderController::class, 'store']);

    // Analytics
    Route::get('/analytics/orders-per-customer', [AnalyticsController::class, 'ordersPerCustomer']);
    Route::get('/analytics/best-selling', [AnalyticsController::class, 'bestSelling']);
    Route::get('/analytics/total-sales', [AnalyticsController::class, 'totalSales']);

});