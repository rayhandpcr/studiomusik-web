<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi — Studio Musik Positif</title>
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
            padding: 10px 14px;
            font-size: 13.5px;
            color: #1C3562;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .input.has-btn {
            padding-right: 86px;
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

        .toggle-btn {
            position: absolute;
            right: 12px;
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
            margin-top: 8px;
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
                    <h1 class="hero-title font-serif">Buat kata sandi<br>baru yang aman.</h1>
                    <p class="hero-desc">Pastikan kata sandi barumu mudah diingat namun tetap aman untuk melindungi akun dan reservasi bandmu.</p>
                </div>

                <div class="card">
                    <p class="eyebrow">Publik / desktop</p>
                    <h2 class="card-title font-serif">Atur ulang kata sandi</h2>
                    <p class="card-sub">Buat kata sandi baru untuk akun Studio Musik Positif milikmu.</p>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="group">
                            <label for="email" class="label">Alamat email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required class="input @error('email') err @enderror">
                            @error('email')
                                <span class="err-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="password" class="label">Kata sandi baru</label>
                            <div class="input-wrap">
                                <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter" class="input has-btn @error('password') err @enderror">
                                <button type="button" class="toggle-btn" onclick="togglePass('password', this)">Tampilkan</button>
                            </div>
                            @error('password')
                                <span class="err-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="password_confirmation" class="label">Konfirmasi kata sandi baru</label>
                            <div class="input-wrap">
                                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi kata sandi baru" class="input has-btn">
                                <button type="button" class="toggle-btn" onclick="togglePass('password_confirmation', this)">Tampilkan</button>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit">Simpan kata sandi baru</button>
                    </form>

                    <hr class="divider">

                    <div class="card-foot">
                        <span>Ingin membatalkan? <a href="{{ route('login') }}">Masuk</a></span>
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

    <script>
        function togglePass(id, btn) {
            const el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
            btn.textContent = el.type === 'password' ? 'Tampilkan' : 'Sembunyikan';
        }
    </script>
</body>

</html>
