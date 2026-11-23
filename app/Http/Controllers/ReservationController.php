<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Display a listing of customer reservations.
     */
    public function index(Request $request): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $query = $user->reservations()->with(['studio', 'extensions'])->latest('reservation_date')->latest('id');

        // Search by booking code or studio name
        if ($search = trim((string) $request->query('q', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhereHas('studio', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Tab filter: 'semua', 'aktif', 'selesai'
        $tab = $request->query('tab', 'semua');
        if ($tab === 'aktif') {
            $query->whereIn('status', ['menunggu_bayar', 'dikonfirmasi']);
        } elseif ($tab === 'selesai') {
            $query->where('status', 'selesai');
        }

        // Status dropdown filter
        if ($status = $request->query('status')) {
            if (in_array($status, ['menunggu_bayar', 'dikonfirmasi', 'selesai', 'dibatalkan'], true)) {
                $query->where('status', $status);
            }
        }

        // Payment status dropdown filter
        if ($paymentStatus = $request->query('payment_status')) {
            if (in_array($paymentStatus, ['lunas', 'belum_bayar'], true)) {
                $query->where('payment_status', $paymentStatus);
            }
        }

        $reservations = $query->paginate(10)->withQueryString();

        // Counts for tabs
        $countAll = $user->reservations()->count();
        $countActive = $user->reservations()->whereIn('status', ['menunggu_bayar', 'dikonfirmasi'])->count();
        $countCompleted = $user->reservations()->where('status', 'selesai')->count();

        // Unpaid reservation for bottom notification card
        $unpaidReservation = $user->reservations()
            ->where('payment_status', 'belum_bayar')
            ->where('status', '!=', 'dibatalkan')
            ->latest('id')
            ->first();

        return view('reservations.index', [
            'user' => $user,
            'reservations' => $reservations,
            'tab' => $tab,
            'countAll' => $countAll,
            'countActive' => $countActive,
            'countCompleted' => $countCompleted,
            'unpaidReservation' => $unpaidReservation,
        ]);
    }

    /**
     * Display the reservation creation form.
     */
    public function create(Request $request): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $studios = Studio::where('status', 'aktif')->get();
        $defaultStudioId = (int) ($request->query('studio_id') ?? ($studios->first()?->id ?? 1));

        return view('reservations.create', [
            'user' => $user,
            'studios' => $studios,
            'defaultStudioId' => $defaultStudioId,
        ]);
    }

    /**
     * Get booked slots for a specific studio and date (JSON).
     */
    public function bookedSlots(Request $request): JsonResponse
    {
        $request->validate([
            'studio_id' => ['required', 'integer'],
            'date' => ['required', 'date'],
        ]);

        $studioId = $request->query('studio_id');
        $date = Carbon::parse($request->query('date'))->toDateString();

        $reservations = Reservation::where('studio_id', $studioId)
            ->whereDate('reservation_date', $date)
            ->where('status', '!=', 'dibatalkan')
            ->get();

        $bookedSlots = [];

        foreach ($reservations as $res) {
            $startHour = (int) explode(':', str_replace('.', ':', $res->start_time))[0];
            $endHour = (int) explode(':', str_replace('.', ':', $res->end_time))[0];

            for ($h = $startHour; $h < $endHour; $h++) {
                $slotKey = sprintf('%02d.00', $h);
                if (!in_array($slotKey, $bookedSlots, true)) {
                    $bookedSlots[] = $slotKey;
                }
            }
        }

        return response()->json([
            'studio_id' => $studioId,
            'date' => $date,
            'booked_slots' => $bookedSlots,
        ]);
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Jika slots dikirim sebagai string dipisahkan koma, decode ke array
        if ($request->has('slots') && is_string($request->input('slots'))) {
            $decoded = json_decode($request->input('slots'), true);
            if (is_array($decoded)) {
                $request->merge(['slots' => $decoded]);
            } else {
                $request->merge(['slots' => array_filter(explode(',', $request->input('slots')))]);
            }
        }

        $validated = $request->validate([
            'studio_id' => ['required', 'exists:studios,id'],
            'reservation_date' => ['required', 'date', 'after_or_equal:today'],
            'slots' => ['required', 'array', 'min:1'],
            'slots.*' => ['string'],
            'notes' => ['nullable', 'string', 'max:500'],
            'agree_terms' => ['accepted'],
        ], [
            'studio_id.required' => 'Pilih studio terlebih dahulu.',
            'studio_id.exists' => 'Studio yang dipilih tidak valid.',
            'reservation_date.required' => 'Pilih tanggal latihan terlebih dahulu.',
            'reservation_date.after_or_equal' => 'Tanggal latihan minimal adalah hari ini.',
            'slots.required' => 'Pilih minimal satu slot jam latihan.',
            'slots.min' => 'Pilih minimal satu slot jam latihan.',
            'agree_terms.accepted' => 'Anda harus menyetujui ketentuan reservasi sebelum melanjutkan.',
        ]);

        $studio = Studio::findOrFail($validated['studio_id']);
        $date = Carbon::parse($validated['reservation_date'])->toDateString();

        // Urutkan slot jam
        $slots = $validated['slots'];
        sort($slots);

        $hours = [];
        foreach ($slots as $slot) {
            $hours[] = (int) explode(':', str_replace('.', ':', $slot))[0];
        }
        sort($hours);

        $minHour = min($hours);
        $maxHour = max($hours) + 1;
        $durationHours = count($hours);

        // Validasi tidak bentrok dengan reservasi yang ada di database
        $existingReservations = Reservation::where('studio_id', $studio->id)
            ->whereDate('reservation_date', $date)
            ->where('status', '!=', 'dibatalkan')
            ->get();

        foreach ($existingReservations as $exist) {
            $exStart = (int) explode(':', str_replace('.', ':', $exist->start_time))[0];
            $exEnd = (int) explode(':', str_replace('.', ':', $exist->end_time))[0];

            foreach ($hours as $reqHour) {
                if ($reqHour >= $exStart && $reqHour < $exEnd) {
                    return back()
                        ->withInput()
                        ->with('error', "Slot jam {$reqHour}.00 sudah terisi oleh pelanggan lain. Silakan pilih slot lain.");
                }
            }
        }

        // Generate nomor booking berurutan format Studio-001
        $nextNumber = Reservation::max('id') + 1;
        $bookingCode = 'Studio-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        while (Reservation::where('booking_code', $bookingCode)->exists()) {
            $nextNumber++;
            $bookingCode = 'Studio-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        $startTimeFormatted = sprintf('%02d.00', $minHour);
        $endTimeFormatted = sprintf('%02d.00', $maxHour);
        $totalPrice = (int) ($durationHours * $studio->price_per_hour);

        Reservation::create([
            'booking_code' => $bookingCode,
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'reservation_date' => $date,
            'start_time' => $startTimeFormatted,
            'end_time' => $endTimeFormatted,
            'duration_hours' => $durationHours,
            'total_price' => $totalPrice,
            'status' => 'menunggu_bayar',
            'payment_status' => 'belum_bayar',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('dashboard')
            ->with('success', "Reservasi berhasil dibuat dengan kode {$bookingCode}! Silakan lakukan pembayaran.");
    }

    /**
     * Display the specified reservation details.
     */
    public function show(Reservation $reservation): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        abort_if($reservation->user_id !== $user->id, 403);

        $reservation->load([
            'studio',
            'extensions' => fn ($q) => $q->latest(),
        ]);

        return view('reservations.show', compact('reservation'));
    }
}
