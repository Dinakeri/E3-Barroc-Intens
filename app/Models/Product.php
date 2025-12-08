<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'cost_price',
        'sales_price',
        'description',
        'stock',
        'status',
        'length',
        'width',
        'breadth',
        'weight',
        'order_id',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }
}
