<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    /**
     * Display the customer dashboard view.
     */
    public function index(Request $request): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Proteksi Hak Akses: Jika admin membuka /dashboard, arahkan ke /admin/dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Ambil data seluruh reservasi milik user dari MySQL studiomusik_web
        $reservations = Reservation::with(['studio', 'extensions'])
            ->where('user_id', $user->id)
            ->orderBy('reservation_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        // 1. Reservasi aktif (dikonfirmasi atau menunggu_bayar)
        $activeReservationsCount = $reservations->whereIn('status', ['dikonfirmasi', 'menunggu_bayar'])->count();

        // 2. Jadwal bulan ini (berdasarkan bulan & tahun berjalan di DB)
        $currentYear = (int) now()->year;
        $currentMonth = (int) now()->month;
        $monthlySessionsCount = $reservations->filter(function ($item) use ($currentYear, $currentMonth) {
            $date = Carbon::parse($item->reservation_date);
            return $date->year === $currentYear && $date->month === $currentMonth && $item->status !== 'dibatalkan';
        })->count();

        // 3. Belum dibayar (total biaya reservasi dengan payment_status === 'belum_bayar')
        $unpaidTotal = (int) $reservations->where('payment_status', 'belum_bayar')
            ->where('status', '!=', 'dibatalkan')
            ->sum('total_price');

        // 4. Jadwal terdekat (reservation_date >= today, status bukan dibatalkan)
        $today = now()->toDateString();
        $nearest = $reservations->filter(function ($item) use ($today) {
            $resDate = Carbon::parse($item->reservation_date)->toDateString();
            return $resDate >= $today && $item->status !== 'dibatalkan';
        })->sortBy([
            ['reservation_date', 'asc'],
            ['start_time', 'asc'],
        ])->first();

        // 5. Notifikasi terbaru yang diturunkan langsung dari reservasi nyata
        $notifications = collect();
        foreach ($reservations as $res) {
            if ($res->payment_status === 'belum_bayar' && $res->status !== 'dibatalkan') {
                $notifications->push([
                    'title' => 'Menunggu Pembayaran',
                    'desc' => "Selesaikan pembayaran untuk booking {$res->booking_code} ({$res->studio?->name}) sebelum jadwal dimulai.",
                    'time' => $res->created_at ? $res->created_at->diffForHumans() : 'Hari ini',
                ]);
            } elseif ($res->status === 'dikonfirmasi') {
                $notifications->push([
                    'title' => 'Jadwal Terkonfirmasi',
                    'desc' => "Jadwal {$res->booking_code} di {$res->studio?->name} telah siap digunakan.",
                    'time' => $res->updated_at ? $res->updated_at->diffForHumans() : 'Baru saja',
                ]);
            }
        }

        if ($notifications->isEmpty()) {
            $notifications->push([
                'title' => 'Selamat Datang!',
                'desc' => 'Akunmu sudah aktif. Mulai tentukan studio dan jam latihan bandmu sekarang.',
                'time' => 'Baru saja',
            ]);
        }
        $notifications = $notifications->take(2);

        // 6. Daftar studio aktif dari database studiomusik_web
        $studios = Studio::where('status', 'aktif')->get();

        return view('dashboard.customer', [
            'user' => $user,
            'reservations' => $reservations,
            'activeReservationsCount' => $activeReservationsCount,
            'monthlySessionsCount' => $monthlySessionsCount,
            'unpaidTotal' => $unpaidTotal,
            'nearest' => $nearest,
            'notifications' => $notifications,
            'studios' => $studios,
        ]);
    }
}
