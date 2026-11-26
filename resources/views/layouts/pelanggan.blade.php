<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Area Pelanggan — Studio Musik Positif')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #F9FAFC;
            color: #1E293B;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 13.5px;
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        input,
        button,
        select,
        textarea {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .font-serif {
            font-family: 'Times New Roman', Times, Georgia, serif;
        }

        /* ================= SIDEBAR KIRI (220px) ================= */
        .sidebar {
            width: 220px;
            min-width: 220px;
            background: #FFFFFF;
            border-right: 1px solid rgba(71, 89, 116, 0.16);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 24px 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 40;
        }

        .sidebar-brand {
            padding: 0 20px 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            text-decoration: none;
            transition: opacity 0.2s ease;
        }

        .brand-icon {
            width: 20px;
            height: 20px;
            color: #1C3562;
            transition: color 0.2s ease;
        }

        .sidebar-brand:hover .brand-icon {
            color: #A0AA54;
        }

        .brand-title {
            font-size: 18px;
            line-height: 1.2;
            color: #1C3562;
            font-weight: 400;
        }

        .brand-sub {
            font-size: 11px;
            color: #475974;
            margin-top: 4px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px;
            color: #475974;
            font-size: 13px;
            font-weight: 400;
            transition: all 0.15s ease;
            border-left: 3px solid transparent;
            background: transparent;
            width: 100%;
            text-align: left;
            border-top: none;
            border-right: none;
            border-bottom: none;
            cursor: pointer;
        }

        .sidebar-link:hover {
            color: #1C3562;
            background: rgba(28, 53, 98, 0.05);
        }

        .sidebar-link.active {
            background: rgba(28, 53, 98, 0.08);
            border-left-color: #1C3562;
            color: #1C3562;
            font-weight: 600;
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(71, 89, 116, 0.16);
            margin: 18px 20px;
        }

        .sidebar-bottom {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .btn-sidebar-logout {
            color: #475974;
            cursor: pointer;
        }

        .btn-sidebar-logout:hover {
            color: #B91C1C;
            background: rgba(185, 28, 28, 0.06);
        }

        /* ================= AREA UTAMA KANAN ================= */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
            background: #F9FAFC;
        }

        /* ================= TOPBAR (64px) ================= */
        .topbar {
            height: 64px;
            min-height: 64px;
            border-bottom: 1px solid rgba(71, 89, 116, 0.16);
            padding: 0 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #FFFFFF;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .topbar-left {
            font-size: 12px;
            color: #475974;
            letter-spacing: 0.01em;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
            color: #1C3562;
        }

        .topbar-action-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
            text-decoration: none;
            line-height: 1;
        }

        .topbar-action-icon svg {
            fill: #1C3562;
            transition: fill 0.2s ease, color 0.2s ease;
        }

        .topbar-action-icon:hover svg {
            fill: #A0AA54 !important;
            color: #A0AA54 !important;
        }

        /* ================= KONTEN HALAMAN ================= */
        .page-content {
            flex: 1;
            padding: 32px 36px 64px;
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
        }

        /* Alert Notifikasi */
        .flash-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .flash-success {
            background: rgba(160, 170, 84, 0.15);
            border: 1px solid rgba(160, 170, 84, 0.40);
            color: #4B531B;
        }

        .flash-error {
            background: rgba(185, 28, 28, 0.10);
            border: 1px solid rgba(185, 28, 28, 0.28);
            color: #B91C1C;
        }

        /* Header Halaman Pelanggan */
        .page-header {
            margin-bottom: 28px;
        }

        .page-eyebrow {
            font-size: 11px;
            color: #475974;
            margin-bottom: 4px;
        }

        .page-h1 {
            font-size: 32px;
            font-weight: 400;
            line-height: 1.2;
            color: #1C3562;
            margin-bottom: 6px;
        }

        .page-subtitle {
            font-size: 13px;
            color: #475974;
            line-height: 1.5;
        }

        /* Common Cards */
        .card {
            background: #FFFFFF;
            border: 1px solid rgba(71, 89, 116, 0.18);
            box-shadow: 0 1px 3px rgba(28, 53, 98, 0.06);
            border-radius: 10px;
            padding: 24px;
        }

        .card-h2 {
            font-size: 19px;
            font-weight: 400;
            line-height: 1.3;
            color: #1C3562;
            margin-bottom: 4px;
        }

        .card-sub {
            font-size: 12px;
            color: #475974;
            margin-bottom: 18px;
        }

        /* Pill Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 500;
            padding: 3px 10px;
            white-space: nowrap;
            line-height: 1.3;
        }

        .badge-green {
            color: #4B531B;
            background: rgba(160, 170, 84, 0.20);
            border: 1px solid rgba(160, 170, 84, 0.50);
        }

        .badge-amber {
            color: #1C3562;
            background: rgba(71, 89, 116, 0.12);
            border: 1px solid rgba(71, 89, 116, 0.32);
        }

        .badge-gray {
            color: #475974;
            background: #EEF2F6;
            border: 1px solid rgba(71, 89, 116, 0.20);
        }

        .badge-red {
            color: #B91C1C;
            background: rgba(185, 28, 28, 0.10);
            border: 1px solid rgba(185, 28, 28, 0.28);
        }

        /* Buttons */
        .btn-amber {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #1C3562;
            color: #F9FAFC;
            padding: 9px 18px;
            border-radius: 7px;
            font-size: 13.5px;
            font-weight: 600;
            border: 1px solid #1C3562;
            cursor: pointer;
            transition: all 0.15s ease;
            text-align: center;
        }

        .btn-amber:hover {
            background: #15284B;
            border-color: #A0AA54;
        }

        .btn-dark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #FFFFFF;
            color: #1C3562;
            padding: 8px 16px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid rgba(71, 89, 116, 0.32);
            cursor: pointer;
            transition: all 0.15s ease;
            text-align: center;
        }

        .btn-dark:hover {
            border-color: #1C3562;
            color: #1C3562;
            background: rgba(28, 53, 98, 0.05);
        }

        /* Responsive Media Query */
        @media (max-width: 900px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-width: 100%;
                height: auto;
                position: relative;
                border-right: none;
                border-bottom: 1px solid rgba(71, 89, 116, 0.16);
                padding: 16px 0;
            }

            .sidebar-menu {
                flex-direction: row;
                flex-wrap: wrap;
                padding: 0 16px;
            }

            .sidebar-link {
                padding: 6px 12px;
                border-left: none;
                border-bottom: 2px solid transparent;
                width: auto;
            }

            .sidebar-link.active {
                border-left-color: transparent;
                border-bottom-color: #1C3562;
            }

            .sidebar-divider,
            .sidebar-bottom {
                display: none;
            }

            .topbar {
                padding: 0 20px;
            }

            .page-content {
                padding: 24px 20px 48px;
            }
        }
    </style>
    @yield('page_css')
</head>

<body>
    <!-- ================= SIDEBAR KIRI (220px) ================= -->
    <aside class="sidebar">
        <!-- Header Brand -->
        <a href="{{ route('landing') }}" class="sidebar-brand">
            <svg class="brand-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13" />
                <circle cx="6" cy="18" r="3" />
                <circle cx="18" cy="16" r="3" />
            </svg>
            <div class="brand-title font-serif">
                Studio Musik<br>Positif
            </div>
            <div class="brand-sub">Area pelanggan</div>
        </a>

        <!-- Menu Navigasi Utama -->
        <nav class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('reservations.create') }}" class="sidebar-link {{ request()->routeIs('reservations.create') ? 'active' : '' }}">
                Reservasi baru
            </a>
            <a href="{{ route('reservations.index') }}" class="sidebar-link {{ request()->routeIs('reservations.index') ? 'active' : '' }}">
                Reservasi saya
            </a>
            <a href="{{ route('extensions.create') }}" class="sidebar-link {{ request()->routeIs('extensions.*') ? 'active' : '' }}">
                Ajukan perpanjangan
            </a>
            <a href="{{ route('cost-splits.index') }}" class="sidebar-link {{ request()->routeIs('cost-splits.*') ? 'active' : '' }}">
                Pembagian biaya
            </a>
            <a href="{{ route('notifications.index') }}" class="sidebar-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                Notifikasi
            </a>
            <a href="{{ route('reservations.index', ['tab' => 'selesai']) }}" class="sidebar-link {{ request('tab') === 'selesai' ? 'active' : '' }}">
                Riwayat
            </a>
        </nav>

        <div class="sidebar-divider"></div>

        <!-- Menu Utilitas Bawah -->
        <div class="sidebar-bottom">
            <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                Pengaturan akun
            </a>
            <a href="{{ route('landing') }}" class="sidebar-link">
                Kembali ke beranda
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="sidebar-link btn-sidebar-logout">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- ================= AREA UTAMA KANAN ================= -->
    <div class="main-wrapper">
        <!-- Top Header Bar (64px) -->
        <header class="topbar">
            <div class="topbar-left">
                Studio Musik Positif / pelanggan
            </div>

            <div class="topbar-right">
                <!-- Lonceng Notifikasi SVG -->
                @php
                    $unreadNotifCount = auth()->check()
                        ? \App\Models\CustomerNotification::where('user_id', auth()->id())->where('is_read', false)->count()
                        : 0;
                @endphp
                <a href="{{ route('notifications.index') }}" class="topbar-action-icon" title="Notifikasi" style="position: relative;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a6 6 0 0 0-6 6v3.586l-.707.707A1 1 0 0 0 5 13v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1a1 1 0 0 0-.293-.707L18 11.586V8a6 6 0 0 0-6-6zm0 19a3 3 0 0 0 2.83-2H9.17A3 3 0 0 0 12 21z" />
                    </svg>
                    @if ($unreadNotifCount > 0)
                        <span style="position: absolute; top: -1px; right: -1px; width: 8px; height: 8px; background: #A0AA54; border-radius: 50%; border: 1.5px solid #FFFFFF;"></span>
                    @endif
                </a>

                <!-- Profil Bulat SVG -->
                <a href="{{ route('profile.edit') }}" class="topbar-action-icon" title="Pengaturan akun ({{ auth()->user()->name ?? 'Pelanggan' }})">
                    <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 4a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm-6 11.606c1.47-2.19 3.593-3.606 6-3.606s4.53 1.416 6 3.606A7.962 7.962 0 0 1 12 20a7.962 7.962 0 0 1-6-2.394z" />
                    </svg>
                </a>
            </div>
        </header>

        <!-- Konten Halaman -->
        <main class="page-content">
            @if (session('success'))
                <div class="flash-alert flash-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="flash-alert flash-error">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('page_js')
</body>

</html>
