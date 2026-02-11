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
        'bkr_status',
        'kvk_number',
        'status',
        'notes',
    ];

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function acceptedQuote()
    {
        return $this->hasOne(Quote::class)->where('status', 'approved');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function isEligibleForQuote(): bool
    {
        return $this->status === 'active'
            && $this->bkr_status === 'cleared'
            && ! $this->quotes()->where('status', 'approved')->exists();
    }
}
