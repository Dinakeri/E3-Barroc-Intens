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
        'price',
        'product',
        'status',
        'url',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
