<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'total_amount',
        'status',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }
}
