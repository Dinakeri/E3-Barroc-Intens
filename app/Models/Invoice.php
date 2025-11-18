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
}
