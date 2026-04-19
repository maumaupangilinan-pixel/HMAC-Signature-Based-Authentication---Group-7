<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class AnalyticsController extends Controller
{
    public function ordersPerCustomer()
    {
        return Customer::withCount('orders')->get();
    }

    public function bestSelling()
    {
        return DB::table('order_items')
            ->select('item_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('item_id')
            ->orderByDesc('total_sold')
            ->first();
    }

    public function totalSales()
    {
        return response()->json([
            'total_sales' => Order::sum('total_amount')
        ]);
    }
}
