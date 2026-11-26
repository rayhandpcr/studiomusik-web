@extends('layouts.pelanggan')

@section('title', 'Notifikasi — Studio Musik Positif')

@section('page_css')
<style>
    /* Header Halaman */
    .notif-header {
        margin-bottom: 20px;
    }

    .notif-eyebrow {
        font-size: 11px;
        color: #475974;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }

    .notif-h1 {
        font-size: 32px;
        font-weight: 400;
        color: #1C3562;
        line-height: 1.2;
        margin-bottom: 6px;
    }

    .notif-sub {
        font-size: 13px;
        color: #475974;
    }

    /* Baris Filter & Tombol Tandai Semua Dibaca */
    .filter-actions-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px 0 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .filter-pills-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pill-filter {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.15s ease;
        border: 1px solid transparent;
    }

    .pill-all {
        background: #FFFFFF;
        color: #475974;
        border-color: rgba(71, 89, 116, 0.25);
    }

    .pill-all:hover {
        color: #1C3562;
        background: rgba(28, 53, 98, 0.04);
        border-color: #1C3562;
    }

    .pill-all.active {
        background: #1C3562;
        color: #F9FAFC;
        border-color: #1C3562;
    }

    .pill-unread {
        background: rgba(160, 170, 84, 0.12);
        color: #4B531B;
        border-color: rgba(160, 170, 84, 0.35);
    }

    .pill-unread:hover {
        background: rgba(160, 170, 84, 0.2);
    }

    .pill-unread.active {
        background: #A0AA54;
        border-color: #A0AA54;
        color: #FFFFFF;
        font-weight: 600;
    }

    .btn-mark-all {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.35);
        color: #1C3562;
        padding: 7px 15px;
        border-radius: 7px;
        font-size: 12.5px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-mark-all:hover {
        border-color: #1C3562;
        background: rgba(28, 53, 98, 0.04);
        color: #1C3562;
    }

    /* Kartu Daftar Notifikasi */
    .notif-card-container {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
        border-radius: 10px;
        padding: 0 24px;
    }

    .notif-entry {
        padding: 20px 0;
        border-bottom: 1px solid rgba(71, 89, 116, 0.14);
    }

    .notif-entry:last-child {
        border-bottom: none;
    }

    /* Baris Atas */
    .notif-entry-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .notif-entry-title {
        font-size: 18px;
        font-weight: 400;
        color: #1C3562;
        line-height: 1.3;
    }

    /* Badge Status */
    .badge-unread {
        background: rgba(160, 170, 84, 0.15);
        border: 1px solid rgba(160, 170, 84, 0.45);
        color: #4B531B;
        font-size: 11px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 999px;
        white-space: nowrap;
    }

    .badge-read {
        background: rgba(71, 89, 116, 0.08);
        border: 1px solid rgba(71, 89, 116, 0.2);
        color: #475974;
        font-size: 11px;
        font-weight: 400;
        padding: 3px 10px;
        border-radius: 999px;
        white-space: nowrap;
    }

    /* Baris Tengah: Pesan */
    .notif-entry-body {
        font-size: 13px;
        color: #475974;
        line-height: 1.6;
        margin: 8px 0 14px;
    }

    /* Baris Bawah */
    .notif-entry-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .notif-time-text {
        font-size: 11.5px;
        color: #475974;
    }

    /* Tombol Aksi */
    .btn-notif-action-amber {
        background: #1C3562;
        border: 1px solid #1C3562;
        color: #F9FAFC;
        font-weight: 600;
        font-size: 12px;
        padding: 6px 14px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.15s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-notif-action-amber:hover {
        background: #15284B;
    }

    .btn-notif-action-dark {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.35);
        color: #1C3562;
        font-size: 12px;
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-notif-action-dark:hover {
        border-color: #1C3562;
        background: rgba(28, 53, 98, 0.04);
        color: #1C3562;
    }

    /* Catatan Kaki */
    .notif-footnote {
        font-size: 11.5px;
        color: #475974;
        margin-top: 14px;
    }
</style>
@endsection

@section('content')
<!-- Header Halaman -->
<div class="notif-header">
    <div class="notif-eyebrow">Pelanggan / desktop</div>
    <h1 class="notif-h1 font-serif">Notifikasi</h1>
    <p class="notif-sub">Informasi reservasi, pengingat pembayaran, dan aktivitas band.</p>
</div>

<!-- Baris Filter & Tombol Tandai Dibaca -->
<div class="filter-actions-bar">
    <div class="filter-pills-wrap">
        <a href="{{ route('notifications.index') }}" class="pill-filter pill-all {{ $filter !== 'unread' ? 'active' : '' }}">
            Semua ({{ $allCount }})
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" class="pill-filter pill-unread {{ $filter === 'unread' ? 'active' : '' }}">
            Belum dibaca ({{ $unreadCount }})
        </a>
    </div>

    @if ($unreadCount > 0)
        <form method="POST" action="{{ route('notifications.mark-all-read') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-mark-all">
                Tandai semua dibaca
            </button>
        </form>
    @endif
</div>

<!-- Kartu Daftar Notifikasi -->
<div class="notif-card-container">
    @if ($notifications->isEmpty())
        <div style="text-align: center; padding: 48px 16px;">
            <svg width="40" height="40" fill="none" stroke="#475974" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom: 12px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <p style="color: #1C3562; font-size: 14.5px; font-weight: 500; margin-bottom: 4px;">
                @if ($filter === 'unread')
                    Tidak ada notifikasi yang belum dibaca.
                @else
                    Belum ada notifikasi yang tercatat.
                @endif
            </p>
            <p style="color: #475974; font-size: 12px;">
                Pemberitahuan terkait status pesanan, jadwal studio, dan patungan band akan muncul di sini.
            </p>
        </div>
    @else
        @foreach ($notifications as $notif)
            <div class="notif-entry">
                <!-- Baris Atas: Judul & Badge Status -->
                <div class="notif-entry-top">
                    <div class="notif-entry-title font-serif">
                        {{ $notif->title }}
                    </div>
                    <div>
                        @if (!$notif->is_read)
                            <span class="badge-unread">Belum dibaca</span>
                        @else
                            <span class="badge-read">Sudah dibaca</span>
                        @endif
                    </div>
                </div>

                <!-- Baris Tengah: Pesan Notifikasi -->
                <div class="notif-entry-body">
                    {{ $notif->message }}
                </div>

                <!-- Baris Bawah: Waktu & Tombol Aksi Kontekstual -->
                <div class="notif-entry-bottom">
                    <div class="notif-time-text">
                        {{ $notif->created_at ? $notif->created_at->translatedFormat('d M Y · H.i') : 'Baru saja' }}
                    </div>

                    <div>
                        <form method="POST" action="{{ route('notifications.read', $notif->id) }}" style="margin: 0;">
                            @csrf
                            @if (!$notif->is_read)
                                @if ($notif->type === 'payment_reminder')
                                    <button type="submit" class="btn-notif-action-amber">
                                        Bayar sekarang
                                    </button>
                                @elseif ($notif->type === 'cost_split_incomplete')
                                    <button type="submit" class="btn-notif-action-amber">
                                        Lihat pembagian
                                    </button>
                                @else
                                    <button type="submit" class="btn-notif-action-amber">
                                        Lihat reservasi
                                    </button>
                                @endif
                            @else
                                <button type="submit" class="btn-notif-action-dark">
                                    Lihat riwayat
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<!-- Catatan Kaki -->
<div class="notif-footnote">
    Semua notifikasi ditampilkan &middot; Waktu Indonesia Barat (WIB).
</div>
@endsection
