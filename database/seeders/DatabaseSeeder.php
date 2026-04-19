<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create base data
        Customer::factory(200)->create();
        Item::factory(100)->create();

        // 2. Create orders
        Order::factory(1000)->create()->each(function ($order) {

            $items = Item::inRandomOrder()->take(rand(1, 5))->get();

            $total = 0;

            foreach ($items as $item) {
                $qty = rand(1, 3);

                OrderItem::create([
                    'order_id' => $order->id,
                    'item_id' => $item->id,
                    'quantity' => $qty,
                    'price' => $item->price,
                ]);

                $total += $qty * $item->price;
            }

            $order->update([
                'total_amount' => $total
            ]);
        });
    }
}
