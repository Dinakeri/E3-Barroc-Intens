<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_id',
        'contract_id',
        'total_amount',
        'invoice_date',
        'due_date',
        'pdf_path',
        'status',
    ];

    /**
     * Cast invoice date fields to Carbon instances.
     */
    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

}
