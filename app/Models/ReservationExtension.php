<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'reservation_id',
    'user_id',
    'extra_hours',
    'new_end_time',
    'extra_cost',
    'reason',
    'status',
])]
class ReservationExtension extends Model
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
            'extra_hours' => 'integer',
            'extra_cost' => 'integer',
        ];
    }

    /**
     * Relationship to Reservation.
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Relationship to User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get user-friendly status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'disetujui' => 'disetujui',
            'menunggu' => 'menunggu konfirmasi',
            'ditolak' => 'ditolak',
            default => (string) $this->status,
        };
    }
}
