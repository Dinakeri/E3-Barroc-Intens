<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'total_amount',
        'invoice_date',
        'due_date',
        'pdf_path',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
