<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Pengelola (Admin) — Studio Musik Positif</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            background-color: #F9FAFC;
            color: #1E293B;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .font-serif-heading {
            font-family: "Times New Roman", Times, Georgia, serif;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-[#A0AA54] selection:text-[#1C3562] bg-[#F9FAFC]">

    <!-- ================= NAVBAR ADMIN ================= -->
    <header class="sticky top-0 z-50 bg-[#FFFFFF]/95 backdrop-blur border-b border-[rgba(71,89,116,0.16)]">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <svg class="w-6 h-6 text-[#1C3562] group-hover:text-[#A0AA54] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13" />
                    <circle cx="6" cy="18" r="3" />
                    <circle cx="18" cy="16" r="3" />
                </svg>
                <div>
                    <span class="block text-sm font-semibold text-[#1C3562] leading-tight">Studio Musik Positif</span>
                    <span class="block text-[11px] text-[#475974]">Panel Pengelola (Admin)</span>
                </div>
            </a>

            <div class="flex items-center gap-4 sm:gap-6">
                <div class="hidden sm:block text-right">
                    <p class="text-xs font-medium text-[#1C3562]">{{ $user->name }}</p>
                    <p class="text-[11px] text-[#A0AA54] font-semibold uppercase tracking-wider">{{ $user->role }}</p>
                </div>

                <a href="{{ route('landing') }}" class="text-xs text-[#475974] hover:text-[#1C3562] transition hidden md:inline-block">
                    Lihat Situs
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 text-xs rounded-md bg-[#FFFFFF] hover:bg-slate-50 text-[#1C3562] border border-[rgba(71,89,116,0.28)] hover:border-[#1C3562] transition cursor-pointer">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- ================= KONTEN UTAMA ADMIN ================= -->
    <main class="flex-1 max-w-7xl mx-auto px-6 py-10 w-full space-y-8">
        
        <!-- Flash Alert Sukses -->
        @if (session('admin_success'))
            <div class="px-4 py-3 rounded-lg bg-[rgba(160,170,84,0.15)] border border-[rgba(160,170,84,0.45)] text-[#4B531B] text-xs sm:text-sm flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('admin_success') }}</span>
            </div>
        @endif

        <!-- Judul Halaman & Ringkasan -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[rgba(71,89,116,0.16)]">
            <div>
                <p class="text-xs font-medium text-[#475974] uppercase tracking-wider mb-1">
                    Dashboard Pengelola
                </p>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-bold text-[#1C3562] tracking-tight">
                    Pesan Masuk &amp; Hubungi Kami
                </h1>
                <p class="text-xs sm:text-sm text-[#475974] mt-1">
                    Kelola seluruh pertanyaan dan pesan yang dikirimkan oleh pengunjung melalui formulir halaman Landing.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 text-xs rounded-md bg-[#FFFFFF] hover:bg-slate-50 text-[#1C3562] border border-[rgba(71,89,116,0.28)] transition flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-[#475974]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Segarkan Data</span>
                </a>
            </div>
        </div>

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Total Pesan -->
            <div class="p-5 rounded-xl bg-[#FFFFFF] border border-[rgba(71,89,116,0.18)] shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-[#475974]">Total Pesan</span>
                    <span class="w-8 h-8 rounded-lg bg-[rgba(28,53,98,0.06)] border border-[rgba(71,89,116,0.16)] flex items-center justify-center text-[#1C3562]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </span>
                </div>
                <p class="text-2xl font-bold text-[#1C3562] mt-3">{{ $totalMessages }}</p>
                <p class="text-[11px] text-[#475974] mt-1">Seluruh pesan yang pernah dikirim</p>
            </div>

            <!-- Belum Dibaca -->
            <div class="p-5 rounded-xl bg-[#FFFFFF] border border-[rgba(71,89,116,0.18)] shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-[#4B531B]">Belum Dibaca</span>
                    <span class="w-8 h-8 rounded-lg bg-[rgba(160,170,84,0.15)] border border-[rgba(160,170,84,0.4)] flex items-center justify-center text-[#A0AA54]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                </div>
                <p class="text-2xl font-bold text-[#1C3562] mt-3">{{ $unreadCount }}</p>
                <p class="text-[11px] text-[#475974] mt-1">Memerlukan perhatian admin</p>
            </div>

            <!-- Sudah Dibaca -->
            <div class="p-5 rounded-xl bg-[#FFFFFF] border border-[rgba(71,89,116,0.18)] shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-[#475974]">Sudah Dibaca</span>
                    <span class="w-8 h-8 rounded-lg bg-[rgba(28,53,98,0.06)] border border-[rgba(71,89,116,0.16)] flex items-center justify-center text-[#1C3562]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <p class="text-2xl font-bold text-[#1C3562] mt-3">{{ $readCount }}</p>
                <p class="text-[11px] text-[#475974] mt-1">Telah diarsipkan &amp; ditinjau</p>
            </div>
        </div>

        <!-- Tabel / Daftar Pesan Masuk -->
        <div class="rounded-xl bg-[#FFFFFF] border border-[rgba(71,89,116,0.18)] overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-[rgba(71,89,116,0.16)] flex items-center justify-between bg-[#F1F4F9]">
                <div class="flex items-center gap-2.5">
                    <h2 class="text-sm font-semibold text-[#1C3562]">Daftar Pesan Masuk</h2>
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#FFFFFF] text-[#475974] border border-[rgba(71,89,116,0.2)]">
                        {{ $messages->count() }} pesan
                    </span>
                </div>
                <span class="text-[11px] text-[#475974]">Diurutkan dari yang terbaru</span>
            </div>

            @if ($messages->isEmpty())
                <!-- Tampilan Kosong -->
                <div class="py-16 px-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-[#F1F4F9] border border-[rgba(71,89,116,0.2)] flex items-center justify-center text-[#475974] mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-medium text-[#1C3562] mb-1">Belum ada pesan masuk</h3>
                    <p class="text-xs text-[#475974] max-w-sm mx-auto">
                        Pesan yang dikirim pengunjung melalui formulir "Hubungi kami" di halaman Landing akan tersimpan otomatis ke database MySQL <code class="text-[#1C3562]">studiomusik_web</code> dan tampil di tabel ini.
                    </p>
                </div>
            @else
                <!-- Tabel Desktop & Tablet -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-[#F1F4F9] text-[#475974] uppercase text-[10px] tracking-wider border-b border-[rgba(71,89,116,0.16)]">
                            <tr>
                                <th scope="col" class="py-3 px-6">Pengirim</th>
                                <th scope="col" class="py-3 px-6">Email</th>
                                <th scope="col" class="py-3 px-6">Isi Pesan</th>
                                <th scope="col" class="py-3 px-6 whitespace-nowrap">Waktu Dikirim</th>
                                <th scope="col" class="py-3 px-6 text-center">Status</th>
                                <th scope="col" class="py-3 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[rgba(71,89,116,0.12)]">
                            @foreach ($messages as $msg)
                                <tr class="hover:bg-[rgba(28,53,98,0.03)] transition {{ ! $msg->is_read ? 'bg-[rgba(160,170,84,0.05)]' : '' }}">
                                    <!-- Nama Pengirim -->
                                    <td class="py-4 px-6 font-medium text-[#1C3562] whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            @if (! $msg->is_read)
                                                <span class="w-2 h-2 rounded-full bg-[#A0AA54] shrink-0" title="Pesan baru"></span>
                                            @endif
                                            <span>{{ $msg->name }}</span>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td class="py-4 px-6 text-[#475974] whitespace-nowrap">
                                        <a href="mailto:{{ $msg->email }}" class="text-[#1C3562] hover:text-[#A0AA54] hover:underline">
                                            {{ $msg->email }}
                                        </a>
                                    </td>

                                    <!-- Isi Pesan -->
                                    <td class="py-4 px-6 text-[#1E293B] min-w-[280px] max-w-md">
                                        <div class="p-3 rounded-lg bg-[#F9FAFC] border border-[rgba(71,89,116,0.16)] text-xs text-[#1E293B] leading-relaxed whitespace-pre-line">
                                            {{ $msg->message }}
                                        </div>
                                    </td>

                                    <!-- Waktu Dikirim -->
                                    <td class="py-4 px-6 text-[#475974] whitespace-nowrap">
                                        <div>{{ $msg->created_at->format('d M Y, H:i') }}</div>
                                        <div class="text-[10px] text-[#475974]/80 mt-0.5">{{ $msg->created_at->diffForHumans() }}</div>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        @if ($msg->is_read)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-[#EEF2F6] text-[#475974] border border-[rgba(71,89,116,0.2)]">
                                                <svg class="w-3 h-3 text-[#A0AA54]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Sudah dibaca
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[rgba(160,170,84,0.15)] text-[#4B531B] border border-[rgba(160,170,84,0.4)]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#A0AA54]"></span>
                                                Belum dibaca
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Tombol Aksi -->
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            @if (! $msg->is_read)
                                                <!-- Tombol Tandai Sudah Dibaca (PATCH) -->
                                                <form action="{{ route('admin.messages.read', $msg) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            title="Tandai pesan sebagai sudah dibaca"
                                                            class="px-2.5 py-1.5 rounded-md bg-[#1C3562] hover:bg-[#15284B] text-[#F9FAFC] font-semibold text-xs transition cursor-pointer">
                                                        Tandai Sudah Dibaca
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Tombol Hapus (DELETE) -->
                                            <form action="{{ route('admin.messages.destroy', $msg) }}"
                                                  method="POST"
                                                  class="inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan dari {{ addslashes($msg->name) }}? Tindakan ini tidak dapat dibatalkan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Hapus pesan"
                                                        class="px-2.5 py-1.5 rounded-md bg-red-500/10 hover:bg-red-500/20 text-red-600 border border-red-500/30 font-medium text-xs transition cursor-pointer">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </main>

    <!-- ================= FOOTER ADMIN ================= -->
    <footer class="border-t border-[rgba(71,89,116,0.16)] bg-[#FFFFFF] py-6 text-xs text-[#475974]">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p>&copy; 2026 Studio Musik Positif &middot; Panel Administrasi</p>
            <div class="flex items-center gap-4 text-[11px]">
                <a href="{{ route('landing') }}" class="hover:text-[#1C3562] transition">Beranda Utama</a>
                <span>&middot;</span>
                <a href="{{ route('landing') }}#kontak" class="hover:text-[#1C3562] transition">Formulir Kontak</a>
            </div>
        </div>
    </footer>

</body>
</html>
