<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'booking_code',
    'user_id',
    'studio_id',
    'reservation_date',
    'start_time',
    'end_time',
    'duration_hours',
    'total_price',
    'status',
    'payment_status',
    'notes',
])]
class Reservation extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'reservation_date' => 'date',
            'duration_hours' => 'integer',
            'total_price' => 'integer',
        ];
    }

    /**
     * Relationship to User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to Studio.
     */
    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    /**
     * Relationship to Extensions.
     */
    public function extensions(): HasMany
    {
        return $this->hasMany(ReservationExtension::class);
    }

    /**
     * Get user-friendly status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'dikonfirmasi' => 'dikonfirmasi',
            'menunggu_bayar' => 'menunggu bayar',
            'selesai' => 'selesai',
            'dibatalkan' => 'dibatalkan',
            default => str_replace('_', ' ', (string) $this->status),
        };
    }

    /**
     * Get user-friendly payment status label.
     */
    public function getPaymentLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'lunas' => 'lunas',
            'belum_bayar' => 'belum bayar',
            default => str_replace('_', ' ', (string) $this->payment_status),
        };
    }
}
