@extends('layouts.pelanggan')

@section('title', 'Pembayaran Reservasi ' . $reservation->booking_code . ' — Studio Musik Positif')

@section('page_css')
<style>
    /* Navigasi Kembali */
    .pay-back-nav {
        margin-bottom: 20px;
    }

    .pay-back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #475974;
        font-size: 13px;
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .pay-back-link:hover {
        color: #1C3562;
    }

    /* Header Halaman */
    .pay-header {
        margin-bottom: 26px;
    }

    .pay-eyebrow {
        font-size: 11px;
        color: #475974;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }

    .pay-h1 {
        font-size: 32px;
        font-weight: 400;
        color: #1C3562;
        line-height: 1.2;
        margin-bottom: 6px;
    }

    .pay-sub {
        font-size: 13px;
        color: #475974;
    }

    /* Grid 2 Kolom (1.35fr 1fr) */
    .pay-grid {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 20px;
        align-items: start;
    }

    .pay-card {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
        border-radius: 10px;
        padding: 24px;
    }

    .pay-card-title {
        font-size: 19px;
        font-weight: 400;
        color: #1C3562;
        margin-bottom: 18px;
    }

    /* Radio Card Pilihan Metode Pembayaran */
    .method-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 22px;
    }

    .method-card {
        border: 1px solid rgba(71, 89, 116, 0.24);
        background: #FFFFFF;
        border-radius: 8px;
        padding: 14px 16px;
        cursor: pointer;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        transition: all 0.15s ease;
        position: relative;
    }

    .method-card:hover {
        border-color: #1C3562;
        background: rgba(28, 53, 98, 0.02);
    }

    .method-card.selected {
        border-color: #1C3562;
        background: rgba(28, 53, 98, 0.04);
    }

    .method-radio {
        accent-color: #1C3562;
        margin-top: 3px;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .method-content {
        flex: 1;
    }

    .method-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4px;
    }

    .method-name {
        font-size: 13.5px;
        font-weight: 600;
        color: #1C3562;
    }

    .method-tag {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 4px;
        background: rgba(28, 53, 98, 0.08);
        border: 1px solid rgba(28, 53, 98, 0.18);
        color: #1C3562;
    }

    .method-info {
        font-size: 12px;
        color: #475974;
        line-height: 1.5;
    }

    /* Form Inputs */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-bottom: 18px;
    }

    .form-label {
        font-size: 12.5px;
        font-weight: 500;
        color: #1C3562;
    }

    .input-text {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.28);
        border-radius: 7px;
        padding: 10px 14px;
        color: #1C3562;
        font-size: 13px;
        outline: none;
        transition: border-color 0.15s ease;
    }

    .input-text:focus {
        border-color: #1C3562;
    }

    .input-file-wrap {
        background: #FFFFFF;
        border: 1px dashed rgba(71, 89, 116, 0.35);
        border-radius: 7px;
        padding: 14px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.15s ease;
    }

    .input-file-wrap:hover {
        border-color: #1C3562;
    }

    .input-file-hidden {
        display: none;
    }

    .file-hint {
        font-size: 11px;
        color: #475974;
        margin-top: 4px;
    }

    .btn-pay-submit {
        width: 100%;
        background: #1C3562;
        color: #F9FAFC;
        font-weight: 600;
        font-size: 14px;
        padding: 12px;
        border-radius: 7px;
        border: none;
        cursor: pointer;
        transition: background 0.15s ease;
        margin-top: 8px;
    }

    .btn-pay-submit:hover {
        background: #15284B;
    }

    /* Kartu Kanan: Ringkasan Tagihan */
    .bill-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(71, 89, 116, 0.18);
    }

    .bill-code {
        font-family: monospace;
        font-size: 15px;
        font-weight: 700;
        color: #1C3562;
    }

    .badge-amber {
        background: rgba(160, 170, 84, 0.15);
        border: 1px solid rgba(160, 170, 84, 0.45);
        color: #4B531B;
        font-size: 11px;
        font-weight: 500;
        padding: 3px 9px;
        border-radius: 999px;
    }

    .bill-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 16px;
    }

    .bill-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
    }

    .bill-label {
        color: #475974;
    }

    .bill-val {
        color: #1C3562;
        font-weight: 500;
        text-align: right;
    }

    .bill-divider {
        height: 1px;
        background: rgba(71, 89, 116, 0.18);
        margin: 6px 0;
    }

    .bill-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid rgba(71, 89, 116, 0.18);
    }

    .bill-total-label {
        font-size: 13.5px;
        font-weight: 600;
        color: #1C3562;
    }

    .bill-total-val {
        font-size: 22px;
        font-weight: 700;
        color: #1C3562;
    }

    .bill-note-box {
        margin-top: 18px;
        padding: 12px 14px;
        background: rgba(160, 170, 84, 0.12);
        border: 1px solid rgba(160, 170, 84, 0.35);
        border-radius: 7px;
        font-size: 12px;
        color: #374113;
        line-height: 1.5;
    }

    @media (max-width: 900px) {
        .pay-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Navigasi Kembali -->
<div class="pay-back-nav">
    <a href="{{ route('reservations.show', $reservation->id) }}" class="pay-back-link">
        <span>&larr; Kembali ke detail reservasi</span>
    </a>
</div>

<!-- Header Halaman -->
<div class="pay-header">
    <div class="pay-eyebrow">Pelanggan / desktop / pembayaran</div>
    <h1 class="pay-h1 font-serif">Pembayaran reservasi {{ $reservation->booking_code }}</h1>
    <p class="pay-sub">Selesaikan pembayaran untuk mengonfirmasi jadwal sesi latihanmu.</p>
</div>

<!-- Grid 2 Kolom -->
<div class="pay-grid">
    <!-- ================= KARTU KIRI: PILIHAN METODE & KONFIRMASI ================= -->
    <div class="pay-card">
        <h2 class="pay-card-title font-serif">Metode &amp; konfirmasi pembayaran</h2>

        <form method="POST" action="{{ route('reservations.pay', $reservation->id) }}" enctype="multipart/form-data">
            @csrf

            <!-- Pilihan Metode Pembayaran -->
            <div class="method-group">
                <!-- 1. Transfer Bank BCA -->
                <label for="method_transfer" class="method-card selected" id="card_transfer">
                    <input type="radio" name="payment_method" id="method_transfer" value="transfer_bank" class="method-radio" checked onchange="updateMethodSelection()">
                    <div class="method-content">
                        <div class="method-top-row">
                            <span class="method-name">Transfer bank</span>
                            <span class="method-tag">BCA</span>
                        </div>
                        <div class="method-info">
                            Bank BCA &middot; <strong>1234567890</strong> a.n. Studio Musik Positif
                        </div>
                    </div>
                </label>

                <!-- 2. QRIS / E-Wallet -->
                <label for="method_qris" class="method-card" id="card_qris">
                    <input type="radio" name="payment_method" id="method_qris" value="qris" class="method-radio" onchange="updateMethodSelection()">
                    <div class="method-content">
                        <div class="method-top-row">
                            <span class="method-name">QRIS / E-Wallet</span>
                            <span class="method-tag">QRIS</span>
                        </div>
                        <div class="method-info">
                            Studio Musik Positif &middot; Merchant ID <strong>SMP-01</strong> (GoPay, OVO, Dana, ShopeePay, LinkAja &amp; BCA Mobile)
                        </div>
                    </div>
                </label>

                <!-- 3. Tunai di Studio -->
                <label for="method_cash" class="method-card" id="card_cash">
                    <input type="radio" name="payment_method" id="method_cash" value="cash" class="method-radio" onchange="updateMethodSelection()">
                    <div class="method-content">
                        <div class="method-top-row">
                            <span class="method-name">Tunai di studio</span>
                            <span class="method-tag">Kasir</span>
                        </div>
                        <div class="method-info">
                            Pembayaran langsung di kasir Studio Musik Positif sebelum sesi latihan dimulai.
                        </div>
                    </div>
                </label>
            </div>

            <!-- Unggah Bukti Transfer -->
            <div class="form-group">
                <label class="form-label" for="paymentProofInput">Unggah bukti transfer (opsional)</label>
                <div class="input-file-wrap" onclick="document.getElementById('paymentProofInput').click()">
                    <div id="fileUploadText" style="color: #475974; font-size: 13px;">
                        Klik untuk memilih file bukti transfer
                    </div>
                    <div class="file-hint">JPG, PNG, atau PDF maksimal 2 MB</div>
                    <input type="file" name="payment_proof" id="paymentProofInput" class="input-file-hidden" accept=".jpg,.jpeg,.png,.pdf" onchange="onFileSelected(this)">
                </div>
            </div>

            <!-- Catatan Pembayaran -->
            <div class="form-group">
                <label class="form-label" for="notesInput">Catatan pembayaran (opsional)</label>
                <input type="text" name="notes" id="notesInput" class="input-text" placeholder="Contoh: Transfer dari rekening a.n. Rayhand">
            </div>

            <button type="submit" class="btn-pay-submit">
                Konfirmasi pembayaran
            </button>
        </form>
    </div>

    <!-- ================= KARTU KANAN: RINGKASAN TAGIHAN ================= -->
    <div class="pay-card">
        <h2 class="pay-card-title font-serif">Ringkasan tagihan</h2>

        <div class="bill-header-row">
            <div>
                <span style="font-size: 11px; color: #475974; display: block; margin-bottom: 2px;">Kode booking</span>
                <span class="bill-code">{{ $reservation->booking_code }}</span>
            </div>
            <div>
                <span class="badge-amber">Menunggu bayar</span>
            </div>
        </div>

        <div class="bill-list">
            <div class="bill-row">
                <span class="bill-label">Studio musik</span>
                <span class="bill-val">{{ $reservation->studio?->name ?? 'Studio Musik' }}</span>
            </div>

            <div class="bill-row">
                <span class="bill-label">Tanggal latihan</span>
                <span class="bill-val">{{ \Carbon\Carbon::parse($reservation->reservation_date)->translatedFormat('l, d F Y') }}</span>
            </div>

            <div class="bill-row">
                <span class="bill-label">Jam sesi</span>
                <span class="bill-val">{{ $reservation->start_time }}–{{ $reservation->end_time }}</span>
            </div>

            <div class="bill-row">
                <span class="bill-label">Durasi latihan</span>
                <span class="bill-val">{{ $reservation->duration_hours }} Jam</span>
            </div>

            <div class="bill-row">
                <span class="bill-label">Tarif per jam</span>
                <span class="bill-val">Rp{{ number_format($reservation->studio?->price_per_hour ?? 70000, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="bill-total-row">
            <span class="bill-total-label">Total tagihan</span>
            <span class="bill-total-val font-serif">Rp{{ number_format($reservation->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="bill-note-box">
            Setelah konfirmasi pembayaran disimpan, status pesanan otomatis berubah menjadi <strong>Lunas</strong> dan jadwal studio terkunci untuk bandmu.
        </div>
    </div>
</div>
@endsection

@section('page_js')
<script>
    function updateMethodSelection() {
        const methods = ['transfer', 'qris', 'cash'];
        methods.forEach(m => {
            const radio = document.getElementById('method_' + m);
            const card = document.getElementById('card_' + m);
            if (radio && card) {
                if (radio.checked) {
                    card.classList.add('selected');
                } else {
                    card.classList.remove('selected');
                }
            }
        });
    }

    function onFileSelected(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            document.getElementById('fileUploadText').innerHTML = 'File terpilih: <strong style="color: #1C3562;">' + fileName + '</strong>';
        }
    }
</script>
@endsection
