<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
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

    public function items()
    {
        return $this->hasMany(OfferteItem::class);
    }
}
