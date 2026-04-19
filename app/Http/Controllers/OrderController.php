<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;


class OrderController extends Controller
{
   public function store(Request $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'total_amount' => 0
        ]);

        $total = 0;

        if (!$request->items || !is_array($request->items)) {
            return response()->json([
                'error' => 'Items are required'
            ], 422);
        }

        foreach ($request->items as $itemData) {

            $item = Item::find($itemData['item_id']);

            if (!$item) {
                return response()->json(['error' => 'Item not found'], 404);
            }

            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item->id,
                'quantity' => $itemData['quantity'],
                'price' => $item->price
            ]);

            $total += $item->price * $itemData['quantity'];
        }

        $order->update(['total_amount' => $total]);

        return response()->json($order->load('items'));
    }
}
