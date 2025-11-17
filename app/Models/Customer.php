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
        'straat',
        'huisnummer',
        'postcode',
        'plaats',
        'kvk_nummer',
        'status',
        'notes',
    ];

    public function quote() {
        $this->hasOne(Quote::class);
    }

}
