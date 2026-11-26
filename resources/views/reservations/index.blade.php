@extends('layouts.pelanggan')

@section('title', 'Reservasi Saya — Studio Musik Positif')

@section('page_css')
<style>
    /* Header Baris Atas */
    .res-header-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .res-actions-top {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Tab Filter Navigasi */
    .res-tabs {
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid rgba(71, 89, 116, 0.16);
        padding-bottom: 14px;
        margin-bottom: 20px;
    }

    .res-tab-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 13px;
        color: #475974;
        font-weight: 500;
        transition: all 0.15s ease;
        background: transparent;
    }

    .res-tab-item:hover {
        color: #1C3562;
        background: rgba(28, 53, 98, 0.05);
    }

    .res-tab-item.active {
        color: #F9FAFC;
        background: #1C3562;
        font-weight: 600;
    }

    .res-tab-count {
        font-size: 11px;
        padding: 1px 6px;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.2);
    }

    .res-tab-item:not(.active) .res-tab-count {
        background: rgba(71, 89, 116, 0.15);
        color: #475974;
    }

    /* Baris Pencarian & Dropdown Filter */
    .filter-bar {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        flex-wrap: wrap;
    }

    .filter-input-wrap {
        position: relative;
        flex: 1;
        min-width: 200px;
    }

    .filter-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #475974;
        pointer-events: none;
    }

    .filter-input {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.28);
        color: #1C3562;
        padding: 8px 12px 8px 36px;
        border-radius: 7px;
        font-size: 13px;
        outline: none;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .filter-input:focus {
        border-color: #1C3562;
        box-shadow: 0 0 0 3px rgba(28, 53, 98, 0.12);
    }

    .filter-select {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.28);
        color: #1C3562;
        padding: 8px 14px;
        border-radius: 7px;
        font-size: 13px;
        outline: none;
        cursor: pointer;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .filter-select:focus {
        border-color: #1C3562;
        box-shadow: 0 0 0 3px rgba(28, 53, 98, 0.12);
    }

    /* Tabel Reservasi */
    .table-card {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
        border-radius: 10px;
        padding: 20px 24px;
        margin-bottom: 28px;
    }

    .table-container {
        overflow-x: auto;
    }

    .res-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .res-table th {
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

    .res-table td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(71, 89, 116, 0.12);
        color: #1E293B;
        vertical-align: middle;
        white-space: nowrap;
    }

    .res-table tbody tr:hover {
        background: rgba(28, 53, 98, 0.03);
    }

    .cell-booking-id {
        font-family: monospace;
        font-size: 13px;
        color: #1C3562;
        font-weight: 600;
    }

    .cell-title {
        color: #1C3562;
        font-weight: 500;
        font-size: 13.5px;
    }

    .cell-sub {
        font-size: 11.5px;
        color: #475974;
        margin-top: 3px;
    }

    .cell-price {
        color: #1C3562;
        font-weight: 600;
        font-size: 13.5px;
    }

    .btn-table-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.15s ease;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .btn-table-amber {
        background: rgba(160, 170, 84, 0.15);
        border-color: rgba(160, 170, 84, 0.45);
        color: #4B531B;
    }

    .btn-table-amber:hover {
        background: #1C3562;
        color: #F9FAFC;
    }

    .btn-table-dark {
        background: #FFFFFF;
        border-color: rgba(71, 89, 116, 0.3);
        color: #1C3562;
    }

    .btn-table-dark:hover {
        border-color: #1C3562;
        color: #1C3562;
        background: rgba(28, 53, 98, 0.05);
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
        color: #1C3562;
        background: rgba(28, 53, 98, 0.05);
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

    .extension-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 10.5px;
        color: #475974;
        margin-top: 4px;
    }

    /* Pagination */
    .res-pagination {
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        font-size: 12.5px;
        color: #475974;
    }

    .pagination-nav {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pag-btn {
        padding: 6px 12px;
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.28);
        border-radius: 6px;
        color: #1C3562;
        font-size: 12px;
        transition: all 0.15s ease;
    }

    .pag-btn:hover:not(.disabled) {
        border-color: #1C3562;
        color: #1C3562;
    }

    .pag-btn.active {
        background: #1C3562;
        color: #F9FAFC;
        border-color: #1C3562;
        font-weight: 600;
    }

    .pag-btn.disabled {
        opacity: 0.35;
        background: #F1F4F9;
        cursor: not-allowed;
    }

    /* Grid 2 Kartu Info Bawah */
    .res-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .info-card {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
        border-radius: 10px;
        padding: 22px 24px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .info-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1C3562;
    }

    .info-card-title {
        font-size: 16px;
        font-weight: 600;
        color: #1C3562;
    }

    .info-card-text {
        font-size: 12.5px;
        color: #475974;
        line-height: 1.55;
    }

    .info-card-btn {
        margin-top: 8px;
        align-self: flex-start;
    }

    @media (max-width: 900px) {
        .res-info-grid {
            grid-template-columns: 1fr;
        }

        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-form {
            flex-direction: column;
            align-items: stretch;
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
@endphp

<!-- ================= 1. HEADER HALAMAN ================= -->
<div class="res-header-row">
    <div>
        <div class="page-eyebrow">Pelanggan / desktop</div>
        <h1 class="page-h1 font-serif">Reservasi saya</h1>
        <p class="page-subtitle">
            Kelola jadwal latihan, pantau status pembayaran, dan ajukan perpanjangan jam studio musikmu.
        </p>
    </div>

    <div class="res-actions-top">
        <a href="{{ route('extensions.create') }}" class="btn-dark">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Ajukan perpanjangan
        </a>
        <a href="{{ route('reservations.create') }}" class="btn-amber">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Reservasi baru
        </a>
    </div>
</div>

<!-- ================= 2. TAB NAVIGASI STATUS ================= -->
<div class="res-tabs">
    <a href="{{ route('reservations.index', array_merge(request()->except('tab', 'page'), ['tab' => 'semua'])) }}"
       class="res-tab-item {{ $tab === 'semua' ? 'active' : '' }}">
        <span>Semua</span>
        <span class="res-tab-count">{{ $countAll }}</span>
    </a>
    <a href="{{ route('reservations.index', array_merge(request()->except('tab', 'page'), ['tab' => 'aktif'])) }}"
       class="res-tab-item {{ $tab === 'aktif' ? 'active' : '' }}">
        <span>Aktif</span>
        <span class="res-tab-count">{{ $countActive }}</span>
    </a>
    <a href="{{ route('reservations.index', array_merge(request()->except('tab', 'page'), ['tab' => 'selesai'])) }}"
       class="res-tab-item {{ $tab === 'selesai' ? 'active' : '' }}">
        <span>Selesai</span>
        <span class="res-tab-count">{{ $countCompleted }}</span>
    </a>
</div>

<!-- ================= 3. FILTER & PENCARIAN ================= -->
<div class="filter-bar">
    <form method="GET" action="{{ route('reservations.index') }}" class="filter-form">
        @if (request('tab'))
            <input type="hidden" name="tab" value="{{ request('tab') }}">
        @endif

        <!-- Input Pencarian -->
        <div class="filter-input-wrap">
            <svg class="filter-search-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari kode booking atau studio...">
        </div>

        <!-- Filter Status -->
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua status</option>
            <option value="dikonfirmasi" {{ request('status') === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="menunggu_bayar" {{ request('status') === 'menunggu_bayar' ? 'selected' : '' }}>Menunggu bayar</option>
            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>

        <!-- Filter Pembayaran -->
        <select name="payment_status" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua pembayaran</option>
            <option value="lunas" {{ request('payment_status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
            <option value="belum_bayar" {{ request('payment_status') === 'belum_bayar' ? 'selected' : '' }}>Belum bayar</option>
        </select>

        <button type="submit" class="btn-dark" style="padding: 8px 14px;">
            Filter
        </button>

        @if (request('q') || request('status') || request('payment_status'))
            <a href="{{ route('reservations.index', ['tab' => $tab]) }}" class="btn-dark" style="color: #475974;">
                Reset
            </a>
        @endif
    </form>
</div>

<!-- ================= 4. TABEL 6 KOLOM RESERVASI ================= -->
<div class="table-card">
    @if ($reservations->isEmpty())
        <div style="text-align: center; padding: 48px 16px;">
            <svg width="40" height="40" fill="none" stroke="#475974" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom: 12px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p style="color: #1C3562; font-size: 15px; font-weight: 600; margin-bottom: 6px;">
                Tidak ada data reservasi ditemukan.
            </p>
            <p style="color: #475974; font-size: 12.5px; margin-bottom: 20px;">
                @if (request('q') || request('status') || request('payment_status'))
                    Coba sesuaikan kata kunci atau atur ulang filter pencarianmu.
                @else
                    Kamu belum memiliki jadwal latihan yang sesuai kategori ini.
                @endif
            </p>
            <a href="{{ route('reservations.create') }}" class="btn-amber">
                + Buat Reservasi Sekarang
            </a>
        </div>
    @else
        <div class="table-container">
            <table class="res-table">
                <thead>
                    <tr>
                        <th>ID Reservasi</th>
                        <th>Studio &amp; Jadwal</th>
                        <th>Durasi &amp; Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Aksi</th>
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

                            $hasExtensions = $res->extensions->isNotEmpty();
                        @endphp
                        <tr>
                            <!-- 1. ID RESERVASI -->
                            <td>
                                <div class="cell-booking-id">
                                    {{ $res->booking_code }}
                                </div>
                                <div class="cell-sub">
                                    Dibuat {{ $formatIndoShort($res->created_at) }}
                                </div>
                            </td>

                            <!-- 2. STUDIO & JADWAL -->
                            <td>
                                <div class="cell-title">
                                    {{ $res->studio?->name ?? 'Studio Musik' }}
                                </div>
                                <div class="cell-sub">
                                    {{ $formatIndoFull($res->reservation_date) }} &middot; {{ $res->start_time }}–{{ $res->end_time }}
                                </div>
                            </td>

                            <!-- 3. DURASI & TOTAL -->
                            <td>
                                <div class="cell-price">
                                    Rp{{ number_format($res->total_price, 0, ',', '.') }}
                                </div>
                                <div class="cell-sub">
                                    {{ $res->duration_hours }} Jam &middot; Rp{{ number_format($res->studio?->price_per_hour ?? 70000, 0, ',', '.') }}/jam
                                </div>
                            </td>

                            <!-- 4. STATUS -->
                            <td>
                                <span class="badge {{ $badgeRes }}">
                                    {{ ucfirst($res->status_label) }}
                                </span>
                                @if ($hasExtensions)
                                    @php
                                        $latestExt = $res->extensions->sortByDesc('id')->first();
                                        $extStatusLabel = ucfirst($latestExt->status_label ?? $latestExt->status);
                                    @endphp
                                    <div class="extension-pill" style="display: flex; align-items: center; gap: 4px; font-size: 11px; color: #475974; margin-top: 4px;">
                                        <span>+ Perpanjangan {{ $latestExt->extra_hours }} jam &middot; {{ $extStatusLabel }}</span>
                                    </div>
                                @endif
                            </td>

                            <!-- 5. PEMBAYARAN -->
                            <td>
                                <span class="badge {{ $badgePay }}">
                                    {{ ucfirst($res->payment_label) }}
                                </span>
                            </td>

                            <!-- 6. AKSI -->
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

        <!-- Pagination -->
        @if ($reservations->hasPages())
            <div class="res-pagination">
                <div>
                    Menampilkan {{ $reservations->firstItem() }}–{{ $reservations->lastItem() }} dari total {{ $reservations->total() }} reservasi
                </div>

                <div class="pagination-nav">
                    @if ($reservations->onFirstPage())
                        <span class="pag-btn disabled">&laquo; Sebelumnya</span>
                    @else
                        <a href="{{ $reservations->previousPageUrl() }}" class="pag-btn">&laquo; Sebelumnya</a>
                    @endif

                    @foreach ($reservations->getUrlRange(1, $reservations->lastPage()) as $page => $url)
                        @if ($page == $reservations->currentPage())
                            <span class="pag-btn active">{{ $page }}</span>
                        @elseif ($page == 1 || $page == $reservations->lastPage() || abs($page - $reservations->currentPage()) <= 1)
                            <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($reservations->hasMorePages())
                        <a href="{{ $reservations->nextPageUrl() }}" class="pag-btn">Selanjutnya &raquo;</a>
                    @else
                        <span class="pag-btn disabled">Selanjutnya &raquo;</span>
                    @endif
                </div>
            </div>
        @endif
    @endif
</div>

<!-- ================= 5. DUA KARTU INFORMASI PANDUAN DI BAWAH ================= -->
<div class="res-info-grid" id="bayar-info">
    <!-- Kartu 1: Status Pembayaran & Check-In -->
    <div class="info-card">
        <div class="info-card-header">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="info-card-title">Status Pembayaran &amp; Check-In</h3>
        </div>

        @if ($unpaidReservation)
            <p class="info-card-text">
                Kamu memiliki tagihan sebesar <strong style="color: #1C3562;">Rp{{ number_format($unpaidReservation->total_price, 0, ',', '.') }}</strong>
                untuk booking <strong style="color: #1C3562;">{{ $unpaidReservation->booking_code }}</strong>
                ({{ $unpaidReservation->studio?->name ?? 'Studio Musik' }}, {{ $formatIndoShort($unpaidReservation->reservation_date) }}).
                Silakan selesaikan pembayaran langsung di kasir studio saat tiba atau hubungi kontak admin.
            </p>
        @else
            <p class="info-card-text">
                Semua reservasi aktifmu sudah lunas atau tercatat aman. Mohon hadir di Studio Musik Positif minimal <strong>15 menit</strong> sebelum jadwal latihan dimulai untuk persiapan instrumen dan cek kabel/audio.
            </p>
        @endif

        <p class="info-card-text" style="font-size: 11.5px; color: #475974;">
            Batas toleransi keterlambatan adalah 15 menit. Waktu latihan tetap berakhir sesuai jadwal yang tertera pada bukti reservasi.
        </p>

        <a href="{{ route('reservations.create') }}" class="btn-dark info-card-btn">
            Reservasi jadwal baru
        </a>
    </div>

    <!-- Kartu 2: Ketentuan Perpanjangan Jam Latihan -->
    <div class="info-card">
        <div class="info-card-header">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="info-card-title">Ketentuan Perpanjangan Jam Latihan</h3>
        </div>

        <p class="info-card-text">
            Ingin menambah waktu latihan? Kamu dapat mengajukan perpanjangan durasi (+1 hingga +3 jam) secara mandiri lewat sistem ini, dengan syarat:
        </p>

        <ul style="font-size: 12px; color: #475974; padding-left: 18px; line-height: 1.6;">
            <li>Status reservasi telah <strong>dikonfirmasi</strong> oleh pihak studio.</li>
            <li>Slot jam berikutnya pada studio yang sama masih <strong>kosong (belum dipesan)</strong>.</li>
            <li>Tidak melampaui jam operasional studio (maksimal hingga pukul 24.00).</li>
        </ul>

        <a href="{{ route('extensions.create') }}" class="btn-amber info-card-btn">
            Ajukan perpanjangan sekarang
        </a>
    </div>
</div>
@endsection
