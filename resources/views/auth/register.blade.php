<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru — Studio Musik Positif</title>
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
            background: #121212;
            color: #F5F5F5;
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

        /* Navbar & Active Indicator */
        .navbar {
            border-bottom: 1px solid #2E2E2E;
            height: 74px;
            display: flex;
            align-items: center;
            background: #121212;
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
        }

        .brand-name {
            font-size: 17px;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.01em;
        }

        .brand-tag {
            font-size: 11px;
            color: #8E8E93;
            line-height: 1.35;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
            font-size: 13px;
            color: #8E8E93;
        }

        .nav-links a {
            font-weight: 400;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: #E4E4E7;
        }

        .btn-nav-active {
            border: 1px solid #F5F5F5;
            background: #242424;
            color: #FFFFFF !important;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600 !important;
        }

        /* Main Layout */
        .main {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 440px;
            gap: 56px;
            align-items: center;
        }

        .photo-box {
            width: 100%;
            aspect-ratio: 16/10;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #2E2E2E;
            background: #1A1A1A;
            margin-bottom: 22px;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-title {
            font-size: 36px;
            font-weight: 400;
            line-height: 1.2;
            letter-spacing: -0.01em;
            margin-bottom: 12px;
        }

        .hero-desc {
            font-size: 14px;
            color: #A3A3A3;
            max-width: 440px;
            line-height: 1.6;
        }

        /* Form Card */
        .card {
            background: #1A1A1A;
            border: 1px solid #2E2E2E;
            border-radius: 12px;
            padding: 28px 34px;
            width: 100%;
        }

        .eyebrow {
            font-size: 11px;
            color: #737373;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .card-title {
            font-size: 28px;
            font-weight: 400;
            line-height: 1.22;
            letter-spacing: -0.01em;
            margin-bottom: 4px;
        }

        .card-sub {
            font-size: 13px;
            color: #A3A3A3;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .group {
            margin-bottom: 12px;
        }

        .label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input {
            width: 100%;
            background: #242424;
            border: 1px solid #2E2E2E;
            border-radius: 7px;
            padding: 9px 13px;
            font-size: 13.5px;
            color: #F5F5F5;
            outline: none;
        }

        .input::placeholder {
            color: #737373;
        }

        .input:focus {
            border-color: #F5A623;
        }

        .input.has-btn {
            padding-right: 86px;
        }

        .input.err {
            border-color: #EF4444;
        }

        .toggle-btn {
            position: absolute;
            right: 11px;
            background: none;
            border: none;
            color: #A3A3A3;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
        }

        .toggle-btn:hover {
            color: #F5F5F5;
        }

        .err-msg {
            display: block;
            font-size: 12px;
            color: #EF4444;
            margin-top: 4px;
        }

        .chk-row {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin: 14px 0 16px;
        }

        .chk-row input {
            margin-top: 2px;
            accent-color: #F5A623;
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            cursor: pointer;
        }

        .chk-row label {
            font-size: 12px;
            color: #A3A3A3;
            line-height: 1.45;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            background: #F5A623;
            color: #121212;
            border: none;
            border-radius: 7px;
            padding: 10.5px 16px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #E09416;
        }

        .divider {
            border: 0;
            border-top: 1px solid #2E2E2E;
            margin: 18px 0 14px;
        }

        .card-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 13px;
            color: #A3A3A3;
        }

        .card-foot .login-link {
            color: #F5F5F5;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 3px;
            margin-left: 4px;
        }

        .card-foot .login-link:hover {
            color: #F5A623;
        }

        /* Footer */
        .footer {
            border-top: 1px solid #2E2E2E;
            padding: 18px 0;
            font-size: 12px;
            color: #737373;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-links {
            display: flex;
            gap: 12px;
        }

        .footer-links a:hover {
            color: #A3A3A3;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .nav-links {
                display: none;
            }
        }
    </style>
</head>

<body>
    @php
        $imageFiles = glob(public_path('images/*.{jpg,jpeg,png,webp}'), GLOB_BRACE);
        $registerImage = 'images/studio-a.jpg';
        if (!empty($imageFiles)) {
            $preferred = collect($imageFiles)->first(
                fn($path) => str_contains(strtolower(basename($path)), 'peralatan') ||
                    str_contains(strtolower(basename($path)), 'alat') ||
                    str_contains(strtolower(basename($path)), 'studio'),
            );
            $selectedPath = $preferred ?: $imageFiles[0];
            $registerImage = 'images/' . basename($selectedPath);
        }
    @endphp

    <header class="navbar">
        <div class="container navbar-inner">
            <a href="{{ route('landing') }}" class="brand">
                <div class="brand-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 18V5l12-2v13"></path>
                        <circle cx="6" cy="18" r="3"></circle>
                        <circle cx="18" cy="16" r="3"></circle>
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
                <a href="{{ route('register') }}" class="btn-nav-active">Daftar</a>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="grid">
                <div>
                    <div class="photo-box">
                        <img src="{{ asset($registerImage) }}" alt="Peralatan Studio Musik Positif">
                    </div>
                    <h1 class="hero-title font-serif">Lebih banyak musik.<br>Lebih sedikit urusan jadwal.</h1>
                    <p class="hero-desc">Reservasi studio, atur waktu latihan, dan bagi biaya bersama anggota band dalam
                        satu tempat.</p>
                </div>

                <div class="card">
                    <p class="eyebrow">Publik / desktop</p>
                    <h2 class="card-title font-serif">Buat akun baru</h2>
                    <p class="card-sub">Daftar untuk mulai menjadwalkan sesi latihanmu.</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="group">
                            <label for="name" class="label">Nama lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="Rayhand Wijaksono" class="input @error('name') err @enderror" required
                                autofocus>
                            @error('name')
                                <span class="err-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="email" class="label">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="rayhandwijaksono@gmail.com" class="input @error('email') err @enderror"
                                required>
                            @error('email')
                                <span class="err-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="phone" class="label">Nomor WhatsApp</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                placeholder="0856-6441-9330" class="input @error('phone') err @enderror" required>
                            @error('phone')
                                <span class="err-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="password" class="label">Kata sandi</label>
                            <div class="input-wrap">
                                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter"
                                    class="input has-btn @error('password') err @enderror" required>
                                <button type="button" class="toggle-btn"
                                    onclick="togglePass('password', this)">Tampilkan</button>
                            </div>
                            @error('password')
                                <span class="err-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="password_confirmation" class="label">Konfirmasi kata sandi</label>
                            <div class="input-wrap">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Ulangi kata sandi" class="input has-btn" required>
                                <button type="button" class="toggle-btn"
                                    onclick="togglePass('password_confirmation', this)">Tampilkan</button>
                            </div>
                        </div>

                        <div class="chk-row">
                            <input type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }}
                                required>
                            <label for="terms">Saya menyetujui Syarat &amp; Ketentuan dan Kebijakan Privasi.</label>
                        </div>
                        @error('terms')
                            <span class="err-msg" style="margin-top:-10px;margin-bottom:12px;">{{ $message }}</span>
                        @enderror

                        <button type="submit" class="btn-submit">Daftar</button>
                    </form>

                    <hr class="divider">

                    <div class="card-foot">
                        <span>Sudah punya akun?<a href="{{ route('login') }}" class="login-link">Masuk</a></span>
                        <a href="{{ route('landing') }}">&larr; Kembali ke beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container footer-inner">
            <p>&copy; 2026 Studio Musik Positif &middot; Kebijakan Privasi</p>
            <div class="footer-links">
                <a href="{{ route('landing') }}">Beranda</a><span>&middot;</span>
                <a href="{{ url('/#studio-tarif') }}">Studio &amp; tarif</a><span>&middot;</span>
                <a href="{{ url('/#kontak') }}">Kontak</a>
            </div>
        </div>
    </footer>

    <script>
        function togglePass(id, btn) {
            const el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
            btn.textContent = el.type === 'password' ? 'Tampilkan' : 'Sembunyikan';
        }
    </script>
</body>

</html>
