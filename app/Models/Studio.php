<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'description',
        'price_per_hour',
        'image',
        'status',
    ];
}
