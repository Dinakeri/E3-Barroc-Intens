<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    /** @use HasFactory<\Database\Factories\PartFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'cost_price',
        'description',
        'stock',
        'min_stock',
        'status',
        'location',
    ];
}
