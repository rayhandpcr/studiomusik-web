<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'reservation_id',
    'title',
    'message',
    'type',
    'is_read',
    'send_at',
])]
class CustomerNotification extends Model
{
    use HasFactory;

    /**
     * Table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'send_at' => 'datetime',
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
     * Relationship to Reservation.
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Check and generate schedule reminder notifications for today or tomorrow.
     */
    public static function checkAndCreateScheduleReminders(User $user): void
    {
        $today = now()->toDateString();
        $tomorrow = now()->addDay()->toDateString();

        $activeReservations = Reservation::with('studio')
            ->where('user_id', $user->id)
            ->where('status', 'dikonfirmasi')
            ->whereBetween('reservation_date', [$today, $tomorrow])
            ->get();

        foreach ($activeReservations as $res) {
            $alreadyExists = static::where('user_id', $user->id)
                ->where('reservation_id', $res->id)
                ->whereIn('type', ['reservation_confirmed', 'session_reminder'])
                ->exists();

            if (!$alreadyExists) {
                $dateFormatted = Carbon::parse($res->reservation_date)->translatedFormat('d F Y');
                $isToday = Carbon::parse($res->reservation_date)->isToday();
                $timingText = $isToday ? 'hari ini' : 'besok';

                static::create([
                    'user_id' => $user->id,
                    'reservation_id' => $res->id,
                    'title' => "Pengingat Jadwal Latihan ({$res->booking_code})",
                    'message' => "Sesi latihan di {$res->studio?->name} dijadwalkan {$timingText} ({$dateFormatted}) pukul {$res->start_time}–{$res->end_time}. Harap datang 10 menit sebelum sesi dimulai.",
                    'type' => 'session_reminder',
                    'is_read' => false,
                    'send_at' => now(),
                ]);
            }
        }
    }
}
