<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Studio Musik Positif</title>
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

        /* Navbar & Active Indicator */
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

        .nav-links a {
            font-weight: 400;
            transition: color 0.2s ease;
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
            border: 1px solid rgba(71, 89, 116, 0.18);
            background: #FFFFFF;
            box-shadow: 0 2px 8px rgba(28, 53, 98, 0.06);
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
            color: #1C3562;
        }

        .hero-desc {
            font-size: 14px;
            color: #475974;
            max-width: 440px;
            line-height: 1.6;
        }

        /* Form Card */
        .card {
            background: #FFFFFF;
            border: 1px solid rgba(71, 89, 116, 0.18);
            border-radius: 12px;
            padding: 30px 34px;
            width: 100%;
            box-shadow: 0 4px 16px rgba(28, 53, 98, 0.06);
        }

        .eyebrow {
            font-size: 11px;
            color: #475974;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .card-title {
            font-size: 28px;
            font-weight: 400;
            line-height: 1.22;
            letter-spacing: -0.01em;
            margin-bottom: 4px;
            color: #1C3562;
        }

        .card-sub {
            font-size: 13px;
            color: #475974;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .alert-err {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #EF4444;
            border-radius: 7px;
            padding: 9px 12px;
            font-size: 12px;
            margin-bottom: 14px;
        }

        .group {
            margin-bottom: 14px;
        }

        .label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            line-height: 1.4;
            color: #1C3562;
            margin-bottom: 5px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input {
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

        .input::placeholder {
            color: rgba(71, 89, 116, 0.6);
        }

        .input:focus {
            border-color: #1C3562;
            box-shadow: 0 0 0 3px rgba(28, 53, 98, 0.12);
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
            color: #475974;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
        }

        .toggle-btn:hover {
            color: #1C3562;
        }

        .err-msg {
            display: block;
            font-size: 12px;
            color: #EF4444;
            margin-top: 4px;
        }

        .opt-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 14px 0 18px;
            font-size: 12px;
            color: #475974;
        }

        .chk-label {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            color: #475974;
        }

        .chk-label input {
            accent-color: #1C3562;
            width: 14px;
            height: 14px;
        }

        .forgot {
            color: #1C3562;
            font-weight: 500;
        }

        .forgot:hover {
            color: #A0AA54;
        }

        .btn-submit {
            width: 100%;
            background: #1C3562;
            color: #F9FAFC;
            border: 1px solid #1C3562;
            border-radius: 7px;
            padding: 10.5px 16px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            background: #15284B;
            border-color: #A0AA54;
        }

        .note {
            font-size: 12px;
            color: #475974;
            text-align: center;
            margin-top: 10px;
        }

        .divider {
            border: 0;
            border-top: 1px solid rgba(71, 89, 116, 0.16);
            margin: 18px 0 16px;
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
            font-weight: 500;
        }

        .card-foot .reg-link {
            color: #1C3562;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 3px;
            margin-left: 4px;
        }

        .card-foot .reg-link:hover {
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

        .footer-links {
            display: flex;
            gap: 12px;
        }

        .footer-links a:hover {
            color: #1C3562;
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
                <a href="{{ route('login') }}" class="active">Masuk</a>
                <a href="{{ route('register') }}" class="btn-nav">Daftar</a>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="grid">
                <div>
                    <div class="photo-box">
                        <img src="{{ asset('images/studio-a.jpg') }}" alt="Ruang Latihan Studio Musik Positif">
                    </div>
                    <h1 class="hero-title font-serif">Lebih banyak musik.<br>Lebih sedikit urusan jadwal.</h1>
                    <p class="hero-desc">Reservasi studio, atur waktu latihan, dan bagi biaya bersama anggota band dalam
                        satu tempat.</p>
                </div>

                <div class="card">
                    <p class="eyebrow">Publik / desktop</p>
                    <h2 class="card-title font-serif">Masuk ke akunmu</h2>
                    <p class="card-sub">Selamat datang kembali di Studio Musik Positif.</p>

                    @if (session('success'))
                        <div style="background: rgba(160, 170, 84, 0.15); border: 1px solid rgba(160, 170, 84, 0.45); border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #4B531B; font-size: 13px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert-err">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="group">
                            <label for="email" class="label">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', request()->cookie('remembered_email')) }}" required
                                autofocus placeholder="rayhandwijaksono@gmail.com"
                                class="input @error('email') err @enderror">
                            @error('email')
                                <span class="err-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="password" class="label">Kata sandi</label>
                            <div class="input-wrap">
                                <input type="password" id="password" name="password" required placeholder="••••••••"
                                    class="input has-btn @error('password') err @enderror">
                                <button type="button" class="toggle-btn"
                                    onclick="togglePass('password', this)">Tampilkan</button>
                            </div>
                            @error('password')
                                <span class="err-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="opt-row">
                            <label for="remember" class="chk-label">
                                <input type="checkbox" id="remember" name="remember" value="1"
                                    {{ old('remember', request()->cookie('remembered_email') ? '1' : '') ? 'checked' : '' }}>
                                <span>Ingat saya</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="forgot">Lupa kata sandi?</a>
                        </div>

                        <button type="submit" class="btn-submit">Masuk</button>
                        <p class="note">Akun pelanggan dan admin masuk melalui formulir yang sama.</p>
                    </form>

                    <hr class="divider">

                    <div class="card-foot">
                        <span>Belum punya akun? <a href="{{ route('register') }}" class="reg-link">Daftar sekarang</a></span>
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
