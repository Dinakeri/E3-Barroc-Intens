<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'email_id',
        'Company',
        'ContactPerson',
        'Title',
        'Content',
        'Product',
        'Date',
        'AssignedTo',
        'Part_ID'
    ];
}
