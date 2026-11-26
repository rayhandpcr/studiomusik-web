<?php

namespace App\Http\Controllers;

use App\Models\CustomerNotification;
use App\Models\Reservation;
use App\Models\ReservationExtension;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReservationExtensionController extends Controller
{
    /**
     * Display the extension request form.
     */
    public function create(Request $request): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Active reservations owned by user that are eligible (dikonfirmasi or menunggu_bayar, not cancelled or completed)
        $eligibleReservations = $user->reservations()
            ->with('studio')
            ->whereIn('status', ['dikonfirmasi', 'menunggu_bayar'])
            ->orderBy('reservation_date')
            ->orderBy('start_time')
            ->get();

        $selectedId = (int) $request->query('reservation_id');
        $selectedReservation = $eligibleReservations->firstWhere('id', $selectedId) ?? $eligibleReservations->first();

        // Calculate default simulation conflict for the bottom warning card
        $simConflict = null;
        if ($selectedReservation) {
            $currEndHour = (int) explode(':', str_replace('.', ':', $selectedReservation->end_time))[0];
            $sim1Hour = min(24, $currEndHour + 1);
            $sim2Hour = min(24, $currEndHour + 2);

            // Check if there is an existing reservation in MySQL studiomusik_web that conflicts with currEndHour to sim2Hour
            $conflictRes = Reservation::where('studio_id', $selectedReservation->studio_id)
                ->whereDate('reservation_date', $selectedReservation->reservation_date->toDateString())
                ->where('id', '!=', $selectedReservation->id)
                ->where('status', '!=', 'dibatalkan')
                ->first();

            $pricePerHour = $selectedReservation->studio ? (int) $selectedReservation->studio->price_per_hour : 70000;

            $simConflict = [
                'conflict_range' => sprintf('%02d.00–%02d.00', $currEndHour, $sim2Hour),
                'conflict_slot' => sprintf('%02d.00–%02d.00', $sim1Hour, $sim2Hour),
                'conflict_code' => $conflictRes ? $conflictRes->booking_code : 'Studio-002',
                'conflict_hours' => 2,
                'conflict_calc' => '2 × Rp' . number_format($pricePerHour, 0, ',', '.') . ' = Rp' . number_format($pricePerHour * 2, 0, ',', '.'),
                'safe_range' => sprintf('%02d.00–%02d.00', $currEndHour, $sim1Hour),
                'badge_text' => 'Bentrok · simulasi tambah 2 jam',
            ];
        }

        return view('extensions.create', [
            'user' => $user,
            'eligibleReservations' => $eligibleReservations,
            'selectedReservation' => $selectedReservation,
            'simConflict' => $simConflict,
        ]);
    }

    /**
     * Real-time slot availability & cost calculation check (JSON).
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'reservation_id' => ['required', 'integer'],
            'extra_hours' => ['required', 'integer', 'in:1,2,3'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $reservation = Reservation::with('studio')
            ->where('id', $request->query('reservation_id'))
            ->where('user_id', $user->id)
            ->whereIn('status', ['dikonfirmasi', 'menunggu_bayar'])
            ->first();

        if (!$reservation) {
            return response()->json([
                'available' => false,
                'message' => 'Reservasi tidak ditemukan atau tidak valid.',
            ], 404);
        }

        $extraHours = (int) $request->query('extra_hours');
        $studio = $reservation->studio;

        // Current start and end hour
        $currEndHour = (int) explode(':', str_replace('.', ':', $reservation->end_time))[0];
        $targetEndHour = $currEndHour + $extraHours;

        if ($targetEndHour > 24) {
            return response()->json([
                'available' => false,
                'message' => 'Perpanjangan melebihi jam operasional studio (maksimal hingga pukul 24.00).',
                'conflict_details' => 'Melebihi batas jam operasional studio 24.00.',
            ]);
        }

        // Check if extra hours overlap with any existing reservation for the same studio & date
        $conflicts = Reservation::where('studio_id', $reservation->studio_id)
            ->whereDate('reservation_date', $reservation->reservation_date->toDateString())
            ->where('id', '!=', $reservation->id)
            ->where('status', '!=', 'dibatalkan')
            ->get();

        $isAvailable = true;
        $conflictDetails = null;
        $conflictCode = null;
        $conflictSlot = null;

        foreach ($conflicts as $conflict) {
            $cStart = (int) explode(':', str_replace('.', ':', $conflict->start_time))[0];
            $cEnd = (int) explode(':', str_replace('.', ':', $conflict->end_time))[0];

            // If requested extension window overlaps with this existing reservation
            if ($currEndHour < $cEnd && $targetEndHour > $cStart) {
                $isAvailable = false;
                $conflictDetails = "Slot jam {$conflict->start_time}–{$conflict->end_time} telah dipesan untuk {$conflict->booking_code}.";
                $conflictCode = $conflict->booking_code;
                $conflictSlot = "{$conflict->start_time}–{$conflict->end_time}";
                break;
            }
        }

        $pricePerHour = $studio ? (int) $studio->price_per_hour : 70000;
        $extraCost = $extraHours * $pricePerHour;
        $newEndTimeFormatted = sprintf('%02d.00', $targetEndHour);
        $extraRangeFormatted = "{$reservation->end_time}–{$newEndTimeFormatted}";
        $totalCost = (int) $reservation->total_price + $extraCost;

        $sim1Hour = min(24, $currEndHour + 1);
        $sim2Hour = min(24, $currEndHour + 2);

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable
                ? 'Slot waktu perpanjangan tersedia!'
                : 'Slot waktu bentrok dengan jadwal lain.',
            'conflict_details' => $conflictDetails,
            'conflict_code' => $conflictCode,
            'conflict_slot' => $conflictSlot,
            'reservation_id' => $reservation->id,
            'booking_code' => $reservation->booking_code,
            'studio_name' => $studio?->name ?? 'Studio',
            'current_end_time' => $reservation->end_time,
            'new_end_time' => $newEndTimeFormatted,
            'extra_hours' => $extraHours,
            'extra_range' => $extraRangeFormatted,
            'price_per_hour' => $pricePerHour,
            'extra_cost' => $extraCost,
            'initial_cost' => (int) $reservation->total_price,
            'total_cost' => $totalCost,
            'sim_conflict_range' => sprintf('%02d.00–%02d.00', $currEndHour, $sim2Hour),
            'sim_conflict_slot' => sprintf('%02d.00–%02d.00', $sim1Hour, $sim2Hour),
            'sim_safe_range' => sprintf('%02d.00–%02d.00', $currEndHour, $sim1Hour),
        ]);
    }

    /**
     * Store a newly submitted reservation extension request.
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $validated = $request->validate([
            'reservation_id' => ['required', 'integer'],
            'extra_hours' => ['required', 'integer', 'in:1,2,3'],
            'reason' => ['nullable', 'string', 'max:500'],
        ], [
            'reservation_id.required' => 'Pilih reservasi yang ingin diperpanjang.',
            'extra_hours.required' => 'Pilih durasi tambahan waktu perpanjangan.',
            'extra_hours.in' => 'Durasi perpanjangan yang diizinkan adalah 1, 2, atau 3 jam.',
        ]);

        $reservation = Reservation::with('studio')
            ->where('id', $validated['reservation_id'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['dikonfirmasi', 'menunggu_bayar'])
            ->first();

        if (!$reservation) {
            return back()
                ->withInput()
                ->with('error', 'Reservasi tidak valid atau belum aktif untuk diajukan perpanjangan.');
        }

        $extraHours = (int) $validated['extra_hours'];
        $currEndHour = (int) explode(':', str_replace('.', ':', $reservation->end_time))[0];
        $targetEndHour = $currEndHour + $extraHours;

        if ($targetEndHour > 24) {
            return back()
                ->withInput()
                ->with('error', 'Perpanjangan melebihi jam operasional studio (maksimal pukul 24.00).');
        }

        // Double check database conflict
        $conflicts = Reservation::where('studio_id', $reservation->studio_id)
            ->whereDate('reservation_date', $reservation->reservation_date->toDateString())
            ->where('id', '!=', $reservation->id)
            ->where('status', '!=', 'dibatalkan')
            ->get();

        foreach ($conflicts as $conflict) {
            $cStart = (int) explode(':', str_replace('.', ':', $conflict->start_time))[0];
            $cEnd = (int) explode(':', str_replace('.', ':', $conflict->end_time))[0];

            if ($currEndHour < $cEnd && $targetEndHour > $cStart) {
                return back()
                    ->withInput()
                    ->with('error', "Slot perpanjangan tidak tersedia karena jam {$conflict->start_time}–{$conflict->end_time} sudah dipesan untuk {$conflict->booking_code}.");
            }
        }

        $pricePerHour = $reservation->studio ? (int) $reservation->studio->price_per_hour : 70000;
        $extraCost = $extraHours * $pricePerHour;
        $newEndTimeFormatted = sprintf('%02d.00', $targetEndHour);

        ReservationExtension::create([
            'reservation_id' => $reservation->id,
            'user_id' => $user->id,
            'extra_hours' => $extraHours,
            'new_end_time' => $newEndTimeFormatted,
            'extra_cost' => $extraCost,
            'reason' => $validated['reason'] ?? null,
            'status' => 'menunggu',
        ]);

        CustomerNotification::create([
            'user_id' => $user->id,
            'reservation_id' => $reservation->id,
            'title' => 'Pengajuan perpanjangan dikirim',
            'message' => "Pengajuan perpanjangan +{$extraHours} jam untuk reservasi {$reservation->booking_code} ({$reservation->studio?->name}) telah dikirim dengan biaya tambahan Rp" . number_format($extraCost, 0, ',', '.') . ". Menunggu persetujuan admin.",
            'type' => 'extension_requested',
            'is_read' => false,
            'send_at' => now(),
        ]);

        return redirect()->route('reservations.index')
            ->with('success', "Pengajuan perpanjangan +{$extraHours} jam untuk reservasi {$reservation->booking_code} berhasil dikirim! Menunggu persetujuan admin.");
    }
}
