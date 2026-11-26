<?php

namespace App\Http\Controllers;

use App\Models\CostSplit;
use App\Models\CustomerNotification;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CostSplitController extends Controller
{
    /**
     * Display the cost split management page.
     */
    public function index(Request $request): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Ambil semua reservasi milik user untuk dropdown pilihan
        $reservations = Reservation::with(['studio', 'costSplits'])
            ->where('user_id', $user->id)
            ->where('status', '!=', 'dibatalkan')
            ->orderBy('reservation_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        // Tentukan reservasi yang sedang dipilih
        $selectedReservation = null;
        if ($reservations->isNotEmpty()) {
            $reqResId = $request->query('reservation_id');
            if ($reqResId) {
                $selectedReservation = $reservations->firstWhere('id', (int) $reqResId);
            }
            if (!$selectedReservation) {
                $selectedReservation = $reservations->first();
            }
        }

        // Hitung metrik pembagian biaya
        $costSplits = collect();
        $totalCost = 0;
        $collectedAmount = 0;
        $remainingAmount = 0;
        $progressPercent = 0;
        $paidCount = 0;
        $totalMembers = 0;
        $totalSplitAmount = 0;

        if ($selectedReservation) {
            $costSplits = $selectedReservation->costSplits()->orderBy('id')->get();
            $totalCost = (int) $selectedReservation->total_price;
            $collectedAmount = (int) $costSplits->where('payment_status', 'sudah_bayar')->sum('amount');
            $totalSplitAmount = (int) $costSplits->sum('amount');
            $remainingAmount = max(0, $totalCost - $collectedAmount);
            $progressPercent = $totalCost > 0 ? min(100, (int) round(($collectedAmount / $totalCost) * 100)) : 0;
            $paidCount = $costSplits->where('payment_status', 'sudah_bayar')->count();
            $totalMembers = $costSplits->count();
        }

        return view('cost-splits.index', [
            'user' => $user,
            'reservations' => $reservations,
            'selectedReservation' => $selectedReservation,
            'costSplits' => $costSplits,
            'totalCost' => $totalCost,
            'collectedAmount' => $collectedAmount,
            'remainingAmount' => $remainingAmount,
            'progressPercent' => $progressPercent,
            'paidCount' => $paidCount,
            'totalMembers' => $totalMembers,
            'totalSplitAmount' => $totalSplitAmount,
        ]);
    }

    /**
     * Store or update a member contribution.
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
            'split_id' => ['nullable', 'integer'],
            'member_name' => ['required', 'string', 'max:100'],
            'amount' => ['required'],
            'payment_status' => ['required', 'in:belum_bayar,sudah_bayar'],
        ], [
            'reservation_id.required' => 'Pilih reservasi terlebih dahulu.',
            'member_name.required' => 'Nama anggota wajib diisi.',
            'amount.required' => 'Nominal kontribusi wajib diisi.',
            'payment_status.required' => 'Pilih status pembayaran.',
        ]);

        $reservation = Reservation::where('id', $validated['reservation_id'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Bersihkan nominal dari format Rp dan titik pemisah ribuan
        $rawAmount = is_numeric($validated['amount'])
            ? (int) $validated['amount']
            : (int) preg_replace('/[^0-9]/', '', (string) $validated['amount']);

        if ($rawAmount <= 0) {
            return back()->withInput()->with('error', 'Nominal kontribusi harus lebih besar dari Rp0.');
        }

        $splitId = $validated['split_id'] ?? null;
        $isPaid = $validated['payment_status'] === 'sudah_bayar';

        if ($splitId) {
            $split = CostSplit::where('id', $splitId)
                ->where('reservation_id', $reservation->id)
                ->firstOrFail();

            $split->update([
                'member_name' => $validated['member_name'],
                'amount' => $rawAmount,
                'payment_status' => $validated['payment_status'],
                'paid_at' => $isPaid ? ($split->paid_at ?? now()) : null,
            ]);

            $message = "Data kontribusi anggota {$split->member_name} berhasil diperbarui!";
        } else {
            CostSplit::create([
                'reservation_id' => $reservation->id,
                'member_name' => $validated['member_name'],
                'amount' => $rawAmount,
                'payment_status' => $validated['payment_status'],
                'paid_at' => $isPaid ? now() : null,
            ]);

            $message = "Anggota {$validated['member_name']} berhasil ditambahkan ke pembagian biaya!";
        }

        // Picu notifikasi jika masih ada anggota yang belum bayar
        $this->syncIncompleteNotification($reservation, $user);

        return redirect()->route('cost-splits.index', ['reservation_id' => $reservation->id])
            ->with('success', $message);
    }

    /**
     * Divide total reservation cost equally among members.
     */
    public function equalSplit(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'reservation_id' => ['required', 'integer'],
        ]);

        $reservation = Reservation::where('id', $request->input('reservation_id'))
            ->where('user_id', $user->id)
            ->firstOrFail();

        $costSplits = $reservation->costSplits;
        $totalCost = (int) $reservation->total_price;

        if ($costSplits->isEmpty()) {
            // Buat slot awal 4 anggota jika daftar masih kosong
            $memberCount = 4;
            $perPerson = (int) ceil($totalCost / $memberCount);

            for ($i = 1; $i <= $memberCount; $i++) {
                CostSplit::create([
                    'reservation_id' => $reservation->id,
                    'member_name' => "Anggota {$i}",
                    'amount' => $perPerson,
                    'payment_status' => 'belum_bayar',
                ]);
            }
        } else {
            // Bagi rata kepada anggota yang sudah terdaftar
            $memberCount = $costSplits->count();
            $perPerson = (int) ceil($totalCost / $memberCount);

            foreach ($costSplits as $split) {
                $split->update([
                    'amount' => $perPerson,
                ]);
            }
        }

        $this->syncIncompleteNotification($reservation, $user);

        return redirect()->route('cost-splits.index', ['reservation_id' => $reservation->id])
            ->with('success', "Biaya berhasil dibagi rata kepada {$memberCount} anggota (Rp" . number_format($perPerson, 0, ',', '.') . " / orang)!");
    }

    /**
     * Send reminder notification for a specific unpaid member.
     */
    public function remind(CostSplit $costSplit): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $reservation = $costSplit->reservation;
        abort_if(!$reservation || $reservation->user_id !== $user->id, 403);

        $amountFormatted = 'Rp' . number_format($costSplit->amount, 0, ',', '.');

        CustomerNotification::create([
            'user_id' => $user->id,
            'reservation_id' => $reservation->id,
            'title' => "Pengingat Iuran: {$costSplit->member_name}",
            'message' => "Anggota band {$costSplit->member_name} belum menyelesaikan iuran {$amountFormatted} untuk reservasi {$reservation->booking_code} ({$reservation->studio?->name}).",
            'type' => 'cost_split_incomplete',
            'is_read' => false,
            'send_at' => now(),
        ]);

        return redirect()->route('cost-splits.index', ['reservation_id' => $reservation->id])
            ->with('success', "Pengingat iuran untuk {$costSplit->member_name} berhasil dibuat dan dikirim ke notifikasi!");
    }

    /**
     * Helper to synchronize incomplete cost split notification.
     */
    protected function syncIncompleteNotification(Reservation $reservation, $user): void
    {
        $unpaidMembers = CostSplit::where('reservation_id', $reservation->id)
            ->where('payment_status', 'belum_bayar')
            ->pluck('member_name')
            ->toArray();

        if (!empty($unpaidMembers)) {
            $totalMembers = CostSplit::where('reservation_id', $reservation->id)->count();
            $paidMembers = CostSplit::where('reservation_id', $reservation->id)
                ->where('payment_status', 'sudah_bayar')
                ->count();

            $namesText = implode(', ', array_slice($unpaidMembers, 0, 3));
            if (count($unpaidMembers) > 3) {
                $namesText .= ' dan lainnya';
            }

            CustomerNotification::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'reservation_id' => $reservation->id,
                    'type' => 'cost_split_incomplete',
                ],
                [
                    'title' => 'Kontribusi anggota belum lengkap',
                    'message' => "Reservasi {$reservation->booking_code} ({$reservation->studio?->name}): {$paidMembers} dari {$totalMembers} anggota telah membayar. Belum lunas: {$namesText}.",
                    'is_read' => false,
                    'send_at' => now(),
                ]
            );
        }
    }
}
