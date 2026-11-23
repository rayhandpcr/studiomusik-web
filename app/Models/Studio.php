<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Get reservations for this studio.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
