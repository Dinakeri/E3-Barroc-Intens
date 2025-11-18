<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'contact_person',
        'street',
        'house_number',
        'postcode',
        'place',
        'kvk_number',
        'status',
        'notes',
    ];

    public function quote() {
        return $this->hasOne(Quote::class);
    }

}
