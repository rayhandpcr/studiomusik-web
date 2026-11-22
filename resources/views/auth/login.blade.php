<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Studio Musik Positif</title>

    <!-- Tailwind CSS (Otomatis pakai Vite jika sudah di-build, atau fallback CDN) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            background-color: #121212;
            color: #F4F4F5;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .font-serif-heading {
            font-family: "Times New Roman", Times, Georgia, serif;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-[#F5A623] selection:text-zinc-950 bg-[#121212]">

    <!-- ================= NAVBAR ================= -->
    <header class="sticky top-0 z-50 bg-[#121212]/95 backdrop-blur border-b border-[#2E2E2E]">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo Kiri -->
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <svg class="w-6 h-6 text-white group-hover:text-[#F5A623] transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13" />
                    <circle cx="6" cy="18" r="3" />
                    <circle cx="18" cy="16" r="3" />
                </svg>
                <div>
                    <span class="block text-sm font-semibold text-white leading-tight">Studio Musik Positif</span>
                    <span class="block text-[11px] text-zinc-400">Ruang untuk bermusik.</span>
                </div>
            </a>

            <!-- Menu Kanan -->
            <nav class="hidden md:flex items-center gap-7 text-xs font-medium text-zinc-300">
                <a href="{{ route('landing') }}" class="hover:text-[#F5A623] transition">Beranda</a>
                <a href="{{ url('/#studio-tarif') }}" class="hover:text-[#F5A623] transition">Studio &amp; tarif</a>
                <a href="{{ url('/#fasilitas') }}" class="hover:text-[#F5A623] transition">Fasilitas</a>
                <a href="{{ url('/#kontak') }}" class="hover:text-[#F5A623] transition">Kontak</a>
                <a href="{{ route('login') }}" class="text-[#F5A623] font-semibold transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-md border border-zinc-700 bg-[#1A1A1A] text-white hover:border-zinc-500 transition">
                    Daftar
                </a>
            </nav>
        </div>
    </header>

    <!-- ================= LAYOUT UTAMA (2 KOLOM DESKTOP) ================= -->
    <main class="flex-1 flex items-center py-10 lg:py-16">
        <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <!-- KOLOM KIRI: Foto Ruang Studio & Headline -->
            <div class="lg:col-span-6 space-y-6">
                <!-- Kartu Foto Ruang Studio Musik -->
                <div class="rounded-xl overflow-hidden border border-[#2E2E2E] bg-[#1C1C1C] aspect-[16/10] shadow-2xl">
                    <img
                        src="{{ asset('images/studio-a.jpg') }}"
                        onerror="this.src='{{ asset('images/studio-a.jpg') }}'"
                        alt="Ruang Latihan Studio Musik Positif"
                        class="w-full h-full object-cover"
                    >
                </div>

                <!-- Judul Besar 2 Baris & Subteks -->
                <div class="space-y-3">
                    <h1 class="font-serif-heading text-3xl sm:text-4xl lg:text-[42px] font-bold text-white tracking-tight leading-[1.18]">
                        Lebih banyak musik.<br>
                        Lebih sedikit urusan jadwal.
                    </h1>

                    <p class="text-sm text-zinc-400 leading-relaxed max-w-lg">
                        Reservasi studio, atur waktu latihan, dan bagi biaya bersama anggota band dalam satu tempat.
                    </p>
                </div>
            </div>

            <!-- KOLOM KANAN: Kartu Form Login Berbingkai -->
            <div class="lg:col-span-6 flex justify-center lg:justify-end">
                <div class="w-full max-w-md rounded-xl bg-[#1C1C1C] border border-[#2E2E2E] p-7 sm:p-9 shadow-2xl">
                    
                    <!-- Label Kecil di Atas -->
                    <p class="text-[11px] font-medium text-zinc-500 mb-2">
                        Publik / desktop
                    </p>

                    <!-- Judul Form & Subjudul -->
                    <h2 class="font-serif-heading text-2xl sm:text-3xl font-bold text-white tracking-tight mb-1.5">
                        Masuk ke akunmu
                    </h2>
                    <p class="text-xs sm:text-sm text-zinc-400 mb-6">
                        Selamat datang kembali di Studio Musik Positif.
                    </p>

                    <!-- Flash Message / Validasi Error Alert -->
                    @if ($errors->any())
                        <div class="mb-5 px-3.5 py-2.5 rounded-md bg-red-500/10 border border-red-500/30 text-red-400 text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $error }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Formulir Login -->
                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Input Email -->
                        <div>
                            <label for="email" class="block text-xs font-medium text-zinc-300 mb-1.5">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                                placeholder="rayhandwijaksono@gmail.com"
                                class="w-full px-3.5 py-2.5 rounded-md bg-[#141414] border @error('email') border-red-500 focus:border-red-500 @else border-[#2E2E2E] focus:border-[#F5A623] @enderror text-xs sm:text-sm text-white placeholder-zinc-500 focus:outline-none transition"
                            >
                            @error('email')
                                <p class="text-[11px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Kata Sandi dengan Tombol Toggle Tampilkan -->
                        <div>
                            <label for="password" class="block text-xs font-medium text-zinc-300 mb-1.5">Kata sandi</label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                    class="w-full px-3.5 py-2.5 pr-24 rounded-md bg-[#141414] border @error('password') border-red-500 focus:border-red-500 @else border-[#2E2E2E] focus:border-[#F5A623] @enderror text-xs sm:text-sm text-white placeholder-zinc-500 focus:outline-none transition"
                                >
                                <button
                                    type="button"
                                    id="togglePassword"
                                    aria-label="Tampilkan atau sembunyikan kata sandi"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 px-2 py-1 text-xs font-medium text-zinc-400 hover:text-white transition select-none cursor-pointer focus:outline-none"
                                >
                                    Tampilkan
                                </button>
                            </div>
                            @error('password')
                                <p class="text-[11px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Checkbox Ingat Saya & Tautan Lupa Kata Sandi -->
                        <div class="flex items-center justify-between text-xs pt-1">
                            <label for="remember" class="flex items-center gap-2 cursor-pointer text-zinc-300 select-none">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    value="1"
                                    {{ old('remember') ? 'checked' : '' }}
                                    class="w-4 h-4 rounded bg-[#141414] border-[#2E2E2E] text-[#F5A623] accent-[#F5A623] focus:ring-0 cursor-pointer"
                                >
                                <span class="text-zinc-300 text-xs">Ingat saya</span>
                            </label>

                            <a href="#" class="text-xs text-zinc-400 hover:text-[#F5A623] transition">
                                Lupa kata sandi?
                            </a>
                        </div>

                        <!-- Tombol Submit Lebar Penuh (#F5A623) -->
                        <div class="pt-1">
                            <button
                                type="submit"
                                class="w-full py-2.5 px-4 rounded-md bg-[#F5A623] hover:bg-amber-400 text-zinc-950 font-bold text-xs sm:text-sm tracking-wide transition shadow cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#F5A623] focus:ring-offset-2 focus:ring-offset-[#1C1C1C]"
                            >
                                Masuk
                            </button>
                        </div>

                        <!-- Keterangan Kecil -->
                        <p class="text-[11px] text-zinc-400 text-center leading-relaxed">
                            Akun pelanggan dan admin masuk melalui formulir yang sama.
                        </p>

                        <!-- Garis Pembatas Horizontal -->
                        <hr class="border-[#2E2E2E] my-5">

                        <!-- Belum Punya Akun & Kembali ke Beranda -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-zinc-400">
                            <span>
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-[#F5A623] hover:underline font-semibold ml-1">
                                    Daftar sekarang
                                </a>
                            </span>

                            <a href="{{ route('landing') }}" class="text-zinc-400 hover:text-white transition flex items-center gap-1 group">
                                <span class="group-hover:-translate-x-0.5 transition-transform">&larr;</span>
                                <span>Kembali ke beranda</span>
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </main>

    <!-- ================= FOOTER BAWAH ================= -->
    <footer class="border-t border-[#2E2E2E] bg-[#121212] py-6 text-xs text-zinc-500">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p>&copy; 2026 Studio Musik Positif &middot; Kebijakan Privasi</p>
            <div class="flex items-center gap-4 text-[11px]">
                <a href="{{ route('landing') }}" class="hover:text-zinc-400 transition">Beranda</a>
                <span>&middot;</span>
                <a href="{{ url('/#studio-tarif') }}" class="hover:text-zinc-400 transition">Studio &amp; tarif</a>
                <span>&middot;</span>
                <a href="{{ url('/#kontak') }}" class="hover:text-zinc-400 transition">Kontak</a>
            </div>
        </div>
    </footer>

    <!-- JavaScript Toggle Password Interaktif -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePassword');

            if (passwordInput && toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    toggleBtn.textContent = isPassword ? 'Sembunyikan' : 'Tampilkan';
                });
            }
        });
    </script>
</body>
</html>
