@extends('layouts.pelanggan')

@section('title', 'Ajukan Perpanjangan — Studio Musik Positif')

@section('page_css')
<style>
    /* Header Halaman */
    .ext-page-header {
        margin-bottom: 24px;
    }

    .ext-page-eyebrow {
        font-size: 11px;
        color: #737373;
        margin-bottom: 4px;
        letter-spacing: 0.02em;
    }

    .ext-page-h1 {
        font-family: 'Times New Roman', Times, Georgia, serif;
        font-size: 32px;
        font-weight: 400;
        color: #F5F5F5;
        line-height: 1.2;
        margin-bottom: 6px;
    }

    .ext-page-sub {
        font-size: 13px;
        color: #A3A3A3;
        line-height: 1.5;
    }

    /* Grid Utama 2 Kolom */
    .ext-main-grid {
        display: grid;
        grid-template-columns: 330px 1fr;
        gap: 20px;
        align-items: start;
    }

    /* KOLOM KIRI */
    .ext-col-left {
        display: flex;
        flex-direction: column;
    }

    .select-label {
        font-size: 12.5px;
        font-weight: 500;
        color: #F5F5F5;
        margin-bottom: 8px;
        display: block;
    }

    .form-select-dark {
        width: 100%;
        background: #1E1E1E;
        border: 1px solid #2A2A2A;
        border-radius: 7px;
        color: #F5F5F5;
        padding: 9px 12px;
        font-size: 13px;
        outline: none;
        transition: border-color 0.15s ease;
        margin-bottom: 14px;
    }

    .form-select-dark:focus {
        border-color: #F5A623;
    }

    .card-selected-res {
        background: #1A1A1A;
        border: 1px solid #262626;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    .card-selected-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 12px;
    }

    .card-title-serif {
        font-family: 'Times New Roman', Times, Georgia, serif;
        font-size: 19px;
        font-weight: 400;
        color: #F5F5F5;
    }

    .badge-status {
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

    .badge-status-green {
        color: #34D399;
        background: rgba(34, 197, 94, 0.14);
        border: 1px solid rgba(34, 197, 94, 0.25);
    }

    .badge-status-amber {
        color: #F5A623;
        background: rgba(245, 166, 35, 0.14);
        border: 1px solid rgba(245, 166, 35, 0.25);
    }

    .studio-notes-title {
        font-family: 'Times New Roman', Times, Georgia, serif;
        font-size: 20px;
        font-weight: 400;
        color: #F5F5F5;
        line-height: 1.25;
        margin-bottom: 6px;
    }

    .res-date-full {
        font-size: 13px;
        color: #D4D4D8;
        margin-bottom: 4px;
    }

    .res-time-hours {
        font-size: 13px;
        color: #A3A3A3;
        margin-bottom: 16px;
    }

    .card-divider {
        height: 1px;
        background: #262626;
        margin: 14px 0;
    }

    .price-line-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 12.5px;
    }

    .price-line-row:last-child {
        margin-bottom: 0;
    }

    .note-under-left-card {
        font-size: 12px;
        color: #737373;
        line-height: 1.5;
        margin-top: 12px;
    }

    /* KOLOM KANAN */
    .card-extension-form {
        background: #1A1A1A;
        border: 1px solid #262626;
        border-radius: 10px;
        padding: 24px;
    }

    .ext-form-title {
        font-family: 'Times New Roman', Times, Georgia, serif;
        font-size: 19px;
        font-weight: 400;
        color: #F5F5F5;
        margin-bottom: 18px;
    }

    .extra-time-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 16px 0 12px;
        font-size: 13px;
    }

    .btn-check-avail {
        background: #1A1A1A;
        border: 1px solid #3A3A3A;
        border-radius: 7px;
        padding: 9px 16px;
        color: #F5F5F5;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-check-avail:hover {
        border-color: #52525B;
        background: #242424;
    }

    /* Status Hasil Ketersediaan */
    .avail-result-wrap {
        margin-top: 14px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
    }

    .badge-avail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 3px 10px;
        font-size: 11px;
        font-weight: 500;
        line-height: 1.3;
    }

    .badge-avail-green {
        color: #34D399;
        background: rgba(34, 197, 94, 0.14);
        border: 1px solid rgba(34, 197, 94, 0.35);
    }

    .badge-avail-red {
        color: #F87171;
        background: rgba(239, 68, 68, 0.14);
        border: 1px solid rgba(239, 68, 68, 0.35);
    }

    .badge-avail-gray {
        color: #A3A3A3;
        background: #242424;
        border: 1px solid #383838;
    }

    .avail-text-desc {
        font-size: 12.5px;
        color: #D4D4D8;
        line-height: 1.45;
    }

    /* Rincian Biaya 3 Baris */
    .cost-summary-list {
        margin-top: 18px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .cost-summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
    }

    .form-textarea-dark {
        width: 100%;
        background: #1E1E1E;
        border: 1px solid #2A2A2A;
        border-radius: 7px;
        color: #F5F5F5;
        padding: 10px 12px;
        font-size: 13px;
        outline: none;
        resize: vertical;
        transition: border-color 0.15s ease;
    }

    .form-textarea-dark:focus {
        border-color: #F5A623;
    }

    .btn-submit-main {
        width: 100%;
        margin-top: 16px;
        background: #F5A623;
        color: #121212;
        font-weight: 600;
        padding: 11px;
        border-radius: 7px;
        border: none;
        font-size: 13.5px;
        cursor: pointer;
        transition: background 0.15s ease;
        text-align: center;
    }

    .btn-submit-main:hover {
        background: #E09416;
    }

    .btn-submit-main.btn-disabled {
        background: #222222 !important;
        border: 1px solid #2E2E2E !important;
        color: #8E8E93 !important;
        cursor: not-allowed !important;
    }

    .note-under-submit {
        font-size: 11.5px;
        color: #737373;
        margin-top: 10px;
    }

    /* KARTU BAWAH: INFORMASI PENTING!!! */
    .card-warning-bottom {
        margin-top: 20px;
        background: #1A1A1A;
        border: 1px solid rgba(239, 68, 68, 0.45);
        border-radius: 10px;
        padding: 20px 24px;
    }

    .warning-h2 {
        font-family: 'Times New Roman', Times, Georgia, serif;
        font-size: 19px;
        font-weight: 400;
        color: #F5F5F5;
        margin-bottom: 12px;
    }

    .badge-warning-sim {
        display: inline-block;
        background: rgba(239, 68, 68, 0.14);
        border: 1px solid rgba(239, 68, 68, 0.25);
        color: #F87171;
        border-radius: 999px;
        padding: 3px 10px;
        font-size: 11px;
        font-weight: 500;
    }

    .warning-para-1 {
        font-size: 13px;
        color: #E4E4E7;
        margin-top: 12px;
        line-height: 1.55;
    }

    .warning-para-2 {
        font-size: 13px;
        color: #D4D4D8;
        margin-top: 10px;
        line-height: 1.55;
    }

    .btn-warning-disabled {
        margin-top: 14px;
        background: #222222;
        border: 1px solid #2E2E2E;
        color: #8E8E93;
        padding: 9px 18px;
        border-radius: 7px;
        font-size: 13px;
        cursor: not-allowed;
        display: inline-block;
        user-select: none;
    }

    .warning-note-bottom {
        font-size: 12px;
        color: #737373;
        margin-top: 12px;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .ext-main-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    // Helper format tanggal Indonesia
    $formatIndoFull = function($dateStr) {
        if (!$dateStr) return '-';
        $days = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
        $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        $dt = \Carbon\Carbon::parse($dateStr);
        $dayName = $days[$dt->format('l')] ?? $dt->format('l');
        $monthName = $months[$dt->month] ?? $dt->format('F');
        return $dayName . ', ' . $dt->day . ' ' . $monthName . ' ' . $dt->year;
    };

    $selected = $selectedReservation;
    $hasSelected = $selected !== null;

    $selectedPrice = $hasSelected && $selected->studio ? (int) $selected->studio->price_per_hour : 70000;
    $selectedStart = $hasSelected ? $selected->start_time : '18.00';
    $selectedEnd = $hasSelected ? $selected->end_time : '20.00';
    $selectedDuration = $hasSelected ? $selected->duration_hours : 2;
    $selectedTotal = $hasSelected ? (int) $selected->total_price : 140000;

    // Hitung jam tambahan awal (+1 jam)
    $currEndH = (int) explode(':', str_replace('.', ':', $selectedEnd))[0];
    $initExtraEndH = min(24, $currEndH + 1);
    $initExtraRange = sprintf('%02d.00–%02d.00', $currEndH, $initExtraEndH);

    // Data simulasi kartu bawah
    $simRange = $simConflict['conflict_range'] ?? sprintf('%02d.00–%02d.00', $currEndH, min(24, $currEndH + 2));
    $simSlot = $simConflict['conflict_slot'] ?? sprintf('%02d.00–%02d.00', min(24, $currEndH + 1), min(24, $currEndH + 2));
    $simCode = $simConflict['conflict_code'] ?? 'Studio-002';
    $simHours = $simConflict['conflict_hours'] ?? 2;
    $simCalc = $simConflict['conflict_calc'] ?? ('2 × Rp' . number_format($selectedPrice, 0, ',', '.') . ' = Rp' . number_format($selectedPrice * 2, 0, ',', '.'));
    $simSafe = $simConflict['safe_range'] ?? sprintf('%02d.00–%02d.00', $currEndH, min(24, $currEndH + 1));
@endphp

<!-- ================= 1. HEADER HALAMAN ================= -->
<div class="ext-page-header">
    <div class="ext-page-eyebrow">Pelanggan / desktop</div>
    <h1 class="ext-page-h1">Ajukan perpanjangan</h1>
    <p class="ext-page-sub">
        Tambahkan waktu latihan pada reservasi aktif. Persetujuan mengikuti ketersediaan studio.
    </p>
</div>

<!-- ================= 2. GRID UTAMA 2 KOLOM (330px 1fr) ================= -->
<div class="ext-main-grid">

    <!-- ================= KOLOM KIRI: PILIH RESERVASI & KARTU TERPILIH ================= -->
    <div class="ext-col-left">
        <label for="reservationSelect" class="select-label">Pilih reservasi</label>

        <select id="reservationSelect" name="reservation_id" class="form-select-dark">
            @if ($eligibleReservations->isEmpty())
                <option value="" disabled selected>Belum ada jadwal latihan aktif</option>
            @else
                @foreach ($eligibleReservations as $res)
                    @php
                        $stClass = $res->status === 'dikonfirmasi' ? 'badge-status-green' : 'badge-status-amber';
                        $stText = $res->status === 'dikonfirmasi' ? 'dikonfirmasi' : 'menunggu bayar';
                        $priceH = $res->studio ? (int) $res->studio->price_per_hour : 70000;
                    @endphp
                    <option value="{{ $res->id }}"
                            data-code="{{ $res->booking_code }}"
                            data-status="{{ $stText }}"
                            data-status-class="{{ $stClass }}"
                            data-studio-name="{{ $res->studio?->name ?? 'Studio Musik' }}"
                            data-notes="{{ $res->notes ? ' · ' . $res->notes : '' }}"
                            data-date-full="{{ $formatIndoFull($res->reservation_date) }}"
                            data-start="{{ $res->start_time }}"
                            data-end="{{ $res->end_time }}"
                            data-duration="{{ $res->duration_hours }}"
                            data-price-per-hour="{{ $priceH }}"
                            data-payment-status="{{ $res->payment_status === 'lunas' ? 'lunas' : 'belum bayar' }}"
                            data-total-price="{{ $res->total_price }}"
                            {{ ($selected && $selected->id === $res->id) ? 'selected' : '' }}>
                        {{ $res->booking_code }} &middot; {{ $res->studio?->name ?? 'Studio' }}
                    </option>
                @endforeach
            @endif
        </select>

        <!-- Kartu Reservasi Terpilih -->
        <div class="card-selected-res">
            <div class="card-selected-header">
                <h2 class="card-title-serif">Reservasi terpilih</h2>
                <span id="cardBadge" class="badge-status {{ $hasSelected && $selected->status === 'dikonfirmasi' ? 'badge-status-green' : 'badge-status-amber' }}">
                    <span id="cardBadgeText">
                        @if ($hasSelected)
                            {{ $selected->booking_code }} &middot; {{ $selected->status === 'dikonfirmasi' ? 'dikonfirmasi' : 'menunggu bayar' }}
                        @else
                            - &middot; menunggu bayar
                        @endif
                    </span>
                </span>
            </div>

            <!-- Judul Studio & Catatan -->
            <h3 id="cardStudioNotes" class="studio-notes-title">
                @if ($hasSelected)
                    {{ $selected->studio?->name ?? 'Studio Musik' }}{{ $selected->notes ? ' · ' . $selected->notes : '' }}
                @else
                    Studio Musik
                @endif
            </h3>

            <!-- Tanggal Lengkap Format Indonesia -->
            <div id="cardDateText" class="res-date-full">
                {{ $hasSelected ? $formatIndoFull($selected->reservation_date) : '-' }}
            </div>

            <!-- Jam & Durasi Awal -->
            <div id="cardTimeDurationText" class="res-time-hours">
                @if ($hasSelected)
                    {{ $selected->start_time }}–{{ $selected->end_time }} &middot; {{ $selected->duration_hours }} jam
                @else
                    -–- &middot; - jam
                @endif
            </div>

            <div class="card-divider"></div>

            <!-- Baris Rincian Harga -->
            <div class="price-line-row">
                <span style="color: #A3A3A3;">Tarif per jam</span>
                <span id="cardPricePerHour" style="color: #F5F5F5;">
                    Rp{{ number_format($hasSelected ? $selectedPrice : 0, 0, ',', '.') }}
                </span>
            </div>

            <div class="price-line-row">
                <span id="cardPaymentLabel" style="color: #F5F5F5;">
                    Biaya awal &middot; {{ $hasSelected ? ($selected->payment_status === 'lunas' ? 'lunas' : 'belum bayar') : 'belum bayar' }}
                </span>
                <span id="cardInitialCost" style="color: #F5F5F5; font-weight: 600;">
                    Rp{{ number_format($hasSelected ? $selectedTotal : 0, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Teks Catatan di Bawah Kartu Kiri -->
        <p class="note-under-left-card">
            Biaya awal tetap <span id="noteInitialCost">Rp{{ number_format($hasSelected ? $selectedTotal : 0, 0, ',', '.') }}</span>. Pengajuan belum mengubah reservasi atau tagihan.
        </p>

        @if (!$hasSelected)
            <div style="font-size: 11.5px; color: #737373; margin-top: 8px;">
                Belum memiliki reservasi? <a href="{{ route('reservations.create') }}" style="color: #F5A623; text-decoration: underline;">Buat reservasi baru</a>
            </div>
        @endif
    </div>

    <!-- ================= KOLOM KANAN: KARTU PENGAJUAN SAAT INI ================= -->
    <div class="card-extension-form">
        <h2 class="ext-form-title">
            Pengajuan saat ini &middot; tambah <span id="titleExtraHours">1</span> jam
        </h2>

        <form method="POST" action="{{ route('extensions.store') }}" id="extensionForm">
            @csrf
            <input type="hidden" name="reservation_id" id="hiddenReservationId" value="{{ $selected?->id }}">

            <!-- Label & Dropdown Tambahan Durasi -->
            <label for="extraHoursSelect" class="select-label">Tambahan durasi</label>
            <select name="extra_hours" id="extraHoursSelect" class="form-select-dark">
                <option value="1" {{ old('extra_hours', '1') == '1' ? 'selected' : '' }}>
                    1 jam &middot; Rp{{ number_format($selectedPrice * 1, 0, ',', '.') }}
                </option>
                <option value="2" {{ old('extra_hours') == '2' ? 'selected' : '' }}>
                    2 jam &middot; Rp{{ number_format($selectedPrice * 2, 0, ',', '.') }}
                </option>
                <option value="3" {{ old('extra_hours') == '3' ? 'selected' : '' }}>
                    3 jam &middot; Rp{{ number_format($selectedPrice * 3, 0, ',', '.') }}
                </option>
            </select>

            <!-- Baris Info Jam Tambahan -->
            <div class="extra-time-info-row">
                <span style="color: #A3A3A3;">Jam tambahan</span>
                <span id="extraTimeDisplay" style="color: #F5F5F5; font-weight: 500;">
                    {{ $hasSelected ? $initExtraRange : '20.00–21.00' }}
                </span>
            </div>

            <!-- Tombol Cek Ketersediaan -->
            <button type="button" id="btnCheckAvailability" class="btn-check-avail">
                Cek ketersediaan
            </button>

            <!-- Status Hasil Ketersediaan -->
            <div class="avail-result-wrap">
                <span id="availBadge" class="badge-avail badge-avail-green">
                    Tersedia &middot; <span id="availBadgeRange">{{ $hasSelected ? $initExtraRange : '20.00–21.00' }}</span>
                </span>
                <div id="availExplanation" class="avail-text-desc">
                    {{ $hasSelected ? ($selected->studio?->name ?? 'Studio') : 'Studio A' }} kosong pada jam tambahan yang dipilih.
                </div>
            </div>

            <div class="card-divider" style="margin: 18px 0 14px;"></div>

            <!-- Rincian Biaya 3 Baris -->
            <div class="cost-summary-list">
                <div class="cost-summary-row">
                    <span style="color: #A3A3A3;">Biaya awal</span>
                    <span id="summaryInitialCost" style="color: #F5F5F5;">
                        Rp{{ number_format($hasSelected ? $selectedTotal : 0, 0, ',', '.') }}
                    </span>
                </div>

                <div class="cost-summary-row">
                    <span style="color: #A3A3A3;">
                        Biaya tambahan &middot; <span id="summaryExtraHours">1</span> jam
                    </span>
                    <span id="summaryExtraCost" style="color: #F5F5F5;">
                        Rp{{ number_format($selectedPrice * 1, 0, ',', '.') }}
                    </span>
                </div>

                <div class="cost-summary-row">
                    <span style="color: #F5F5F5; font-weight: 600;">Total jika disetujui</span>
                    <span id="summaryGrandTotal" style="color: #F5F5F5; font-weight: 600;">
                        Rp{{ number_format(($hasSelected ? $selectedTotal : 0) + ($selectedPrice * 1), 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- Alasan (Opsional) -->
            <label for="reasonInput" class="select-label" style="margin-top: 18px;">
                Alasan (opsional)
            </label>
            <textarea name="reason" id="reasonInput" rows="3" class="form-textarea-dark"
                      placeholder="Butuh waktu untuk satu lagu tambahan">{{ old('reason') }}</textarea>

            <!-- Tombol Submit Lebar Penuh -->
            <button type="submit" id="btnSubmitExtension"
                    class="btn-submit-main {{ !$hasSelected ? 'btn-disabled' : '' }}"
                    {{ !$hasSelected ? 'disabled' : '' }}>
                {{ $hasSelected ? 'Ajukan perpanjangan' : 'Tidak dapat diajukan' }}
            </button>

            <!-- Teks Catatan Bawah Tombol -->
            <p class="note-under-submit">
                Admin akan meninjau pengajuan. Bayar biaya tambahan setelah disetujui.
            </p>
        </form>
    </div>
</div>

<!-- ================= 3. KARTU BAWAH LEBAR PENUH (INFORMASI PENTING!!!) ================= -->
<div class="card-warning-bottom">
    <h2 class="warning-h2">Informasi penting!!!</h2>

    <!-- Pill Badge Merah/Marun -->
    <div>
        <span id="simBadgeText" class="badge-warning-sim">
            Bentrok &middot; simulasi tambah 2 jam
        </span>
    </div>

    <!-- Paragraf 1 -->
    <p class="warning-para-1">
        Jika memilih <span id="simConflictRange">{{ $simRange }}</span>, tapi slot <span id="simConflictSlot">{{ $simSlot }}</span> telah dipesan untuk <span id="simConflictCode">{{ $simCode }}</span>. Pengajuan <span id="simConflictHours">{{ $simHours }}</span> jam tidak dapat dikirim.
    </p>

    <!-- Paragraf 2 -->
    <p class="warning-para-2">
        Biaya simulasi: <span id="simCalcText">{{ $simCalc }}</span>. Tidak ditambahkan ke tagihan.
    </p>

    <!-- Tombol Indikator Gelap Non-Aktif -->
    <div>
        <span class="btn-warning-disabled">
            Tidak dapat diajukan
        </span>
    </div>

    <!-- Teks Catatan Bawah -->
    <p class="warning-note-bottom">
        Pilih tambahan 1 jam (<span id="simSafeRange">{{ $simSafe }}</span>) agar tidak bentrok. Kedua kondisi ini adalah pilihan durasi yang berbeda.
    </p>
</div>
@endsection

@section('page_js')
<script>
    function formatRupiah(number) {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
    }

    function calculateTimeRange(startStr, addHours) {
        if (!startStr) return '20.00–21.00';
        const startH = parseInt(startStr.replace('.', ':').split(':')[0], 10);
        const endH = Math.min(24, startH + addHours);
        const sFormatted = String(startH).padStart(2, '0') + '.00';
        const eFormatted = String(endH).padStart(2, '0') + '.00';
        return `${sFormatted}–${eFormatted}`;
    }

    function getSelectedOption() {
        const select = document.getElementById('reservationSelect');
        if (!select || !select.value) return null;
        return select.options[select.selectedIndex];
    }

    function updateLeftCardAndDurations() {
        const option = getSelectedOption();
        const hiddenId = document.getElementById('hiddenReservationId');
        const extraHoursSelect = document.getElementById('extraHoursSelect');

        if (!option) {
            if (hiddenId) hiddenId.value = '';
            return;
        }

        const id = option.value;
        const code = option.getAttribute('data-code');
        const status = option.getAttribute('data-status');
        const statusClass = option.getAttribute('data-status-class');
        const studioName = option.getAttribute('data-studio-name');
        const notes = option.getAttribute('data-notes');
        const dateFull = option.getAttribute('data-date-full');
        const start = option.getAttribute('data-start');
        const end = option.getAttribute('data-end');
        const duration = option.getAttribute('data-duration');
        const pricePerHour = parseInt(option.getAttribute('data-price-per-hour'), 10) || 70000;
        const paymentStatus = option.getAttribute('data-payment-status');
        const totalPrice = parseInt(option.getAttribute('data-total-price'), 10) || 0;

        if (hiddenId) hiddenId.value = id;

        // Perbarui elemen kartu kiri
        const cardBadge = document.getElementById('cardBadge');
        if (cardBadge) {
            cardBadge.className = 'badge-status ' + statusClass;
            document.getElementById('cardBadgeText').textContent = code + ' · ' + status;
        }

        document.getElementById('cardStudioNotes').textContent = studioName + notes;
        document.getElementById('cardDateText').textContent = dateFull;
        document.getElementById('cardTimeDurationText').textContent = `${start}–${end} · ${duration} jam`;
        document.getElementById('cardPricePerHour').textContent = formatRupiah(pricePerHour);
        document.getElementById('cardPaymentLabel').textContent = `Biaya awal · ${paymentStatus}`;
        document.getElementById('cardInitialCost').textContent = formatRupiah(totalPrice);
        document.getElementById('noteInitialCost').textContent = formatRupiah(totalPrice);

        // Perbarui opsi dropdown durasi tambahan
        const currentHours = extraHoursSelect ? extraHoursSelect.value : '1';
        if (extraHoursSelect) {
            extraHoursSelect.innerHTML = `
                <option value="1" ${currentHours === '1' ? 'selected' : ''}>1 jam · ${formatRupiah(pricePerHour * 1)}</option>
                <option value="2" ${currentHours === '2' ? 'selected' : ''}>2 jam · ${formatRupiah(pricePerHour * 2)}</option>
                <option value="3" ${currentHours === '3' ? 'selected' : ''}>3 jam · ${formatRupiah(pricePerHour * 3)}</option>
            `;
        }

        // Perbarui simulasi kartu bawah secara dinamis
        const endH = parseInt(end.replace('.', ':').split(':')[0], 10);
        const sim1H = Math.min(24, endH + 1);
        const sim2H = Math.min(24, endH + 2);

        document.getElementById('simConflictRange').textContent = `${String(endH).padStart(2, '0')}.00–${String(sim2H).padStart(2, '0')}.00`;
        document.getElementById('simConflictSlot').textContent = `${String(sim1H).padStart(2, '0')}.00–${String(sim2H).padStart(2, '0')}.00`;
        document.getElementById('simSafeRange').textContent = `${String(endH).padStart(2, '0')}.00–${String(sim1H).padStart(2, '0')}.00`;
        document.getElementById('simCalcText').textContent = `2 × ${formatRupiah(pricePerHour)} = ${formatRupiah(pricePerHour * 2)}`;

        // Jalankan pengecekan ketersediaan
        checkAvailability();
    }

    async function checkAvailability() {
        const option = getSelectedOption();
        const extraHoursSelect = document.getElementById('extraHoursSelect');
        const extraHours = extraHoursSelect ? parseInt(extraHoursSelect.value, 10) : 1;

        document.getElementById('titleExtraHours').textContent = extraHours;
        document.getElementById('summaryExtraHours').textContent = extraHours;

        if (!option) {
            // Mode aman jika belum ada reservasi aktif
            const badge = document.getElementById('availBadge');
            badge.className = 'badge-avail badge-avail-gray';
            badge.textContent = 'Belum ada jadwal aktif';
            document.getElementById('availExplanation').textContent = 'Buat reservasi latihan terlebih dahulu untuk mengajukan perpanjangan.';
            const btnSubmit = document.getElementById('btnSubmitExtension');
            btnSubmit.className = 'btn-submit-main btn-disabled';
            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Tidak dapat diajukan';
            return;
        }

        const resId = option.value;
        const studioName = option.getAttribute('data-studio-name');
        const end = option.getAttribute('data-end');
        const pricePerHour = parseInt(option.getAttribute('data-price-per-hour'), 10) || 70000;
        const initialCost = parseInt(option.getAttribute('data-total-price'), 10) || 0;

        // Estimasi jam tambahan di tampilan sebelum fetch selesai
        const expectedRange = calculateTimeRange(end, extraHours);
        document.getElementById('extraTimeDisplay').textContent = expectedRange;

        const badge = document.getElementById('availBadge');
        const explanation = document.getElementById('availExplanation');
        const btnSubmit = document.getElementById('btnSubmitExtension');

        badge.className = 'badge-avail badge-avail-gray';
        badge.textContent = 'Memeriksa ketersediaan...';

        try {
            const res = await fetch(`/extensions/check-availability?reservation_id=${resId}&extra_hours=${extraHours}`);
            const data = await res.json();

            const extraRange = data.extra_range || expectedRange;
            document.getElementById('extraTimeDisplay').textContent = extraRange;

            // Rincian Biaya
            const extraCost = data.extra_cost || (extraHours * pricePerHour);
            const totalCost = data.total_cost || (initialCost + extraCost);

            document.getElementById('summaryInitialCost').textContent = formatRupiah(data.initial_cost || initialCost);
            document.getElementById('summaryExtraCost').textContent = formatRupiah(extraCost);
            document.getElementById('summaryGrandTotal').textContent = formatRupiah(totalCost);

            if (data.available) {
                badge.className = 'badge-avail badge-avail-green';
                badge.textContent = `Tersedia · ${extraRange}`;
                explanation.textContent = `${data.studio_name || studioName} kosong pada jam tambahan yang dipilih.`;

                btnSubmit.className = 'btn-submit-main';
                btnSubmit.disabled = false;
                btnSubmit.textContent = 'Ajukan perpanjangan';
            } else {
                badge.className = 'badge-avail badge-avail-red';
                badge.textContent = `Bentrok · ${extraRange}`;
                explanation.textContent = data.conflict_details || `${data.studio_name || studioName} telah dipesan musisi lain pada jam tersebut.`;

                btnSubmit.className = 'btn-submit-main btn-disabled';
                btnSubmit.disabled = true;
                btnSubmit.textContent = 'Tidak dapat diajukan';
            }

            // Hubungkan info konflik real di kartu bawah jika ada
            if (data.conflict_code && data.conflict_slot) {
                document.getElementById('simConflictCode').textContent = data.conflict_code;
                document.getElementById('simConflictSlot').textContent = data.conflict_slot;
            }
        } catch (err) {
            console.error('Error checking availability:', err);
            badge.className = 'badge-avail badge-avail-red';
            badge.textContent = 'Gagal memeriksa koneksi';
            explanation.textContent = 'Periksa koneksi internetmu atau coba lagi sesaat lagi.';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const resSelect = document.getElementById('reservationSelect');
        const extraSelect = document.getElementById('extraHoursSelect');
        const btnCheck = document.getElementById('btnCheckAvailability');

        if (resSelect) {
            resSelect.addEventListener('change', updateLeftCardAndDurations);
        }

        if (extraSelect) {
            extraSelect.addEventListener('change', checkAvailability);
        }

        if (btnCheck) {
            btnCheck.addEventListener('click', checkAvailability);
        }

        // Inisialisasi awal saat halaman dimuat
        updateLeftCardAndDurations();
    });
</script>
@endsection
