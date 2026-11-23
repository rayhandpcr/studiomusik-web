@extends('layouts.pelanggan')

@section('title', 'Reservasi Baru — Studio Musik Positif')

@section('page_css')
<style>
    /* Stepper */
    .stepper {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        margin-top: 10px;
    }

    .step-item {
        color: #737373;
        font-weight: 400;
    }

    .step-item.active {
        color: #F5F5F5;
        font-weight: 600;
    }

    .step-arrow {
        color: #52525B;
        font-size: 12px;
    }

    /* Grid Form 2 Kolom (1.7fr 1fr) */
    .res-grid {
        display: grid;
        grid-template-columns: 1.7fr 1fr;
        gap: 20px;
        align-items: flex-start;
        margin-top: 24px;
    }

    .left-col {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Dropdown Studio */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 20px;
    }

    .form-label {
        font-size: 12.5px;
        font-weight: 500;
        color: #F5F5F5;
    }

    .select-custom {
        width: 100%;
        background: #1E1E1E;
        border: 1px solid #2A2A2A;
        border-radius: 8px;
        padding: 11px 14px;
        color: #F5F5F5;
        font-size: 13.5px;
        outline: none;
        cursor: pointer;
        transition: border-color 0.15s ease;
    }

    .select-custom:focus {
        border-color: #F5A623;
    }

    /* Kalender Bulanan Interaktif */
    .calendar-box {
        background: #161616;
        border: 1px solid #262626;
        border-radius: 8px;
        padding: 16px;
    }

    .cal-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .cal-title {
        font-size: 14.5px;
        font-weight: 600;
        color: #F5F5F5;
    }

    .cal-btn {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: #1E1E1E;
        border: 1px solid #2A2A2A;
        color: #A3A3A3;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .cal-btn:hover {
        border-color: #F5A623;
        color: #FFFFFF;
    }

    .cal-grid-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
        text-align: center;
        margin-bottom: 6px;
    }

    .cal-day-head {
        font-size: 11px;
        font-weight: 600;
        color: #737373;
        padding: 4px 0;
    }

    .cal-grid-dates {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
    }

    .cal-date-btn {
        aspect-ratio: 1;
        background: #1E1E1E;
        border: 1px solid #2A2A2A;
        border-radius: 6px;
        color: #E4E4E7;
        font-size: 12.5px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .cal-date-btn:hover:not(:disabled) {
        border-color: #F5A623;
        color: #FFFFFF;
    }

    .cal-date-btn.selected {
        background: #F5A623 !important;
        border-color: #F5A623 !important;
        color: #121212 !important;
        font-weight: 700;
    }

    .cal-date-btn:disabled {
        opacity: 0.25;
        cursor: not-allowed;
        background: #141414;
        border-color: #1F1F1F;
    }

    .cal-footnote {
        margin-top: 14px;
        font-size: 12px;
        color: #8E8E93;
    }

    .cal-footnote strong {
        color: #F5F5F5;
    }

    /* Grid Slot Jam */
    .slots-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 8px;
        margin-bottom: 16px;
    }

    .slot-card {
        background: #1E1E1E;
        border: 1px solid #2A2A2A;
        border-radius: 8px;
        padding: 10px 6px;
        text-align: center;
        display: flex;
        flex-direction: column;
        gap: 2px;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
    }

    .slot-card:hover:not(.is-booked) {
        border-color: #F5A623;
    }

    .slot-card.is-booked {
        background: #2C2C2C;
        border-color: #363636;
        cursor: not-allowed;
    }

    .slot-card.is-booked .slot-time,
    .slot-card.is-booked .slot-status {
        color: #737373 !important;
    }

    .slot-card.is-selected {
        background: #F5A623 !important;
        border-color: #F5A623 !important;
    }

    .slot-card.is-selected .slot-time,
    .slot-card.is-selected .slot-status {
        color: #121212 !important;
        font-weight: 600;
    }

    .slot-time {
        font-size: 13px;
        font-weight: 600;
        color: #F5F5F5;
    }

    .slot-status {
        font-size: 10.5px;
        color: #8E8E93;
    }

    .legend-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 10px;
        margin-bottom: 18px;
        font-size: 11.5px;
        color: #8E8E93;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .legend-box {
        width: 14px;
        height: 14px;
        border-radius: 3px;
    }

    .legend-box.avail {
        background: #1E1E1E;
        border: 1px solid #2A2A2A;
    }

    .legend-box.booked {
        background: #2C2C2C;
        border: 1px solid #363636;
    }

    .legend-box.selected {
        background: #F5A623;
        border: 1px solid #F5A623;
    }

    .slot-summary-box {
        background: #161616;
        border: 1px dashed #2E2E2E;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 12.5px;
        color: #8E8E93;
        margin-bottom: 16px;
    }

    .slot-summary-box strong {
        color: #F5A623;
    }

    .input-text {
        width: 100%;
        background: #1E1E1E;
        border: 1px solid #2A2A2A;
        border-radius: 8px;
        padding: 10px 14px;
        color: #F5F5F5;
        font-size: 13px;
        outline: none;
    }

    .input-text:focus {
        border-color: #F5A623;
    }

    /* Kolom Kanan: Ringkasan Biaya */
    .summary-card {
        background: #1A1A1A;
        border: 1px solid #262626;
        border-radius: 10px;
        padding: 24px;
        position: sticky;
        top: 88px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .summary-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .summary-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
    }

    .summary-label {
        color: #8E8E93;
    }

    .summary-val {
        color: #F5F5F5;
        font-weight: 500;
    }

    .summary-divider {
        height: 1px;
        background: #262626;
        margin: 4px 0;
    }

    .summary-total-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
    }

    .summary-total-label {
        color: #F5F5F5;
        font-weight: 600;
    }

    .summary-total-val {
        font-size: 18px;
        font-weight: 700;
        color: #F5A623;
    }

    .summary-note {
        font-size: 11.5px;
        color: #737373;
        line-height: 1.5;
    }

    .terms-label {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 12px;
        color: #A3A3A3;
        cursor: pointer;
        user-select: none;
        line-height: 1.4;
    }

    .terms-label input {
        margin-top: 2px;
        accent-color: #F5A623;
    }

    .summary-foot-note {
        font-size: 11px;
        color: #737373;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 960px) {
        .res-grid {
            grid-template-columns: 1fr;
        }

        .slots-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .summary-card {
            position: relative;
            top: 0;
        }
    }
</style>
@endsection

@section('content')
<!-- Header Halaman -->
<div class="page-header">
    <div class="page-eyebrow">Pelanggan / desktop</div>
    <h1 class="page-h1 font-serif">Reservasi baru</h1>
    <p class="page-subtitle">
        Pilih studio, tanggal, dan slot jam untuk sesi latihanmu.
    </p>

    <!-- Indikator Langkah (Stepper) -->
    <div class="stepper">
        <span class="step-item active">1. Pilih jadwal</span>
        <span class="step-arrow">&rarr;</span>
        <span class="step-item">2. Konfirmasi</span>
        <span class="step-arrow">&rarr;</span>
        <span class="step-item">3. Pembayaran</span>
    </div>
</div>

<form method="POST" action="{{ route('reservations.store') }}" id="resForm">
    @csrf

    <!-- Hidden Fields -->
    <input type="hidden" name="reservation_date" id="inputReservationDate" value="{{ old('reservation_date', date('Y-m-d')) }}">
    <input type="hidden" name="slots" id="inputSlots" value="{{ old('slots') ? (is_array(old('slots')) ? json_encode(old('slots')) : old('slots')) : '[]' }}">

    <div class="res-grid">
        <!-- ================= KOLOM KIRI ================= -->
        <div class="left-col">
            <!-- Kartu 1: Pilih Studio & Tanggal -->
            <div class="card">
                <h2 class="card-h2 font-serif">Pilih studio &amp; tanggal</h2>
                <div class="card-sub">Tentukan ruang studio dan tanggal bermain bandmu.</div>

                <div class="form-group">
                    <label class="form-label" for="studioSelect">Studio</label>
                    <select name="studio_id" id="studioSelect" class="select-custom" onchange="onStudioChange()">
                        @foreach ($studios as $studio)
                            <option value="{{ $studio->id }}"
                                data-price="{{ (int) $studio->price_per_hour }}"
                                data-name="{{ $studio->name }}"
                                {{ old('studio_id', $defaultStudioId) == $studio->id ? 'selected' : '' }}>
                                {{ $studio->name }} &middot; Rp{{ number_format($studio->price_per_hour, 0, ',', '.') }} / jam
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kalender Bulanan Interaktif -->
                <div class="calendar-box">
                    <div class="cal-nav">
                        <button type="button" class="cal-btn" onclick="prevMonth()">&lsaquo;</button>
                        <span class="cal-title" id="calMonthTitle">November 2026</span>
                        <button type="button" class="cal-btn" onclick="nextMonth()">&rsaquo;</button>
                    </div>

                    <div class="cal-grid-days">
                        <span class="cal-day-head">Sen</span>
                        <span class="cal-day-head">Sel</span>
                        <span class="cal-day-head">Rab</span>
                        <span class="cal-day-head">Kam</span>
                        <span class="cal-day-head">Jum</span>
                        <span class="cal-day-head">Sab</span>
                        <span class="cal-day-head">Min</span>
                    </div>

                    <div class="cal-grid-dates" id="calDatesGrid">
                        <!-- Kotak tanggal digenerate dinamis via JS -->
                    </div>

                    <div class="cal-footnote">
                        Dipilih: <strong id="selectedDateText">Senin, 16 November 2026</strong>
                    </div>
                </div>
            </div>

            <!-- Kartu 2: Pilih Slot Jam -->
            <div class="card">
                <h2 class="card-h2 font-serif">Pilih slot jam</h2>
                <div class="card-sub">
                    <span id="slotDateText">16 November 2026</span> &middot; setiap slot berdurasi 1 jam.
                </div>

                <!-- Grid Slot Jam (10.00 - 22.00) -->
                <div class="slots-grid" id="slotsContainer">
                    @php
                        $availableSlots = [
                            '10.00', '11.00', '12.00',
                            '13.00', '14.00', '15.00',
                            '16.00', '17.00', '18.00',
                            '19.00', '20.00', '21.00', '22.00'
                        ];
                    @endphp

                    @foreach ($availableSlots as $slot)
                        <div class="slot-card" data-slot="{{ $slot }}" onclick="toggleSlot('{{ $slot }}')">
                            <span class="slot-time">{{ $slot }}</span>
                            <span class="slot-status">Tersedia</span>
                        </div>
                    @endforeach
                </div>

                <!-- Legenda Status -->
                <div class="legend-row">
                    <div class="legend-item">
                        <div class="legend-box avail"></div>
                        <span>Tersedia</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box booked"></div>
                        <span>Terisi</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box selected"></div>
                        <span>Dipilih</span>
                    </div>
                </div>

                <!-- Ringkasan Jam Terpilih -->
                <div class="slot-summary-box">
                    Dipilih: <strong id="slotSummaryText">Belum ada slot jam yang dipilih</strong>
                </div>

                <!-- Catatan Opsional -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="notesInput">Catatan (opsional)</label>
                    <input type="text" name="notes" id="notesInput" class="input-text"
                        placeholder="Latihan band &middot; 4 orang"
                        value="{{ old('notes') }}">
                </div>
            </div>
        </div>

        <!-- ================= KOLOM KANAN: RINGKASAN BIAYA ================= -->
        <div class="summary-card">
            <h2 class="card-h2 font-serif">Ringkasan biaya</h2>

            <div class="summary-list">
                <div class="summary-item">
                    <span class="summary-label">Studio</span>
                    <span class="summary-val" id="sumStudioName">Studio A</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Tanggal</span>
                    <span class="summary-val" id="sumDate">16 Nov 2026</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Jam</span>
                    <span class="summary-val" id="sumTime">-</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Tarif / jam</span>
                    <span class="summary-val" id="sumRate">Rp70.000</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Durasi</span>
                    <span class="summary-val" id="sumDuration">0 jam</span>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-total-row">
                    <span class="summary-total-label">Total biaya</span>
                    <span class="summary-total-val" id="sumTotal">Rp0</span>
                </div>
            </div>

            <p class="summary-note">
                Harga termasuk peralatan standar. Tidak ada biaya layanan.
            </p>

            <label class="terms-label">
                <input type="checkbox" name="agree_terms" id="agreeTerms" value="1" required>
                <span>Saya menyetujui ketentuan reservasi.</span>
            </label>

            <button type="submit" class="btn-amber" id="btnSubmit">
                Konfirmasi reservasi
            </button>

            <p class="summary-foot-note">
                Pembayaran dilakukan setelah reservasi dibuat.
            </p>
        </div>
    </div>
</form>
@endsection

@section('page_js')
<script>
    // State Aplikasi Reservasi
    let currentCalYear = 2026;
    let currentCalMonth = 11; // 1-indexed (November = 11)
    let selectedDate = '{{ old("reservation_date", date("Y-m-d")) }}';
    let selectedSlots = [];
    let bookedSlots = [];

    const monthNames = [
        "", "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    const monthShortNames = [
        "", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
        "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
    ];
    const dayNames = [
        "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
    ];

    document.addEventListener('DOMContentLoaded', () => {
        // Inisialisasi tanggal kalender dari selectedDate
        const d = new Date(selectedDate);
        if (!isNaN(d.getTime())) {
            currentCalYear = d.getFullYear();
            currentCalMonth = d.getMonth() + 1;
        }

        // Pulihkan slots jika ada input lama
        try {
            const oldSlotsVal = document.getElementById('inputSlots').value;
            if (oldSlotsVal && oldSlotsVal !== '[]') {
                selectedSlots = JSON.parse(oldSlotsVal);
            }
        } catch (e) {}

        renderCalendar();
        onStudioChange();
    });

    // Render Kalender Bulanan
    function renderCalendar() {
        document.getElementById('calMonthTitle').textContent = `${monthNames[currentCalMonth]} ${currentCalYear}`;

        const firstDayOfMonth = new Date(currentCalYear, currentCalMonth - 1, 1);
        const daysInMonth = new Date(currentCalYear, currentCalMonth, 0).getDate();

        // Hari dalam seminggu: 0=Minggu, 1=Senin ... ubah agar 0=Senin, 6=Minggu
        let startDay = firstDayOfMonth.getDay() - 1;
        if (startDay < 0) startDay = 6;

        const grid = document.getElementById('calDatesGrid');
        grid.innerHTML = '';

        // Padding hari sebelum awal bulan
        for (let i = 0; i < startDay; i++) {
            const pad = document.createElement('div');
            grid.appendChild(pad);
        }

        const todayStr = new Date().toISOString().split('T')[0];

        // Buat tombol tanggal
        for (let day = 1; day <= daysInMonth; day++) {
            const dateStr = `${currentCalYear}-${String(currentCalMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'cal-date-btn';
            btn.textContent = day;

            if (dateStr === selectedDate) {
                btn.classList.add('selected');
            }

            if (dateStr < todayStr) {
                btn.disabled = true;
            }

            btn.onclick = () => selectDate(dateStr);
            grid.appendChild(btn);
        }

        updateDateDisplay();
    }

    function prevMonth() {
        currentCalMonth--;
        if (currentCalMonth < 1) {
            currentCalMonth = 12;
            currentCalYear--;
        }
        renderCalendar();
    }

    function nextMonth() {
        currentCalMonth++;
        if (currentCalMonth > 12) {
            currentCalMonth = 1;
            currentCalYear++;
        }
        renderCalendar();
    }

    function selectDate(dateStr) {
        selectedDate = dateStr;
        document.getElementById('inputReservationDate').value = dateStr;
        selectedSlots = [];
        document.getElementById('inputSlots').value = '[]';

        renderCalendar();
        updateDateDisplay();
        fetchBookedSlots();
    }

    function updateDateDisplay() {
        const d = new Date(selectedDate);
        if (isNaN(d.getTime())) return;

        const dayName = dayNames[d.getDay()];
        const dayNum = d.getDate();
        const mName = monthNames[d.getMonth() + 1];
        const mShort = monthShortNames[d.getMonth() + 1];
        const year = d.getFullYear();

        document.getElementById('selectedDateText').textContent = `${dayName}, ${dayNum} ${mName} ${year}`;
        document.getElementById('slotDateText').textContent = `${dayNum} ${mName} ${year}`;
        document.getElementById('sumDate').textContent = `${dayNum} ${mShort} ${year}`;
    }

    // Ganti Studio
    function onStudioChange() {
        const select = document.getElementById('studioSelect');
        const selectedOpt = select.options[select.selectedIndex];
        const studioName = selectedOpt.getAttribute('data-name');
        const rate = parseInt(selectedOpt.getAttribute('data-price')) || 70000;

        document.getElementById('sumStudioName').textContent = studioName;
        document.getElementById('sumRate').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(rate);

        fetchBookedSlots();
    }

    // Ambil Data Slot Terisi dari Database via Endpoint JSON
    function fetchBookedSlots() {
        const studioId = document.getElementById('studioSelect').value;
        const date = selectedDate;

        fetch(`{{ route('reservations.booked-slots') }}?studio_id=${studioId}&date=${date}`)
            .then(res => res.json())
            .then(data => {
                bookedSlots = data.booked_slots || [];
                // Bersihkan slot terpilih jika kebetulan sudah terisi
                selectedSlots = selectedSlots.filter(s => !bookedSlots.includes(s));
                document.getElementById('inputSlots').value = JSON.stringify(selectedSlots);
                renderSlotsUI();
                recalculateSummary();
            })
            .catch(() => {
                bookedSlots = [];
                renderSlotsUI();
                recalculateSummary();
            });
    }

    // Render Status Slot Jam (Tersedia / Terisi / Dipilih)
    function renderSlotsUI() {
        const cards = document.querySelectorAll('.slot-card');
        cards.forEach(card => {
            const slot = card.getAttribute('data-slot');
            card.classList.remove('is-booked', 'is-selected');

            if (bookedSlots.includes(slot)) {
                card.classList.add('is-booked');
                card.querySelector('.slot-status').textContent = 'Terisi';
            } else if (selectedSlots.includes(slot)) {
                card.classList.add('is-selected');
                card.querySelector('.slot-status').textContent = 'Dipilih';
            } else {
                card.querySelector('.slot-status').textContent = 'Tersedia';
            }
        });
    }

    // Toggle Klik Slot Jam
    function toggleSlot(slot) {
        if (bookedSlots.includes(slot)) return;

        const idx = selectedSlots.indexOf(slot);
        if (idx > -1) {
            selectedSlots.splice(idx, 1);
        } else {
            selectedSlots.push(slot);
        }

        selectedSlots.sort((a, b) => {
            return parseInt(a) - parseInt(b);
        });

        document.getElementById('inputSlots').value = JSON.stringify(selectedSlots);
        renderSlotsUI();
        recalculateSummary();
    }

    // Hitung Ulang Biaya & Ringkasan
    function recalculateSummary() {
        const count = selectedSlots.length;
        const select = document.getElementById('studioSelect');
        const rate = parseInt(select.options[select.selectedIndex].getAttribute('data-price')) || 70000;

        if (count === 0) {
            document.getElementById('slotSummaryText').textContent = 'Belum ada slot jam yang dipilih';
            document.getElementById('sumTime').textContent = '-';
            document.getElementById('sumDuration').textContent = '0 jam';
            document.getElementById('sumTotal').textContent = 'Rp0';
            return;
        }

        const hours = selectedSlots.map(s => parseInt(s)).sort((a, b) => a - b);
        const minH = hours[0];
        const maxH = hours[hours.length - 1] + 1;

        const timeStr = `${String(minH).padStart(2, '0')}.00–${String(maxH).padStart(2, '0')}.00`;
        const durStr = `${count} jam`;

        document.getElementById('slotSummaryText').textContent = `${timeStr} \u00b7 ${durStr}`;
        document.getElementById('sumTime').textContent = timeStr;
        document.getElementById('sumDuration').textContent = durStr;

        const total = count * rate;
        document.getElementById('sumTotal').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(total);
    }

    // Validasi Form Sebelum Submit
    document.getElementById('resForm').addEventListener('submit', (e) => {
        if (selectedSlots.length === 0) {
            e.preventDefault();
            alert('Silakan pilih minimal satu slot jam latihan pada bagian "Pilih slot jam".');
            return;
        }

        if (!document.getElementById('agreeTerms').checked) {
            e.preventDefault();
            alert('Anda harus mencentang persetujuan ketentuan reservasi.');
            return;
        }
    });
</script>
@endsection
