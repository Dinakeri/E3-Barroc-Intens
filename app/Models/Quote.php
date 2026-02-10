<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'order_id',
        'valid_until',
        'total_amount',
        'status',
        'url',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function items()
    {
        return $this->hasMany(OfferteItem::class);
    }
}
