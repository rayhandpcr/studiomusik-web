<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan — Studio Musik Positif</title>
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
<body class="min-h-screen flex flex-col justify-between">
    <!-- Navbar -->
    <header class="bg-[#121212] border-b border-zinc-800">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <svg class="w-6 h-6 text-[#F5A623]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13" />
                    <circle cx="6" cy="18" r="3" />
                    <circle cx="18" cy="16" r="3" />
                </svg>
                <div>
                    <span class="block text-sm font-semibold text-white">Studio Musik Positif</span>
                    <span class="block text-[11px] text-zinc-400">Dashboard Pelanggan</span>
                </div>
            </a>

            <div class="flex items-center gap-4">
                <span class="text-xs text-zinc-400">Halo, <strong class="text-white">{{ $user->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 text-xs rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-200 border border-zinc-700 transition">
                        Keluar (Logout)
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content Placeholder -->
    <main class="max-w-4xl mx-auto px-6 py-16 w-full">
        <div class="p-8 rounded-2xl bg-[#1C1C1C] border border-[#2E2E2E] shadow-2xl">
            <span class="px-2.5 py-1 text-[11px] font-medium rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                Login Berhasil (Pelanggan)
            </span>
            <h1 class="font-serif-heading text-3xl font-bold text-white mt-4 mb-2">
                Selamat Datang di Area Pelanggan
            </h1>
            <p class="text-sm text-zinc-400 mb-8">
                Halaman ini adalah placeholder sementara untuk rute <code class="text-[#F5A623]">/dashboard</code> sesuai instruksi pengerjaan sistem autentikasi.
            </p>

            <div class="bg-[#141414] rounded-xl border border-zinc-800 p-6 space-y-3 text-sm">
                <div class="flex justify-between border-b border-zinc-800/80 pb-2.5">
                    <span class="text-zinc-500">Nama Lengkap</span>
                    <span class="text-white font-medium">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between border-b border-zinc-800/80 pb-2.5">
                    <span class="text-zinc-500">Email</span>
                    <span class="text-white font-medium">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between border-b border-zinc-800/80 pb-2.5">
                    <span class="text-zinc-500">Peran (Role)</span>
                    <span class="px-2 py-0.5 rounded text-xs bg-amber-500/20 text-[#F5A623] font-semibold">{{ $user->role }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-500">Nomor Telepon</span>
                    <span class="text-white font-medium">{{ $user->phone ?? '-' }}</span>
                </div>
            </div>

            <div class="flex items-center gap-4 mt-8">
                <a href="{{ route('landing') }}" class="px-5 py-2.5 rounded-lg bg-[#F5A623] text-zinc-950 font-bold text-xs hover:bg-amber-400 transition">
                    Ke Beranda Utama
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-[#181818] border border-zinc-700 text-zinc-300 font-medium text-xs hover:bg-zinc-800 transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-[#2E2E2E] py-6 text-center text-xs text-zinc-500">
        &copy; 2026 Studio Musik Positif &middot; Dashboard Sementara
    </footer>
</body>
</html>
