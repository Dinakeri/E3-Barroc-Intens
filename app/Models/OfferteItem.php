<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OfferteItem extends Model
{
    protected $fillable = [
        'offerte_id',
        'product_id',
        'name',
        'price',
        'quantity',
    ];

    public function offerte()
    {
        return $this->belongsTo(Quote::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
