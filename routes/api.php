<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AnalyticsController;

Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/items', [ItemController::class, 'index']);

Route::middleware('hmac')->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
});

Route::get('/analytics/orders-per-customer', [AnalyticsController::class, 'ordersPerCustomer']);
Route::get('/analytics/best-selling', [AnalyticsController::class, 'bestSelling']);
Route::get('/analytics/total-sales', [AnalyticsController::class, 'totalSales']);

// Route::get('/test', function () {
//     return 'API WORKING';
// });