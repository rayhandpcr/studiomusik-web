<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Musik Positif — Ruang untuk bermusik</title>

    <!-- Tailwind CSS (Otomatis pakai Vite jika sudah di-build, atau fallback CDN) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        html, body, input, textarea, button, select {
            font-family: 'Times New Roman', Times, serif !important;
        }

        body {
            background-color: #121212;
            color: #F4F4F5;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#F5A623] selection:text-zinc-950">

    <!-- ================= NAVBAR ================= -->
    <header class="sticky top-0 z-50 bg-[#121212]/95 backdrop-blur border-b border-zinc-800/70">
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
                <a href="#beranda" class="text-white hover:text-[#F5A623] transition">Beranda</a>
                <a href="#studio-tarif" class="hover:text-[#F5A623] transition">Studio &amp; tarif</a>
                <a href="#fasilitas" class="hover:text-[#F5A623] transition">Fasilitas</a>
                <a href="#kontak" class="hover:text-[#F5A623] transition">Kontak</a>
                <a href="{{ route('login') }}" class="hover:text-[#F5A623] transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-md border border-zinc-700 bg-[#1A1A1A] text-white hover:border-zinc-500 transition">
                    Daftar
                </a>
            </nav>
        </div>
    </header>

    <!-- ================= HERO SECTION ================= -->
    <section id="beranda" class="py-16 lg:py-20">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Kolom Teks Kiri -->
            <div class="lg:col-span-6 space-y-5">
                <p class="text-[11px] text-zinc-500">
                    Publik / desktop / beranda
                </p>

                <h1 class="text-4xl sm:text-[44px] font-bold text-white tracking-tight leading-[1.15]">
                    Tempat ide musik<br>menjadi nyata.
                </h1>

                <p class="text-sm text-zinc-400 leading-relaxed max-w-md">
                    Latihan nyaman, alat lengkap, jadwal fleksibel. Pilih studio dan reservasi waktu bermainmu di Studio Musik Positif.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ route('reservations.create') }}"
                       class="px-5 py-2.5 rounded-md bg-[#F5A623] hover:bg-amber-400 text-zinc-950 font-semibold text-xs transition">
                        Reservasi sekarang
                    </a>
                    <a href="#studio-tarif"
                       class="px-5 py-2.5 rounded-md bg-[#181818] hover:bg-zinc-800 border border-zinc-700 text-zinc-200 font-medium text-xs transition">
                        Lihat studio
                    </a>
                </div>

                <p class="text-[11px] text-zinc-400 pt-1">
                    Mulai Rp70.000 / jam &middot; Buka setiap hari 09.00-23.59
                </p>
            </div>

            <!-- Kolom Foto Utama Kanan -->
            <div class="lg:col-span-6">
                <div class="rounded-lg overflow-hidden border border-zinc-800 bg-zinc-900 aspect-[16/10] shadow-2xl">
                    <img src="{{ asset('images/hero-studio.jpg') }}"
                         onerror="this.src='https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&w=1000&q=80'"
                         alt="Ruang Latihan Utama Studio Musik Positif"
                         class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- ================= KEUNGGULAN UTAMA ================= -->
    <section class="py-12">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-lg font-semibold text-white mb-6">
                Semua yang kamu butuhkan untuk latihan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Item 1: Ruang -->
                <div class="group">
                    <div class="rounded-lg overflow-hidden border border-zinc-800 bg-zinc-900 aspect-[16/10] mb-3.5">
                        <img src="{{ asset('images/feature-ruang.jpg') }}"
                             onerror="this.src='https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&w=800&q=80'"
                             alt="Ruang Latihan Kedap Suara"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-1">Ruang</h3>
                    <p class="text-xs text-zinc-400 leading-relaxed">
                        Ruang latihan kedap suara untuk fokus pada musik.
                    </p>
                </div>

                <!-- Item 2: Peralatan -->
                <div class="group">
                    <div class="rounded-lg overflow-hidden border border-zinc-800 bg-zinc-900 aspect-[16/10] mb-3.5">
                        <img src="{{ asset('images/feature-peralatan.jpg') }}"
                             onerror="this.src='https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=800&q=80'"
                             alt="Peralatan Standar Band"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-1">Peralatan</h3>
                    <p class="text-xs text-zinc-400 leading-relaxed">
                        Peralatan standar band siap dipakai di setiap sesi.
                    </p>
                </div>

                <!-- Item 3: Fasilitas -->
                <div class="group">
                    <div class="rounded-lg overflow-hidden border border-zinc-800 bg-zinc-900 aspect-[16/10] mb-3.5">
                        <img src="{{ asset('images/feature-fasilitas.jpg') }}"
                             onerror="this.src='https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=800&q=80'"
                             alt="Ruang Tunggu dan Wi-Fi"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-1">Fasilitas</h3>
                    <p class="text-xs text-zinc-400 leading-relaxed">
                        Ruang tunggu dan Wi-Fi untuk kenyamananmu.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FASILITAS DI SETIAP SESI ================= -->
    <section id="fasilitas" class="py-12">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-lg font-semibold text-white mb-6">
                Fasilitas di setiap sesi
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                @foreach ($facilities as $facility)
                    <div class="flex items-center gap-3 px-4 py-3.5 rounded-md bg-[#181818] border border-zinc-800/90 hover:border-zinc-700 transition">
                        <!-- Ikon Kotak Grid Titik Amber sesuai Desain -->
                        <span class="w-6 h-6 rounded border border-amber-500/40 bg-amber-500/10 flex items-center justify-center text-[#F5A623] shrink-0">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 16 16">
                                <circle cx="4" cy="4" r="1.2"/><circle cx="8" cy="4" r="1.2"/><circle cx="12" cy="4" r="1.2"/>
                                <circle cx="4" cy="8" r="1.2"/><circle cx="8" cy="8" r="1.2"/><circle cx="12" cy="8" r="1.2"/>
                                <circle cx="4" cy="12" r="1.2"/><circle cx="8" cy="12" r="1.2"/><circle cx="12" cy="12" r="1.2"/>
                            </svg>
                        </span>
                        <span class="text-xs font-medium text-zinc-200">{{ $facility }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ================= PILIH STUDIO, ATUR WAKTUMU ================= -->
    <section id="studio-tarif" class="py-14 pb-20">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-7">
                <h2 class="text-lg font-semibold text-white mb-1">
                    Pilih studio, atur waktumu
                </h2>
                <p class="text-xs text-zinc-400">
                    Tarif per jam, sudah termasuk peralatan standar. Minimal reservasi 1 jam.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($studios as $index => $studio)
                    @php
                        $fallbackImages = [
                            'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1525201548942-d8732f6617a0?auto=format&fit=crop&w=800&q=80',
                        ];
                        $fallbackUrl = $fallbackImages[$index % count($fallbackImages)];
                    @endphp

                    <div class="rounded-lg bg-[#1A1A1A] border border-zinc-800 overflow-hidden flex flex-col justify-between hover:border-zinc-700 transition">
                        <div>
                            <!-- Foto Studio -->
                            <div class="aspect-[16/10] bg-zinc-900 overflow-hidden border-b border-zinc-800">
                                <img src="{{ asset($studio->image ?? 'images/studio-a.jpg') }}"
                                     onerror="this.src='{{ $fallbackUrl }}'"
                                     alt="{{ $studio->name }}"
                                     class="w-full h-full object-cover">
                            </div>

                            <!-- Detail Studio -->
                            <div class="p-5 pb-3">
                                <h3 class="text-sm font-semibold text-white mb-1">
                                    {{ $studio->name }}
                                </h3>
                                <p class="text-[11px] text-zinc-400 mb-3">
                                    {{ $studio->capacity ?? '4–6 orang' }}
                                </p>
                                <p class="text-[11px] text-zinc-400 leading-relaxed">
                                    {{ $studio->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Tarif & Tombol Pilih Studio -->
                        <div class="p-5 pt-3">
                            <div class="text-sm font-bold text-white mb-4">
                                Rp{{ number_format($studio->price_per_hour, 0, ',', '.') }}
                                <span class="text-xs font-normal text-zinc-400">/ jam</span>
                            </div>

                            <a href="{{ route('reservations.create', ['studio_id' => $studio->id]) }}"
                               class="block w-full text-center py-2.5 px-4 rounded-md bg-transparent hover:bg-[#F5A623] hover:text-zinc-950 border border-zinc-700 hover:border-[#F5A623] text-xs font-medium text-zinc-200 transition">
                                Pilih studio
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ================= LOKASI & HUBUNGI KAMI (BAND ABU-ABU GELAP) ================= -->
    <section id="kontak" class="py-16 bg-[#181818] border-y border-zinc-800/80">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Kiri: Datang dan mulai bermain -->
            <div class="lg:col-span-6 space-y-4">
                <h2 class="text-lg font-semibold text-white">
                    Datang dan mulai bermain
                </h2>

                <!-- Peta Lokasi Jl. Teratai, Sukajadi, Pekanbaru -->
                <div class="rounded-lg overflow-hidden border border-zinc-700/80 bg-zinc-900 h-52">
                    <iframe
                        title="Peta Lokasi Studio Musik Positif"
                        src="https://www.google.com/maps?q=Jl.+Teratai,+Sukajadi,+Pekanbaru,+Riau&output=embed"
                        class="w-full h-full border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <div class="space-y-1 text-xs text-zinc-400 pt-1">
                    <p class="text-zinc-200 font-medium">Jl. Teratai, Sukajadi, Pekanbaru</p>
                    <p>setiap hari &middot; 09.00-23.59</p>
                    <p class="pt-2">WhatsApp: 0811-7524-569</p>
                    <p>@positif.studio</p>
                </div>
            </div>

            <!-- Kanan: Hubungi kami -->
            <div class="lg:col-span-6">
                <h2 class="text-lg font-semibold text-white mb-1">
                    Hubungi kami
                </h2>
                <p class="text-xs text-zinc-400 mb-5">
                    Ada pertanyaan tentang studio atau reservasi? Kirim pesanmu.
                </p>

                @if (session('contact_success'))
                    <div class="mb-4 px-4 py-3 rounded-md bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs">
                        {{ session('contact_success') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nama" class="block text-xs font-medium text-zinc-300 mb-1.5">Nama</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                               placeholder="Nama lengkap"
                               class="w-full px-3.5 py-2.5 rounded-md bg-[#222222] border border-zinc-800 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-[#F5A623] transition">
                        @error('nama')
                            <p class="text-[11px] text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-medium text-zinc-300 mb-1.5">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               placeholder="nama@email.com"
                               class="w-full px-3.5 py-2.5 rounded-md bg-[#222222] border border-zinc-800 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-[#F5A623] transition">
                        @error('email')
                            <p class="text-[11px] text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="pesan" class="block text-xs font-medium text-zinc-300 mb-1.5">Pesan</label>
                        <textarea id="pesan" name="pesan" rows="4" required
                                  placeholder="Tulis pertanyaanmu..."
                                  class="w-full px-3.5 py-2.5 rounded-md bg-[#222222] border border-zinc-800 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-[#F5A623] transition">{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <p class="text-[11px] text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="px-5 py-2.5 rounded-md bg-[#F5A623] hover:bg-amber-400 text-zinc-950 font-semibold text-xs transition cursor-pointer">
                        Kirim pesan
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="py-10 bg-[#121212] text-xs text-zinc-400">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 pb-8 border-b border-zinc-800/80">
                <div>
                    <p class="font-semibold text-white text-sm">Studio Musik Positif</p>
                    <p class="text-[11px] text-zinc-500 mt-1">Ruang untuk bermusik, bersama.</p>
                </div>

                <div class="sm:text-right space-y-1.5 text-[11px]">
                    <div class="space-x-2 text-zinc-300">
                        <a href="#beranda" class="hover:text-[#F5A623] transition">Beranda</a>
                        <span>&middot;</span>
                        <a href="#studio-tarif" class="hover:text-[#F5A623] transition">Studio &amp; tarif</a>
                        <span>&middot;</span>
                        <a href="#kontak" class="hover:text-[#F5A623] transition">Kontak</a>
                    </div>
                    <div class="space-x-2 text-zinc-500">
                        <a href="#" class="hover:text-zinc-300 transition">Syarat &amp; ketentuan</a>
                        <span>&middot;</span>
                        <a href="#" class="hover:text-zinc-300 transition">Kebijakan privasi</a>
                    </div>
                </div>
            </div>

            <p class="pt-6 text-[11px] text-zinc-500">
                &copy; 2026 Studio Musik Positif. Seluruh hak dilindungi.
            </p>
        </div>
    </footer>

</body>
</html>
