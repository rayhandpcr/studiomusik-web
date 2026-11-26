<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi — Studio Musik Positif</title>
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
            font-size: 14px;
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        input,
        button {
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

        /* Navbar */
        .navbar {
            border-bottom: 1px solid rgba(71, 89, 116, 0.16);
            height: 74px;
            display: flex;
            align-items: center;
            background: rgba(249, 250, 252, 0.95);
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

        .nav-links a:hover {
            color: #1C3562;
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

        /* Main Content */
        .main {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 48px 0;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 56px;
            align-items: center;
        }

        .photo-box {
            aspect-ratio: 16/10;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 24px;
            background: #FFFFFF;
            border: 1px solid rgba(71, 89, 116, 0.18);
            box-shadow: 0 2px 8px rgba(28, 53, 98, 0.06);
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-title {
            font-size: 38px;
            font-weight: 400;
            line-height: 1.15;
            margin-bottom: 14px;
            color: #1C3562;
        }

        .hero-desc {
            font-size: 14.5px;
            color: #475974;
            line-height: 1.6;
        }

        /* Card Form */
        .card {
            background: #FFFFFF;
            border: 1px solid rgba(71, 89, 116, 0.18);
            border-radius: 10px;
            padding: 32px;
            box-shadow: 0 4px 16px rgba(28, 53, 98, 0.06);
        }

        .eyebrow {
            font-size: 11px;
            color: #475974;
            letter-spacing: 0.04em;
            margin-bottom: 8px;
        }

        .card-title {
            font-size: 26px;
            font-weight: 400;
            color: #1C3562;
            margin-bottom: 6px;
        }

        .card-sub {
            font-size: 13px;
            color: #475974;
            margin-bottom: 24px;
        }

        .group {
            margin-bottom: 18px;
        }

        .label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            color: #1C3562;
            margin-bottom: 6px;
        }

        .input {
            width: 100%;
            background: #FFFFFF;
            border: 1px solid rgba(71, 89, 116, 0.28);
            border-radius: 7px;
            padding: 10px 14px;
            font-size: 13.5px;
            color: #1C3562;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .input::placeholder {
            color: rgba(71, 89, 116, 0.6);
        }

        .input:focus {
            border-color: #1C3562;
            box-shadow: 0 0 0 3px rgba(28, 53, 98, 0.12);
        }

        .input.err {
            border-color: #EF4444;
        }

        .err-msg {
            display: block;
            font-size: 12px;
            color: #EF4444;
            margin-top: 4px;
        }

        .btn-submit {
            width: 100%;
            background: #1C3562;
            color: #F9FAFC;
            border: 1px solid #1C3562;
            border-radius: 7px;
            padding: 11px 16px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 6px;
        }

        .btn-submit:hover {
            background: #15284B;
            border-color: #A0AA54;
        }

        .divider {
            border: 0;
            border-top: 1px solid rgba(71, 89, 116, 0.16);
            margin: 22px 0 18px;
        }

        .card-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 13px;
            color: #475974;
        }

        .card-foot a {
            color: #1C3562;
            text-decoration: underline;
            font-weight: 500;
        }

        .card-foot a:hover {
            color: #A0AA54;
        }

        /* Footer */
        .footer {
            border-top: 1px solid rgba(71, 89, 116, 0.16);
            padding: 18px 0;
            font-size: 12px;
            color: #475974;
            background: #FFFFFF;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }
        }
    </style>
</head>

<body>
    <header class="navbar">
        <div class="container navbar-inner">
            <a href="{{ route('landing') }}" class="brand">
                <div class="brand-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13" />
                        <circle cx="6" cy="18" r="3" />
                        <circle cx="18" cy="16" r="3" />
                    </svg>
                    <span class="brand-name font-serif">Studio Musik Positif</span>
                </div>
                <span class="brand-tag">Ruang untuk bermusik.</span>
            </a>
            <nav class="nav-links">
                <a href="{{ route('landing') }}">Beranda</a>
                <a href="{{ url('/#studio-tarif') }}">Studio &amp; tarif</a>
                <a href="{{ url('/#fasilitas') }}">Fasilitas</a>
                <a href="{{ url('/#kontak') }}">Kontak</a>
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}" class="btn-nav">Daftar</a>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="grid">
                <div>
                    <div class="photo-box">
                        <img src="{{ asset('images/studio-a.jpg') }}" alt="Studio Musik Positif">
                    </div>
                    <h1 class="hero-title font-serif">Akses kembali<br>jadwal latihanmu.</h1>
                    <p class="hero-desc">Atur ulang kata sandi akunmu dengan cepat dan aman untuk melanjutkan reservasi sesi musik.</p>
                </div>

                <div class="card">
                    <p class="eyebrow">Publik / desktop</p>
                    <h2 class="card-title font-serif">Lupa kata sandi?</h2>
                    <p class="card-sub">Masukkan email akunmu untuk menerima tautan atur ulang kata sandi.</p>

                    @if (session('status'))
                        <div style="background: rgba(160, 170, 84, 0.15); border: 1px solid rgba(160, 170, 84, 0.45); border-radius: 8px; padding: 14px 16px; margin-bottom: 20px;">
                            <p style="color: #4B531B; font-size: 13px; font-weight: 600; margin-bottom: 8px;">
                                {{ session('status') }}
                            </p>
                            @if (session('reset_link'))
                                <p style="color: #475974; font-size: 12px; margin-bottom: 12px;">
                                    Di server lokal (Laragon), klik tombol di bawah untuk langsung menuju halaman reset:
                                </p>
                                <a href="{{ session('reset_link') }}" style="display: inline-block; background: #1C3562; color: #F9FAFC; font-weight: 600; font-size: 13px; padding: 9px 16px; border-radius: 6px; text-decoration: none;">
                                    Lanjutkan atur ulang kata sandi &rarr;
                                </a>
                            @endif
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="group">
                            <label for="email" class="label">Alamat email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com" class="input @error('email') err @enderror">
                            @error('email')
                                <span class="err-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit">Kirim tautan reset</button>
                    </form>

                    <hr class="divider">

                    <div class="card-foot">
                        <span>Ingat kata sandimu? <a href="{{ route('login') }}">Masuk</a></span>
                        <a href="{{ route('landing') }}">&larr; Kembali ke beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container footer-inner">
            <p>&copy; 2026 Studio Musik Positif &middot; Kebijakan Privasi</p>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('landing') }}">Beranda</a><span>&middot;</span>
                <a href="{{ url('/#studio-tarif') }}">Studio &amp; tarif</a><span>&middot;</span>
                <a href="{{ url('/#kontak') }}">Kontak</a>
            </div>
        </div>
    </footer>
</body>

</html>
