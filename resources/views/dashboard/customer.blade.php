@extends('layouts.pelanggan')

@section('title', 'Dashboard Pelanggan — Studio Musik Positif')

@section('page_css')
<style>
    /* Grid 3 Kartu Statistik */
    .dash-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-box {
        background: #1A1A1A;
        border: 1px solid #262626;
        border-radius: 10px;
        padding: 20px 24px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .stat-label {
        font-size: 12px;
        color: #737373;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        line-height: 1.15;
        color: #F5F5F5;
    }

    .stat-number.amber {
        color: #F5A623;
    }

    .stat-sub {
        font-size: 11.5px;
        color: #737373;
    }

    /* Grid 2 Kolom Baris 2 */
    .dash-row-2 {
        display: grid;
        grid-template-columns: 1.75fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }

    /* Kartu Jadwal Terdekat */
    .nearest-card {
        background: #1A1A1A;
        border: 1px solid #262626;
        border-radius: 10px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .nearest-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .nearest-studio-title {
        font-size: 22px;
        font-weight: 400;
        color: #F5F5F5;
        line-height: 1.25;
        margin-bottom: 6px;
    }

    .nearest-datetime {
        font-size: 13.5px;
        color: #A3A3A3;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .nearest-datetime strong {
        color: #F5F5F5;
    }

    .nearest-divider {
        height: 1px;
        background: #262626;
        margin: 16px 0;
    }

    .nearest-total-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .nearest-total-label {
        font-size: 12.5px;
        color: #737373;
    }

    .nearest-total-price {
        font-size: 18px;
        font-weight: 700;
        color: #F5F5F5;
    }

    .nearest-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Kartu Notifikasi */
    .notif-card {
        background: #1A1A1A;
        border: 1px solid #262626;
        border-radius: 10px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 16px;
        margin-bottom: 20px;
    }

    .notif-item {
        display: flex;
        flex-direction: column;
        gap: 3px;
        padding-bottom: 14px;
        border-bottom: 1px solid #222222;
    }

    .notif-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .notif-title {
        font-size: 13px;
        font-weight: 600;
        color: #F5F5F5;
    }

    .notif-desc {
        font-size: 12px;
        color: #A3A3A3;
        line-height: 1.45;
    }

    .notif-time {
        font-size: 11px;
        color: #737373;
        margin-top: 2px;
    }

    /* Tabel Reservasi Terbaru */
    .table-card {
        background: #1A1A1A;
        border: 1px solid #262626;
        border-radius: 10px;
        padding: 24px;
    }

    .table-container {
        overflow-x: auto;
        margin-top: 16px;
    }

    .dash-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .dash-table th {
        background: #141414;
        color: #737373;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 12px 16px;
        border-bottom: 1px solid #262626;
        white-space: nowrap;
    }

    .dash-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #222222;
        color: #D4D4D8;
        vertical-align: middle;
        white-space: nowrap;
    }

    .dash-table tbody tr:hover {
        background: #202020;
    }

    .cell-primary {
        color: #F5F5F5;
        font-weight: 500;
    }

    .cell-sub {
        font-size: 11.5px;
        color: #737373;
        margin-top: 2px;
    }

    .cell-action {
        color: #F5A623;
        font-size: 12.5px;
        cursor: pointer;
    }

    .cell-action:hover {
        text-decoration: underline;
    }

    .table-bottom-btn {
        margin-top: 20px;
    }

    /* Responsive */
    @media (max-width: 960px) {
        .dash-stats-grid {
            grid-template-columns: 1fr;
        }

        .dash-row-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    // Helper format tanggal Indonesia
    $formatIndoFull = function($dateStr) {
        if (!$dateStr) return '-';
        $days = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
        $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        $dt = \Carbon\Carbon::parse($dateStr);
        $dayName = $days[$dt->format('l')] ?? $dt->format('l');
        $monthName = $months[$dt->month] ?? $dt->format('F');
        return $dayName . ', ' . $dt->day . ' ' . $monthName . ' ' . $dt->year;
    };

    $formatIndoShort = function($dateStr) {
        if (!$dateStr) return '-';
        $months = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
        $dt = \Carbon\Carbon::parse($dateStr);
        $monthName = $months[$dt->month] ?? $dt->format('M');
        return $dt->day . ' ' . $monthName . ' ' . $dt->year;
    };

    $firstName = explode(' ', auth()->user()->name)[0];
@endphp

<!-- ================= 1. HEADER HALAMAN ================= -->
<div class="page-header">
    <div class="page-eyebrow">Pelanggan / desktop</div>
    <h1 class="page-h1 font-serif">Dashboard pelanggan</h1>
    <p class="page-subtitle">
        Halo, {{ $firstName }}. Berikut ringkasan aktivitas dan jadwal latihanmu.
    </p>
</div>

<!-- ================= 2. BARIS 1: 3 KARTU RINGKASAN STATISTIK ================= -->
<div class="dash-stats-grid">
    <!-- Kartu 1: Reservasi Aktif -->
    <div class="stat-box">
        <div class="stat-label">Reservasi aktif</div>
        <div class="stat-number font-serif">{{ $activeReservationsCount }}</div>
        <div class="stat-sub">Sesi terkonfirmasi &amp; menunggu bayar</div>
    </div>

    <!-- Kartu 2: Jadwal Bulan Ini -->
    <div class="stat-box">
        <div class="stat-label">Jadwal bulan ini</div>
        <div class="stat-number font-serif">{{ $monthlySessionsCount }} sesi</div>
        <div class="stat-sub">Bulan {{ date('F Y') }}</div>
    </div>

    <!-- Kartu 3: Belum Dibayar -->
    <div class="stat-box">
        <div class="stat-label">Belum dibayar</div>
        <div class="stat-number font-serif amber">Rp{{ number_format($unpaidTotal, 0, ',', '.') }}</div>
        <div class="stat-sub">Total tagihan menunggu pembayaran</div>
    </div>
</div>

<!-- ================= 3. BARIS 2: GRID 2 KOLOM (Jadwal Terdekat + Notifikasi) ================= -->
<div class="dash-row-2">
    <!-- Kartu Kiri: Jadwal Terdekat -->
    <div class="nearest-card" id="jadwal-terdekat">
        <div>
            <div class="nearest-header">
                <h2 class="card-h2 font-serif">Jadwal terdekat</h2>
                @if ($nearest)
                    @php
                        $st = strtolower($nearest->status);
                        $badgeClass = 'badge-amber';
                        if ($st === 'dikonfirmasi' || $st === 'confirmed') {
                            $badgeClass = 'badge-green';
                        } elseif ($st === 'selesai') {
                            $badgeClass = 'badge-gray';
                        }
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ $nearest->booking_code }} &middot; {{ $nearest->status_label }}
                    </span>
                @endif
            </div>

            @if ($nearest)
                <div class="nearest-studio-title font-serif">
                    {{ $nearest->studio?->name ?? 'Studio Musik' }}
                </div>
                <div class="nearest-datetime">
                    <strong>{{ $formatIndoFull($nearest->reservation_date) }}</strong>
                    <span>{{ $nearest->start_time }}–{{ $nearest->end_time }} &middot; {{ $nearest->duration_hours }} jam</span>
                </div>

                <div class="nearest-divider"></div>

                <div class="nearest-total-row">
                    <span class="nearest-total-label">
                        Total &middot; {{ $nearest->payment_label }}
                    </span>
                    <span class="nearest-total-price">
                        Rp{{ number_format($nearest->total_price, 0, ',', '.') }}
                    </span>
                </div>
            @else
                <div style="padding: 24px 0; text-align: center;">
                    <p style="font-size: 14px; color: #A3A3A3; margin-bottom: 6px;">
                        Belum ada jadwal latihan terdekat.
                    </p>
                    <p style="font-size: 12px; color: #737373;">
                        Pilih studio dan jadwalkan sesi latihan bandmu sekarang.
                    </p>
                </div>
            @endif
        </div>

        <div class="nearest-actions">
            @if ($nearest)
                <a href="#reservasi-terbaru" class="btn-dark">
                    Lihat detail
                </a>
            @endif
            <a href="{{ route('reservations.create') }}" class="btn-amber">
                Reservasi baru
            </a>
        </div>
    </div>

    <!-- Kartu Kanan: Notifikasi Terbaru -->
    <div class="notif-card" id="notifikasi-terbaru">
        <div>
            <h2 class="card-h2 font-serif">Notifikasi terbaru</h2>
            <div class="card-sub" style="margin-bottom: 12px;">Pembaruan aktivitas reservasi</div>

            <div class="notif-list">
                @foreach ($notifications as $notif)
                    <div class="notif-item">
                        <div class="notif-title">{{ $notif['title'] }}</div>
                        <div class="notif-desc">{{ $notif['desc'] }}</div>
                        <div class="notif-time">{{ $notif['time'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <button type="button" class="btn-dark" style="width: 100%;" onclick="alert('Semua notifikasi terbaru telah ditampilkan.');">
                Semua notifikasi
            </button>
        </div>
    </div>
</div>

<!-- ================= 4. BARIS 3: KARTU LEBAR PENUH (Reservasi Terbaru) ================= -->
<div class="table-card" id="reservasi-terbaru">
    <h2 class="card-h2 font-serif">Reservasi terbaru</h2>
    <div class="card-sub">Daftar riwayat pemesanan studio musikmu</div>

    @if ($reservations->isEmpty())
        <div style="text-align: center; padding: 40px 16px;">
            <p style="color: #A3A3A3; font-size: 14px; margin-bottom: 12px;">
                Belum ada riwayat reservasi yang tercatat.
            </p>
            <a href="{{ route('reservations.create') }}" class="btn-amber">
                + Buat Reservasi Sekarang
            </a>
        </div>
    @else
        <div class="table-container">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID / studio</th>
                        <th>Tanggal &amp; jam</th>
                        <th>Total</th>
                        <th>Reservasi</th>
                        <th>Pembayaran</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $res)
                        @php
                            $st = strtolower($res->status);
                            $badgeRes = 'badge-amber';
                            if ($st === 'dikonfirmasi' || $st === 'confirmed') {
                                $badgeRes = 'badge-green';
                            } elseif ($st === 'selesai') {
                                $badgeRes = 'badge-gray';
                            } elseif ($st === 'dibatalkan' || $st === 'cancelled') {
                                $badgeRes = 'badge-red';
                            }

                            $paySt = strtolower($res->payment_status);
                            $badgePay = ($paySt === 'lunas' || $paySt === 'paid') ? 'badge-green' : 'badge-amber';

                            // Aksi kontekstual
                            $actionText = 'Detail / perpanjang';
                            if ($paySt === 'belum_bayar') {
                                $actionText = 'Detail / bayar';
                            } elseif ($st === 'selesai' || $st === 'dibatalkan') {
                                $actionText = 'Detail / pesan lagi';
                            }
                        @endphp
                        <tr>
                            <!-- ID / studio -->
                            <td>
                                <div class="cell-primary" style="font-family: monospace; color: #F5A623;">
                                    {{ $res->booking_code }}
                                </div>
                                <div class="cell-sub">
                                    {{ $res->studio?->name ?? 'Studio Musik' }}
                                </div>
                            </td>

                            <!-- Tanggal & jam -->
                            <td>
                                <div class="cell-primary">
                                    {{ $formatIndoShort($res->reservation_date) }}
                                </div>
                                <div class="cell-sub">
                                    {{ $res->start_time }}–{{ $res->end_time }}
                                </div>
                            </td>

                            <!-- Total -->
                            <td>
                                <span class="cell-primary">
                                    Rp{{ number_format($res->total_price, 0, ',', '.') }}
                                </span>
                            </td>

                            <!-- Status Reservasi -->
                            <td>
                                <span class="badge {{ $badgeRes }}">
                                    {{ ucfirst($res->status_label) }}
                                </span>
                            </td>

                            <!-- Status Pembayaran -->
                            <td>
                                <span class="badge {{ $badgePay }}">
                                    {{ ucfirst($res->payment_label) }}
                                </span>
                            </td>

                            <!-- Tindakan -->
                            <td>
                                <a href="{{ route('reservations.create', ['studio_id' => $res->studio_id]) }}" class="cell-action">
                                    {{ $actionText }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-bottom-btn">
            <button type="button" class="btn-dark" onclick="alert('Seluruh riwayat reservasi aktif telah dimuat di atas.');">
                Lihat semua reservasi
            </button>
        </div>
    @endif
</div>
@endsection
