<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClockEntry extends Model
{
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
