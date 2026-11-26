<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Musik Positif — Ruang untuk bermusik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 88px;
        }

        section[id] {
            scroll-margin-top: 88px;
        }

        body {
            background: #F9FAFC;
            color: #1E293B;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 14px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        ::selection {
            background: #A0AA54;
            color: #1C3562;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        input,
        textarea,
        button,
        select {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .font-serif {
            font-family: 'Times New Roman', Times, Georgia, serif;
        }

        .container {
            max-width: 1152px;
            margin: 0 auto;
            padding: 0 24px;
            width: 100%;
        }

        /* Navbar & Active Indicator */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(249, 250, 252, 0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(71, 89, 116, 0.16);
            height: 74px;
            display: flex;
            align-items: center;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #1C3562;
        }

        .brand:hover .brand-row svg {
            color: #A0AA54;
        }

        .brand-name {
            font-size: 17px;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.01em;
            color: #1C3562;
        }

        .brand-tag {
            font-size: 11px;
            color: #475974;
            line-height: 1.35;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
            font-size: 13px;
            color: #475974;
        }

        .nav-links a {
            transition: color 0.2s ease;
            font-weight: 400;
        }

        .nav-links a:hover {
            color: #1C3562;
        }

        .nav-links a.active {
            color: #1C3562;
            font-weight: 600;
        }

        .btn-nav {
            border: 1px solid rgba(71, 89, 116, 0.28);
            background: #FFFFFF;
            color: #1C3562 !important;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500 !important;
            transition: all 0.2s ease;
        }

        .btn-nav:hover {
            border-color: #1C3562;
            background: rgba(28, 53, 98, 0.05);
            color: #1C3562 !important;
        }

        /* Hero */
        .hero {
            padding: 64px 0 72px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 52px;
            align-items: center;
        }

        .eyebrow {
            font-size: 11px;
            color: #475974;
            margin-bottom: 12px;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 400;
            line-height: 1.18;
            letter-spacing: -0.015em;
            margin-bottom: 16px;
            color: #1C3562;
        }

        .hero-desc {
            font-size: 14px;
            color: #475974;
            line-height: 1.6;
            max-width: 460px;
            margin-bottom: 24px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .btn-primary {
            display: inline-block;
            padding: 10.5px 20px;
            border-radius: 7px;
            background: #1C3562;
            color: #F9FAFC;
            font-size: 13.5px;
            font-weight: 600;
            border: 1px solid #1C3562;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: #15284B;
            border-color: #A0AA54;
        }

        .btn-secondary {
            display: inline-block;
            padding: 10.5px 20px;
            border-radius: 7px;
            background: #FFFFFF;
            border: 1px solid rgba(71, 89, 116, 0.32);
            color: #1C3562;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            border-color: #1C3562;
            background: rgba(28, 53, 98, 0.05);
        }

        .hero-meta {
            font-size: 12px;
            color: #475974;
        }

        .media-box {
            width: 100%;
            aspect-ratio: 16/10;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(71, 89, 116, 0.18);
            background: #FFFFFF;
            box-shadow: 0 2px 8px rgba(28, 53, 98, 0.06);
        }

        .media-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        /* Sections & Cards */
        .section {
            padding: 48px 0;
        }

        .sec-head {
            margin-bottom: 26px;
        }

        .sec-title {
            font-size: 28px;
            font-weight: 400;
            line-height: 1.22;
            letter-spacing: -0.01em;
            margin-bottom: 6px;
            color: #1C3562;
        }

        .sec-sub {
            font-size: 13.5px;
            color: #475974;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .feat-card:hover .media-box img {
            transform: scale(1.03);
        }

        .feat-media {
            margin-bottom: 14px;
        }

        .feat-title {
            font-size: 20px;
            font-weight: 400;
            line-height: 1.3;
            margin-bottom: 6px;
            color: #1C3562;
        }

        .feat-desc {
            font-size: 13.5px;
            color: #475974;
            line-height: 1.55;
        }

        .fac-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 16px;
            border-radius: 8px;
            background: #FFFFFF;
            border: 1px solid rgba(71, 89, 116, 0.18);
            box-shadow: 0 1px 3px rgba(28, 53, 98, 0.04);
            transition: border-color 0.2s ease;
        }

        .fac-item:hover {
            border-color: #1C3562;
        }

        .fac-icon {
            width: 26px;
            height: 26px;
            border-radius: 5px;
            border: 1px solid rgba(160, 170, 84, 0.5);
            background: rgba(160, 170, 84, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #A0AA54;
            flex-shrink: 0;
        }

        .fac-text {
            font-size: 13.5px;
            font-weight: 500;
            color: #1C3562;
        }

        .studio-sec {
            padding: 52px 0 76px;
        }

        .studio-card {
            border-radius: 12px;
            background: #FFFFFF;
            border: 1px solid rgba(71, 89, 116, 0.18);
            box-shadow: 0 2px 6px rgba(28, 53, 98, 0.05);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .studio-card:hover {
            border-color: #1C3562;
            box-shadow: 0 4px 12px rgba(28, 53, 98, 0.08);
        }

        .studio-img {
            aspect-ratio: 16/10;
            background: #F1F4F9;
            overflow: hidden;
            border-bottom: 1px solid rgba(71, 89, 116, 0.16);
        }

        .studio-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .studio-body {
            padding: 20px 22px 12px;
        }

        .studio-name {
            font-size: 21px;
            font-weight: 400;
            line-height: 1.25;
            margin-bottom: 4px;
            color: #1C3562;
        }

        .studio-cap {
            font-size: 12px;
            color: #475974;
            margin-bottom: 12px;
        }

        .studio-desc {
            font-size: 13px;
            color: #475974;
            line-height: 1.55;
        }

        .studio-foot {
            padding: 12px 22px 22px;
        }

        .studio-price {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 14px;
            color: #1C3562;
        }

        .studio-price span {
            font-size: 12.5px;
            font-weight: 400;
            color: #475974;
        }

        .btn-studio {
            display: block;
            width: 100%;
            text-align: center;
            padding: 10px 16px;
            border-radius: 7px;
            border: 1px solid rgba(71, 89, 116, 0.32);
            background: #FFFFFF;
            color: #1C3562;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-studio:hover {
            background: #1C3562;
            border-color: #1C3562;
            color: #F9FAFC;
            font-weight: 600;
        }

        /* Kontak & Lokasi */
        .contact-sec {
            padding: 64px 0;
            background: #F1F4F9;
            border-top: 1px solid rgba(71, 89, 116, 0.16);
            border-bottom: 1px solid rgba(71, 89, 116, 0.16);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 52px;
            align-items: start;
        }

        .map-box {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(71, 89, 116, 0.18);
            background: #FFFFFF;
            height: 220px;
            margin: 18px 0 16px;
        }

        .map-box iframe {
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
        }

        .loc-info {
            font-size: 13.5px;
            color: #475974;
            line-height: 1.65;
        }

        .loc-addr {
            color: #1C3562;
            font-weight: 500;
        }

        .loc-contact {
            margin-top: 10px;
        }

        .alert-ok {
            margin: 16px 0;
            padding: 11px 14px;
            border-radius: 7px;
            background: rgba(160, 170, 84, 0.15);
            border: 1px solid rgba(160, 170, 84, 0.45);
            color: #4B531B;
            font-size: 13px;
        }

        .c-form {
            margin-top: 20px;
        }

        .group {
            margin-bottom: 14px;
        }

        .label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            color: #1C3562;
            margin-bottom: 5px;
        }

        .input,
        .textarea {
            width: 100%;
            background: #FFFFFF;
            border: 1px solid rgba(71, 89, 116, 0.28);
            border-radius: 7px;
            padding: 9.5px 13px;
            font-size: 13.5px;
            color: #1C3562;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .input::placeholder,
        .textarea::placeholder {
            color: rgba(71, 89, 116, 0.6);
        }

        .input:focus,
        .textarea:focus {
            border-color: #1C3562;
            box-shadow: 0 0 0 3px rgba(28, 53, 98, 0.12);
        }

        .input.err,
        .textarea.err {
            border-color: #EF4444;
        }

        .textarea {
            resize: vertical;
            min-height: 104px;
        }

        .err-msg {
            display: block;
            font-size: 12px;
            color: #EF4444;
            margin-top: 4px;
        }

        /* Footer */
        .footer {
            padding: 36px 0;
            background: #FFFFFF;
        }

        .footer-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(71, 89, 116, 0.16);
        }

        .footer-brand {
            font-size: 17px;
            font-weight: 700;
            line-height: 1.2;
            color: #1C3562;
        }

        .footer-tag {
            font-size: 12px;
            color: #475974;
            margin-top: 5px;
        }

        .footer-nav {
            text-align: right;
        }

        .f-main {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            font-size: 13px;
            color: #475974;
            margin-bottom: 6px;
        }

        .f-main a:hover {
            color: #1C3562;
        }

        .f-sub {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            font-size: 12px;
            color: #475974;
        }

        .f-sub a:hover {
            color: #1C3562;
        }

        .footer-copy {
            padding-top: 20px;
            font-size: 12px;
            color: #475974;
        }

        @media (max-width: 960px) {

            .hero-grid,
            .contact-grid,
            .grid-3 {
                grid-template-columns: 1fr;
            }

            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }

            .nav-links {
                display: none;
            }

            .footer-top {
                flex-direction: column;
            }

            .footer-nav {
                text-align: left;
            }

            .f-main,
            .f-sub {
                justify-content: flex-start;
            }
        }
    </style>
</head>

<body>
    <header class="navbar">
        <div class="container navbar-inner">
            <a href="{{ route('landing') }}" class="brand">
                <div class="brand-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13" />
                        <circle cx="6" cy="18" r="3" />
                        <circle cx="18" cy="16" r="3" />
                    </svg>
                    <span class="brand-name font-serif">Studio Musik Positif</span>
                </div>
                <span class="brand-tag">Ruang untuk bermusik.</span>
            </a>
            <nav class="nav-links" id="mainNav">
                <a href="#beranda" data-section="beranda" class="nav-sec-link active">Beranda</a>
                <a href="#studio-tarif" data-section="studio-tarif" class="nav-sec-link">Studio &amp; tarif</a>
                <a href="#fasilitas" data-section="fasilitas" class="nav-sec-link">Fasilitas</a>
                <a href="#kontak" data-section="kontak" class="nav-sec-link">Kontak</a>
                @auth
                    <span style="color: #475974; font-size: 13px;">Halo, {{ explode(' ', auth()->user()->name)[0] }}</span>
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="btn-nav">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-nav">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    <section id="beranda" class="hero">
        <div class="container hero-grid">
            <div>
                <p class="eyebrow">Publik / desktop / beranda</p>
                <h1 class="hero-title font-serif">Tempat ide musik<br>menjadi nyata.</h1>
                <p class="hero-desc">Latihan nyaman, alat lengkap, jadwal fleksibel. Pilih studio dan reservasi waktu
                    bermainmu di Studio Musik Positif.</p>
                <div class="hero-actions">
                    <a href="{{ route('reservations.create') }}" class="btn-primary">Reservasi sekarang</a>
                    <a href="#studio-tarif" class="btn-secondary">Lihat studio</a>
                </div>
                <p class="hero-meta">Mulai Rp70.000 / jam &middot; Buka setiap hari 09.00-23.59</p>
            </div>
            <div>
                <div class="media-box">
                    <img src="{{ asset('images/hero-studio.jpg') }}"
                        onerror="this.src='https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&w=1000&q=80'"
                        alt="Ruang Latihan Utama Studio Musik Positif">
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="sec-head">
                <h2 class="sec-title font-serif">Semua yang kamu butuhkan untuk latihan</h2>
            </div>
            <div class="grid-3">
                <div class="feat-card">
                    <div class="media-box feat-media">
                        <img src="{{ asset('images/feature-ruang.jpg') }}"
                            onerror="this.src='https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&w=800&q=80'"
                            alt="Ruang Latihan Kedap Suara">
                    </div>
                    <h3 class="feat-title font-serif">Ruang</h3>
                    <p class="feat-desc">Ruang latihan kedap suara untuk fokus pada musik.</p>
                </div>
                <div class="feat-card">
                    <div class="media-box feat-media">
                        <img src="{{ asset('images/feature-peralatan.jpg') }}"
                            onerror="this.src='https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=800&q=80'"
                            alt="Peralatan Standar Band">
                    </div>
                    <h3 class="feat-title font-serif">Peralatan</h3>
                    <p class="feat-desc">Peralatan standar band siap dipakai di setiap sesi.</p>
                </div>
                <div class="feat-card">
                    <div class="media-box feat-media">
                        <img src="{{ asset('images/feature-fasilitas.jpg') }}"
                            onerror="this.src='https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=800&q=80'"
                            alt="Ruang Tunggu dan Wi-Fi">
                    </div>
                    <h3 class="feat-title font-serif">Fasilitas</h3>
                    <p class="feat-desc">Ruang tunggu dan Wi-Fi untuk kenyamananmu.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="fasilitas" class="section">
        <div class="container">
            <div class="sec-head">
                <h2 class="sec-title font-serif">Fasilitas di setiap sesi</h2>
            </div>
            <div class="grid-4">
                @foreach ($facilities as $facility)
                    <div class="fac-item">
                        <span class="fac-icon">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <circle cx="4" cy="4" r="1.2" />
                                <circle cx="8" cy="4" r="1.2" />
                                <circle cx="12" cy="4" r="1.2" />
                                <circle cx="4" cy="8" r="1.2" />
                                <circle cx="8" cy="8" r="1.2" />
                                <circle cx="12" cy="8" r="1.2" />
                                <circle cx="4" cy="12" r="1.2" />
                                <circle cx="8" cy="12" r="1.2" />
                                <circle cx="12" cy="12" r="1.2" />
                            </svg>
                        </span>
                        <span class="fac-text">{{ $facility }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="studio-tarif" class="studio-sec">
        <div class="container">
            <div class="sec-head">
                <h2 class="sec-title font-serif">Pilih studio, atur waktumu</h2>
                <p class="sec-sub">Tarif per jam, sudah termasuk peralatan standar. Minimal reservasi 1 jam.</p>
            </div>
            <div class="grid-3">
                @foreach ($studios as $index => $studio)
                    @php
                        $fallbacks = [
                            'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1525201548942-d8732f6617a0?auto=format&fit=crop&w=800&q=80',
                        ];
                        $fallbackUrl = $fallbacks[$index % count($fallbacks)];
                    @endphp
                    <div class="studio-card">
                        <div>
                            <div class="studio-img">
                                <img src="{{ asset($studio->image ?? 'images/studio-a.jpg') }}"
                                    onerror="this.src='{{ $fallbackUrl }}'" alt="{{ $studio->name }}">
                            </div>
                            <div class="studio-body">
                                <h3 class="studio-name font-serif">{{ $studio->name }}</h3>
                                <p class="studio-cap">{{ $studio->capacity ?? '4–6 orang' }}</p>
                                <p class="studio-desc">{{ $studio->description }}</p>
                            </div>
                        </div>
                        <div class="studio-foot">
                            <div class="studio-price">
                                Rp{{ number_format($studio->price_per_hour, 0, ',', '.') }} <span>/ jam</span>
                            </div>
                            <a href="{{ route('reservations.create', ['studio_id' => $studio->id]) }}"
                                class="btn-studio">Pilih studio</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="kontak" class="contact-sec">
        <div class="container contact-grid">
            <div>
                <h2 class="sec-title font-serif">Datang dan mulai bermain</h2>
                <div class="map-box">
                    <iframe title="Peta Lokasi Studio Musik Positif"
                        src="https://www.google.com/maps?q=Jl.+Teratai,+Sukajadi,+Pekanbaru,+Riau&output=embed"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="loc-info">
                    <p class="loc-addr">Jl. Teratai, Sukajadi, Pekanbaru</p>
                    <p>Setiap hari &middot; 09.00-23.59</p>
                    <div class="loc-contact">
                        <p>WhatsApp: 0811-7524-569</p>
                        <p>@positif.studio</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="sec-title font-serif">Hubungi kami</h2>
                <p class="sec-sub">Ada pertanyaan tentang studio atau reservasi? Kirim pesanmu.</p>

                @if (session('contact_success'))
                    <div class="alert-ok">{{ session('contact_success') }}</div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="c-form">
                    @csrf
                    <div class="group">
                        <label for="name" class="label">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name', old('nama')) }}"
                            required placeholder="Nama lengkap" class="input @error('name') err @enderror">
                        @error('name')
                            <span class="err-msg">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="group">
                        <label for="email" class="label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            placeholder="nama@email.com" class="input @error('email') err @enderror">
                        @error('email')
                            <span class="err-msg">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="group">
                        <label for="message" class="label">Pesan</label>
                        <textarea id="message" name="message" rows="4" required placeholder="Tulis pertanyaanmu..."
                            class="textarea @error('message') err @enderror">{{ old('message', old('pesan')) }}</textarea>
                        @error('message')
                            <span class="err-msg">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn-primary">Kirim pesan</button>
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div>
                    <p class="footer-brand font-serif">Studio Musik Positif</p>
                    <p class="footer-tag">Ruang untuk bermusik, bersama.</p>
                </div>
                <div class="footer-nav">
                    <div class="f-main">
                        <a href="#beranda">Beranda</a><span>&middot;</span>
                        <a href="#studio-tarif">Studio &amp; tarif</a><span>&middot;</span>
                        <a href="#kontak">Kontak</a>
                    </div>
                    <div class="f-sub">
                        <a href="#">Syarat &amp; ketentuan</a><span>&middot;</span>
                        <a href="#">Kebijakan privasi</a>
                    </div>
                </div>
            </div>
            <p class="footer-copy">&copy; 2026 Studio Musik Positif. Seluruh hak dilindungi.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-sec-link');
            const sectionIds = ['beranda', 'fasilitas', 'studio-tarif', 'kontak'];
            const sections = sectionIds
                .map(id => document.getElementById(id))
                .filter(Boolean)
                .sort((a, b) => a.offsetTop - b.offsetTop);

            let isClickScrolling = false;
            let clickTimer = null;

            function setActiveMenu(id) {
                navLinks.forEach(link => {
                    link.classList.toggle('active', link.getAttribute('data-section') === id);
                });
            }

            // Aktifkan menu sesuai URL hash saat berpindah dari halaman Masuk/Daftar
            if (window.location.hash) {
                const initialId = window.location.hash.replace('#', '');
                if (sectionIds.includes(initialId)) {
                    setActiveMenu(initialId);
                }
            }

            // Aktifkan menu saat link navbar atau tombol "Lihat studio" diklik
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function() {
                    const targetId = this.getAttribute('href').replace('#', '');
                    if (sectionIds.includes(targetId)) {
                        setActiveMenu(targetId);
                        isClickScrolling = true;
                        clearTimeout(clickTimer);
                        clickTimer = setTimeout(() => {
                            isClickScrolling = false;
                        }, 700);
                    }
                });
            });

            // Perbarui indikator menu otomatis saat halaman di-scroll
            window.addEventListener('scroll', function() {
                if (isClickScrolling) return;

                if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 40)) {
                    setActiveMenu('kontak');
                    return;
                }

                const scrollPos = window.scrollY + 140;
                let currentId = 'beranda';
                sections.forEach(sec => {
                    if (scrollPos >= sec.offsetTop) {
                        currentId = sec.id;
                    }
                });
                setActiveMenu(currentId);
            });
        });
    </script>
</body>

</html>
