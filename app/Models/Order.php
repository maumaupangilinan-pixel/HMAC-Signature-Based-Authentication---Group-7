<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'total_amount'
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'order_items')
                    ->withPivot('quantity', 'price');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
