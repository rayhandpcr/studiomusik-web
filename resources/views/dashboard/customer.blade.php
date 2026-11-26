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
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
        border-radius: 10px;
        padding: 20px 24px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .stat-label {
        font-size: 12px;
        color: #475974;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        line-height: 1.15;
        color: #1C3562;
    }

    .stat-number.amber {
        color: #1C3562;
    }

    .stat-sub {
        font-size: 11.5px;
        color: #475974;
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
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
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
        color: #1C3562;
        line-height: 1.25;
        margin-bottom: 6px;
    }

    .nearest-datetime {
        font-size: 13.5px;
        color: #475974;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .nearest-datetime strong {
        color: #1C3562;
    }

    .nearest-divider {
        height: 1px;
        background: rgba(71, 89, 116, 0.16);
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
        color: #475974;
    }

    .nearest-total-price {
        font-size: 18px;
        font-weight: 700;
        color: #1C3562;
    }

    .nearest-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Kartu Notifikasi */
    .notif-card {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
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
        border-bottom: 1px solid rgba(71, 89, 116, 0.12);
    }

    .notif-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .notif-title {
        font-size: 13px;
        font-weight: 600;
        color: #1C3562;
    }

    .notif-desc {
        font-size: 12px;
        color: #475974;
        line-height: 1.45;
    }

    .notif-time {
        font-size: 11px;
        color: rgba(71, 89, 116, 0.7);
        margin-top: 2px;
    }

    /* Tabel Reservasi Terbaru */
    .table-card {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
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
        background: #F1F4F9;
        color: #475974;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(71, 89, 116, 0.18);
        white-space: nowrap;
    }

    .dash-table td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(71, 89, 116, 0.12);
        color: #1E293B;
        vertical-align: middle;
        white-space: nowrap;
    }

    .dash-table tbody tr:hover {
        background: rgba(28, 53, 98, 0.03);
    }

    .cell-primary {
        color: #1C3562;
        font-weight: 500;
    }

    .cell-sub {
        font-size: 11.5px;
        color: #475974;
        margin-top: 2px;
    }

    .cell-action {
        color: #1C3562;
        font-size: 12.5px;
        cursor: pointer;
    }

    .cell-action:hover {
        text-decoration: underline;
    }

    .btn-action-detail {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.3);
        color: #1C3562;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.15s ease;
    }

    .btn-action-detail:hover {
        border-color: #1C3562;
        background: rgba(28, 53, 98, 0.05);
        color: #1C3562;
    }

    .btn-action-pesan {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.3);
        color: #1C3562;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.15s ease;
    }

    .btn-action-pesan:hover {
        border-color: #1C3562;
        background: rgba(28, 53, 98, 0.05);
        color: #1C3562;
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
                    @if ($nearest->extensions->isNotEmpty())
                        @php
                            $latestNearestExt = $nearest->extensions->sortByDesc('id')->first();
                            $nearestExtRange = $nearest->end_time . '–' . $latestNearestExt->new_end_time;
                        @endphp
                        <span style="color: #A0AA54; font-size: 12px; margin-top: 2px;">
                            + Perpanjangan {{ $latestNearestExt->extra_hours }} jam ({{ $nearestExtRange }})
                        </span>
                    @endif
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
                    <p style="font-size: 14px; color: #475974; margin-bottom: 6px;">
                        Belum ada jadwal latihan terdekat.
                    </p>
                    <p style="font-size: 12px; color: #475974;">
                        Pilih studio dan jadwalkan sesi latihan bandmu sekarang.
                    </p>
                </div>
            @endif
        </div>

        <div class="nearest-actions">
            @if ($nearest)
                <a href="{{ route('reservations.show', $nearest->id) }}" class="btn-dark">
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
            <a href="{{ route('notifications.index') }}" class="btn-dark" style="width: 100%; display: flex; justify-content: center;">
                Semua notifikasi
            </a>
        </div>
    </div>
</div>

<!-- ================= 4. BARIS 3: KARTU LEBAR PENUH (Reservasi Terbaru) ================= -->
<div class="table-card" id="reservasi-terbaru">
    <h2 class="card-h2 font-serif">Reservasi terbaru</h2>
    <div class="card-sub">Daftar riwayat pemesanan studio musikmu</div>

    @if ($reservations->isEmpty())
        <div style="text-align: center; padding: 40px 16px;">
            <p style="color: #475974; font-size: 14px; margin-bottom: 12px;">
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
                            $actionUrl = route('reservations.index');
                            $actionText = 'Detail';
                            if ($st === 'dikonfirmasi') {
                                $actionUrl = route('extensions.create', ['reservation_id' => $res->id]);
                                $actionText = 'Perpanjang';
                            } elseif ($paySt === 'belum_bayar') {
                                $actionUrl = route('reservations.payment', $res->id);
                                $actionText = 'Bayar sekarang';
                            } elseif ($st === 'selesai') {
                                $actionUrl = route('reservations.create', ['studio_id' => $res->studio_id]);
                                $actionText = 'Pesan lagi';
                            }
                        @endphp
                        <tr>
                            <!-- ID / studio -->
                            <td>
                                <div class="cell-primary" style="font-family: monospace; color: #1C3562; font-weight: 600;">
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
                                @if ($res->extensions->isNotEmpty())
                                    @php
                                        $latestExt = $res->extensions->sortByDesc('id')->first();
                                        $extStatusLabel = ucfirst($latestExt->status_label ?? $latestExt->status);
                                    @endphp
                                    <div style="display: flex; align-items: center; gap: 4px; font-size: 11px; color: #475974; margin-top: 4px;">
                                        <span>+ Perpanjangan {{ $latestExt->extra_hours }} jam &middot; {{ $extStatusLabel }}</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Status Pembayaran -->
                            <td>
                                <span class="badge {{ $badgePay }}">
                                    {{ ucfirst($res->payment_label) }}
                                </span>
                            </td>

                            <!-- Tindakan -->
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <a href="{{ route('reservations.show', $res->id) }}" class="btn-action-detail">
                                        Detail
                                    </a>
                                    @if ($paySt === 'belum_bayar' && $st !== 'dibatalkan')
                                        <a href="{{ route('reservations.payment', $res->id) }}" class="btn-action-detail" style="border-color: rgba(160, 170, 84, 0.5); color: #4B531B; background: rgba(160, 170, 84, 0.15); font-weight: 600;">
                                            Bayar
                                        </a>
                                    @endif
                                    <a href="{{ route('reservations.create', ['studio_id' => $res->studio_id]) }}" class="btn-action-pesan">
                                        Pesan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-bottom-btn">
            <a href="{{ route('reservations.index') }}" class="btn-dark">
                Lihat semua reservasi
            </a>
        </div>
    @endif
</div>
@endsection
