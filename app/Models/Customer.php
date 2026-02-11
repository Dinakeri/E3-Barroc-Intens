<?php

namespace App\Models;

use App\Notifications\NewCustomerNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory, Notifiable;

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

    protected static function booted()
    {
        static::created(function ($customer) {
            $users = User::whereIn('role', ['finance', 'maintenance', 'sales', 'purchasing', 'admin'])->get();

            Notification::send($users, new NewCustomerNotification($customer));
        });
    }


    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function acceptedQuote()
    {
        return $this->hasOne(Quote::class)->where('status', 'approved');
    }

    public function lastQuote()
    {
        return $this->hasOne(Quote::class)->latestOfMany();
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
        return $this->activeContract()->exists();
    }

    public function activeContract()
    {
        return $this->hasOne(Contract::class)->where('status', 'active');
    }
}
