@extends('layouts.pelanggan')

@section('title', 'Detail Reservasi ' . $reservation->booking_code . ' — Studio Musik Positif')

@section('page_css')
<style>
    .show-back-nav {
        margin-bottom: 16px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #A3A3A3;
        font-size: 13px;
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .back-link:hover {
        color: #F5A623;
    }

    .show-page-header {
        margin-bottom: 24px;
    }

    .show-eyebrow {
        font-size: 11px;
        color: #737373;
        margin-bottom: 4px;
        letter-spacing: 0.02em;
    }

    .show-h1 {
        font-family: 'Times New Roman', Times, Georgia, serif;
        font-size: 32px;
        font-weight: 400;
        color: #F5F5F5;
        line-height: 1.2;
        margin-bottom: 6px;
    }

    .show-sub {
        font-size: 13px;
        color: #A3A3A3;
        line-height: 1.5;
    }

    /* Grid 2 Kolom Atas (1.4fr 1fr) */
    .show-grid-top {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 20px;
        align-items: start;
        margin-bottom: 20px;
    }

    .show-card {
        background: #1A1A1A;
        border: 1px solid #262626;
        border-radius: 10px;
        padding: 24px;
    }

    .show-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .show-card-title {
        font-family: 'Times New Roman', Times, Georgia, serif;
        font-size: 20px;
        font-weight: 400;
        color: #F5F5F5;
    }

    /* List Baris Informasi */
    .detail-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .detail-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        font-size: 13px;
        padding-bottom: 10px;
        border-bottom: 1px solid #222222;
    }

    .detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .detail-label {
        color: #737373;
        min-width: 140px;
    }

    .detail-val {
        color: #F5F5F5;
        font-weight: 500;
        text-align: right;
    }

    .booking-code-highlight {
        font-family: monospace;
        color: #F5A623;
        font-weight: 700;
        font-size: 14px;
    }

    /* Kartu Kanan: Rincian Biaya */
    .price-summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 13px;
        border-bottom: 1px solid #222222;
    }

    .price-summary-row:last-child {
        border-bottom: none;
    }

    .show-divider {
        height: 1px;
        background: #2E2E2E;
        margin: 16px 0 12px;
    }

    .grand-total-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 6px;
    }

    .grand-total-label {
        font-size: 14px;
        font-weight: 600;
        color: #F5F5F5;
    }

    .grand-total-val {
        font-size: 20px;
        font-weight: 700;
        color: #F5A623;
    }

    /* Kartu Bawah: Perpanjangan Waktu */
    .show-card-bottom {
        background: #1A1A1A;
        border: 1px solid #262626;
        border-radius: 10px;
        padding: 24px;
    }

    .ext-table-wrap {
        overflow-x: auto;
        margin-top: 16px;
    }

    .ext-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        text-align: left;
    }

    .ext-table th {
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

    .ext-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #222222;
        color: #D4D4D8;
        vertical-align: middle;
        white-space: nowrap;
    }

    .ext-table tbody tr:hover {
        background: #202020;
    }

    .empty-ext-box {
        text-align: center;
        padding: 32px 16px;
    }

    .empty-ext-text {
        font-size: 13px;
        color: #A3A3A3;
        margin-bottom: 16px;
    }

    @media (max-width: 900px) {
        .show-grid-top {
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

    $st = strtolower($reservation->status);
    $badgeRes = 'badge-amber';
    if ($st === 'dikonfirmasi' || $st === 'confirmed') {
        $badgeRes = 'badge-green';
    } elseif ($st === 'selesai') {
        $badgeRes = 'badge-gray';
    } elseif ($st === 'dibatalkan' || $st === 'cancelled') {
        $badgeRes = 'badge-red';
    }

    $paySt = strtolower($reservation->payment_status);
    $badgePay = ($paySt === 'lunas' || $paySt === 'paid') ? 'badge-green' : 'badge-amber';

    $hasExtensions = $reservation->extensions->isNotEmpty();
    $totalExtCost = (int) $reservation->extensions->where('status', '!=', 'ditolak')->sum('extra_cost');
    $grandTotal = (int) $reservation->total_price + $totalExtCost;
@endphp

<!-- Navigasi Kembali -->
<div class="show-back-nav">
    <a href="{{ route('reservations.index') }}" class="back-link">
        <span>&larr; Kembali ke daftar reservasi</span>
    </a>
</div>

<!-- ================= 1. HEADER HALAMAN ================= -->
<div class="show-page-header">
    <div class="show-eyebrow">Pelanggan / desktop / detail reservasi</div>
    <h1 class="show-h1">Detail reservasi {{ $reservation->booking_code }}</h1>
    <p class="show-sub">
        Rincian pesanan studio, pembayaran, dan pengajuan perpanjangan waktu.
    </p>
</div>

<!-- ================= 2. GRID 2 KOLOM ATAS (1.4fr 1fr) ================= -->
<div class="show-grid-top">
    <!-- ================= KARTU KIRI: DETAIL PESANAN ================= -->
    <div class="show-card">
        <div class="show-card-header">
            <h2 class="show-card-title">Detail pesanan</h2>
            <span class="badge {{ $badgeRes }}">
                {{ ucfirst($reservation->status_label) }}
            </span>
        </div>

        <div class="detail-list">
            <div class="detail-row">
                <span class="detail-label">ID Booking</span>
                <span class="detail-val booking-code-highlight">{{ $reservation->booking_code }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Studio Musik</span>
                <span class="detail-val">{{ $reservation->studio?->name ?? 'Studio Musik' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Tanggal Latihan</span>
                <span class="detail-val">{{ $formatIndoFull($reservation->reservation_date) }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Jam Sesi Awal</span>
                <span class="detail-val">{{ $reservation->start_time }}–{{ $reservation->end_time }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Durasi Awal</span>
                <span class="detail-val">{{ $reservation->duration_hours }} Jam</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Catatan Pelanggan</span>
                <span class="detail-val" style="max-width: 280px; word-break: break-word;">
                    {{ $reservation->notes ?: '-' }}
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Waktu Pemesanan</span>
                <span class="detail-val" style="color: #A3A3A3;">
                    {{ $reservation->created_at ? $reservation->created_at->format('d M Y, H:i') : '-' }} WIB
                </span>
            </div>
        </div>
    </div>

    <!-- ================= KARTU KANAN: RINCIAN BIAYA ================= -->
    <div class="show-card">
        <div class="show-card-header">
            <h2 class="show-card-title">Rincian biaya</h2>
            <span class="badge {{ $badgePay }}">
                {{ ucfirst($reservation->payment_label) }}
            </span>
        </div>

        <div>
            <div class="price-summary-row">
                <span style="color: #A3A3A3;">Tarif per jam</span>
                <span style="color: #F5F5F5;">
                    Rp{{ number_format($reservation->studio?->price_per_hour ?? 70000, 0, ',', '.') }}
                </span>
            </div>

            <div class="price-summary-row">
                <span style="color: #A3A3A3;">Biaya sesi awal ({{ $reservation->duration_hours }} jam)</span>
                <span style="color: #F5F5F5;">
                    Rp{{ number_format($reservation->total_price, 0, ',', '.') }}
                </span>
            </div>

            @if ($hasExtensions)
                <div class="price-summary-row">
                    <span style="color: #A3A3A3;">Biaya perpanjangan</span>
                    <span style="color: #F5A623;">
                        +Rp{{ number_format($totalExtCost, 0, ',', '.') }}
                    </span>
                </div>
            @endif

            <div class="show-divider"></div>

            <div class="grand-total-row">
                <span class="grand-total-label">Total keseluruhan</span>
                <span class="grand-total-val">
                    Rp{{ number_format($grandTotal, 0, ',', '.') }}
                </span>
            </div>

            @if ($paySt === 'belum_bayar')
                <div style="margin-top: 18px; padding: 12px 14px; background: rgba(245, 166, 35, 0.08); border: 1px solid rgba(245, 166, 35, 0.25); border-radius: 7px; font-size: 12px; color: #D4D4D8; line-height: 1.45;">
                    Tagihan dapat diselesaikan langsung di kasir Studio Musik Positif saat kedatangan atau melalui konfirmasi staf.
                </div>
            @endif

            @if (in_array($st, ['dikonfirmasi', 'menunggu_bayar']))
                <div style="margin-top: 18px;">
                    <a href="{{ route('extensions.create', ['reservation_id' => $reservation->id]) }}" class="btn-amber" style="width: 100%;">
                        + Ajukan perpanjangan jam
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- ================= 3. KARTU BAWAH LEBAR PENUH: RINCIAN PERPANJANGAN WAKTU ================= -->
<div class="show-card-bottom">
    <h2 class="show-card-title">Rincian perpanjangan waktu</h2>

    @if ($hasExtensions)
        <div class="ext-table-wrap">
            <table class="ext-table">
                <thead>
                    <tr>
                        <th>Durasi</th>
                        <th>Jam Tambahan</th>
                        <th>Total Waktu Latihan</th>
                        <th>Biaya Tambahan</th>
                        <th>Alasan</th>
                        <th>Waktu Pengajuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservation->extensions as $ext)
                        @php
                            $extSt = strtolower($ext->status);
                            $extBadge = 'badge-amber';
                            if ($extSt === 'disetujui') {
                                $extBadge = 'badge-green';
                            } elseif ($extSt === 'ditolak') {
                                $extBadge = 'badge-red';
                            }
                        @endphp
                        <tr>
                            <!-- Durasi -->
                            <td style="color: #F5A623; font-weight: 600;">
                                +{{ $ext->extra_hours }} Jam
                            </td>

                            <!-- Jam Tambahan -->
                            <td style="color: #F5F5F5;">
                                {{ $reservation->end_time }}–{{ $ext->new_end_time }}
                            </td>

                            <!-- Total Waktu Latihan Keseluruhan -->
                            <td>
                                {{ $reservation->start_time }}–{{ $ext->new_end_time }} ({{ $reservation->duration_hours + $ext->extra_hours }} jam)
                            </td>

                            <!-- Biaya Tambahan -->
                            <td style="color: #F5F5F5; font-weight: 600;">
                                Rp{{ number_format($ext->extra_cost, 0, ',', '.') }}
                            </td>

                            <!-- Alasan -->
                            <td style="max-width: 200px; white-space: normal; color: #A3A3A3;">
                                {{ $ext->reason ?: 'Tidak ada catatan' }}
                            </td>

                            <!-- Waktu Pengajuan -->
                            <td style="color: #737373;">
                                {{ $ext->created_at ? $ext->created_at->format('d M Y, H:i') : '-' }} WIB
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="badge {{ $extBadge }}">
                                    {{ ucfirst($ext->status_label) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-ext-box">
            <p class="empty-ext-text">
                Pesanan ini tidak memiliki pengajuan perpanjangan waktu.
            </p>
            @if (in_array($st, ['dikonfirmasi', 'menunggu_bayar']))
                <a href="{{ route('extensions.create', ['reservation_id' => $reservation->id]) }}" class="btn-amber">
                    + Ajukan perpanjangan
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
