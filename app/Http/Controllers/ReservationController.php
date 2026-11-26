<?php

namespace App\Http\Controllers;

use App\Models\CustomerNotification;
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

        $reservation = Reservation::create([
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

        $dateFormatted = Carbon::parse($date)->translatedFormat('d F Y');
        CustomerNotification::create([
            'user_id' => $user->id,
            'reservation_id' => $reservation->id,
            'title' => 'Selesaikan pembayaran reservasi',
            'message' => "Reservasi {$bookingCode} ({$studio->name}) pada {$dateFormatted} jam {$startTimeFormatted}–{$endTimeFormatted} berhasil dibuat. Total tagihan Rp" . number_format($totalPrice, 0, ',', '.') . ". Selesaikan pembayaran sebelum sesi dimulai.",
            'type' => 'payment_reminder',
            'is_read' => false,
            'send_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', "Reservasi berhasil dibuat dengan kode {$bookingCode}! Silakan lakukan pembayaran.");
    }

    /**
     * Display the payment page for a reservation.
     */
    public function payment(Reservation $reservation): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        abort_if($reservation->user_id !== $user->id, 403);

        if ($reservation->payment_status === 'lunas') {
            return redirect()->route('reservations.show', $reservation)
                ->with('info', 'Reservasi ini sudah berstatus lunas.');
        }

        $reservation->load('studio');

        return view('reservations.payment', compact('reservation'));
    }

    /**
     * Process reservation payment confirmation.
     */
    public function pay(Request $request, Reservation $reservation): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        abort_if($reservation->user_id !== $user->id, 403);

        $validated = $request->validate([
            'payment_method' => ['required', 'in:transfer_bank,qris,cash'],
            'payment_proof' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'payment_method.required' => 'Pilih metode pembayaran terlebih dahulu.',
            'payment_method.in' => 'Metode pembayaran yang dipilih tidak valid.',
            'payment_proof.mimes' => 'Bukti pembayaran harus berformat JPG, JPEG, PNG, atau PDF.',
            'payment_proof.max' => 'Ukuran bukti pembayaran maksimal 2 MB.',
        ]);

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/payments');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $proofPath = 'uploads/payments/' . $filename;
        }

        $methodLabels = [
            'transfer_bank' => 'Transfer bank',
            'qris' => 'QRIS / E-Wallet',
            'cash' => 'Tunai di studio',
        ];
        $methodLabel = $methodLabels[$validated['payment_method']] ?? 'Transfer bank';

        $notes = $reservation->notes;
        if (!empty($validated['notes'])) {
            $notes = $notes ? ($notes . " | Catatan bayar: " . $validated['notes']) : ("Catatan bayar: " . $validated['notes']);
        }

        $reservation->update([
            'payment_method' => $methodLabel,
            'payment_proof' => $proofPath ?? $reservation->payment_proof,
            'payment_status' => 'lunas',
            'status' => 'dikonfirmasi',
            'paid_at' => now(),
            'notes' => $notes,
        ]);

        // Tandai notifikasi reminder pembayaran sebagai sudah dibaca
        CustomerNotification::where('reservation_id', $reservation->id)
            ->where('type', 'payment_reminder')
            ->update(['is_read' => true]);

        // Buat notifikasi konfirmasi nyata
        $dateFormatted = Carbon::parse($reservation->reservation_date)->translatedFormat('l d F Y');
        CustomerNotification::create([
            'user_id' => $user->id,
            'reservation_id' => $reservation->id,
            'title' => 'Reservasi berhasil dikonfirmasi',
            'message' => "{$reservation->booking_code} · {$reservation->studio?->name}, {$dateFormatted}, {$reservation->start_time}–{$reservation->end_time}. Pembayaran Rp" . number_format($reservation->total_price, 0, ',', '.') . " telah diterima.",
            'type' => 'reservation_confirmed',
            'is_read' => false,
            'send_at' => now(),
        ]);

        return redirect()->route('reservations.show', $reservation)
            ->with('success', "Pembayaran untuk reservasi {$reservation->booking_code} berhasil dikonfirmasi! Jadwal latihanmu telah aktif.");
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
