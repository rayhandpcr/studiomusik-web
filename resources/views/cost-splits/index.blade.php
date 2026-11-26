@extends('layouts.pelanggan')

@section('title', 'Pembagian Biaya — Studio Musik Positif')

@section('page_css')
<style>
    /* Header Halaman */
    .cost-header {
        margin-bottom: 24px;
    }

    .cost-eyebrow {
        font-size: 11px;
        color: #475974;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }

    .cost-h1 {
        font-size: 32px;
        font-weight: 400;
        color: #1C3562;
        line-height: 1.2;
        margin-bottom: 6px;
    }

    .cost-sub {
        font-size: 13px;
        color: #475974;
    }

    /* Grid Baris 1: 2 Kolom (1.15fr 1fr) */
    .grid-row-1 {
        display: grid;
        grid-template-columns: 1.15fr 1fr;
        gap: 20px;
        align-items: stretch;
        margin-bottom: 20px;
    }

    .cost-card {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
        border-radius: 10px;
        padding: 22px;
        display: flex;
        flex-direction: column;
    }

    .cost-card-h2 {
        font-size: 19px;
        font-weight: 400;
        color: #1C3562;
        margin-bottom: 16px;
    }

    /* Form Dropdown */
    .field-label {
        display: block;
        font-size: 12.5px;
        font-weight: 500;
        color: #1C3562;
        margin-bottom: 6px;
    }

    .select-res {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.28);
        border-radius: 7px;
        padding: 10px 14px;
        color: #1C3562;
        font-size: 13px;
        outline: none;
        cursor: pointer;
        transition: border-color 0.15s ease;
    }

    .select-res:focus {
        border-color: #1C3562;
    }

    .res-schedule-text {
        font-size: 13px;
        font-weight: 500;
        color: #1C3562;
        margin-top: 16px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
    }

    .detail-row-tarip {
        margin-top: 12px;
        color: #475974;
    }

    .detail-row-tarip span:last-child {
        color: #1C3562;
    }

    .detail-row-total {
        margin-top: 10px;
        font-size: 13.5px;
        font-weight: 600;
        color: #1C3562;
    }

    .card-footer-note {
        font-size: 11.5px;
        color: #475974;
        margin-top: auto;
        padding-top: 16px;
        line-height: 1.5;
    }

    /* Kartu Kontribusi Anggota (Kanan) */
    .big-progress-val {
        font-size: 28px;
        font-weight: 700;
        color: #1C3562;
        margin: 8px 0 14px;
        letter-spacing: -0.01em;
    }

    .progress-track {
        height: 8px;
        background: rgba(71, 89, 116, 0.15);
        border-radius: 999px;
        overflow: hidden;
        margin-bottom: 14px;
    }

    .progress-bar-fill {
        height: 100%;
        background: #A0AA54;
        border-radius: 999px;
        transition: width 0.3s ease;
    }

    /* Baris Tombol Aksi Anggota */
    .member-actions-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 14px 0 18px;
        flex-wrap: wrap;
    }

    .btn-dark-outline {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.35);
        color: #1C3562;
        padding: 8px 14px;
        border-radius: 7px;
        font-size: 12.5px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-dark-outline:hover:not(:disabled) {
        border-color: #1C3562;
        background: rgba(28, 53, 98, 0.04);
        color: #1C3562;
    }

    .btn-dark-outline:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Tabel 4 Kolom Anggota */
    .split-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .split-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        text-align: left;
    }

    .split-table th {
        color: #475974;
        font-weight: 500;
        font-size: 11.5px;
        padding: 10px 12px;
        border-bottom: 1px solid rgba(71, 89, 116, 0.18);
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .split-table td {
        padding: 14px 12px;
        border-bottom: 1px solid rgba(71, 89, 116, 0.12);
        color: #1C3562;
        vertical-align: middle;
    }

    .split-table tr:hover td {
        background: rgba(28, 53, 98, 0.02);
    }

    /* Badges Status Bayar */
    .badge-paid {
        background: rgba(160, 170, 84, 0.15);
        border: 1px solid rgba(160, 170, 84, 0.45);
        color: #4B531B;
        font-size: 11.5px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 999px;
        display: inline-block;
    }

    .badge-unpaid {
        background: rgba(185, 28, 28, 0.08);
        border: 1px solid rgba(185, 28, 28, 0.25);
        color: #B91C1C;
        font-size: 11.5px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 999px;
        display: inline-block;
    }

    /* Aksi Tautan Tabel */
    .link-action {
        color: #1C3562;
        text-decoration: none;
        font-size: 12.5px;
        cursor: pointer;
        background: transparent;
        border: none;
        padding: 0;
        display: inline-block;
        font-weight: 500;
    }

    .link-action:hover {
        text-decoration: underline;
    }

    .action-divider {
        color: rgba(71, 89, 116, 0.4);
        margin: 0 4px;
        font-size: 12px;
    }

    /* Baris Total Bawah Tabel */
    .table-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid rgba(71, 89, 116, 0.18);
    }

    /* Form Tambah / Ubah Anggota */
    .form-inputs-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
        margin-top: 10px;
    }

    .input-custom {
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

    .input-custom:focus {
        border-color: #1C3562;
    }

    .btn-amber-submit {
        background: #1C3562;
        color: #F9FAFC;
        font-weight: 600;
        padding: 10px 18px;
        border-radius: 7px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: background 0.15s ease;
    }

    .btn-amber-submit:hover:not(:disabled) {
        background: #15284B;
    }

    .btn-amber-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-cancel-red {
        background: transparent;
        border: 1px solid rgba(185, 28, 28, 0.35);
        color: #B91C1C;
        padding: 10px 16px;
        border-radius: 7px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-cancel-red:hover {
        background: rgba(185, 28, 28, 0.06);
        border-color: #B91C1C;
    }

    @media (max-width: 900px) {
        .grid-row-1 {
            grid-template-columns: 1fr;
        }

        .form-inputs-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Header Halaman -->
<div class="cost-header">
    <div class="cost-eyebrow">Pelanggan / desktop</div>
    <h1 class="cost-h1 font-serif">Pembagian biaya</h1>
    <p class="cost-sub">Catat kontribusi anggota band dan pantau biaya yang sudah terkumpul.</p>
</div>

<!-- ================= BARIS 1: GRID 2 KOLOM ================= -->
<div class="grid-row-1">
    <!-- Kartu Kiri: Reservasi Terpilih -->
    <div class="cost-card">
        <h2 class="cost-card-h2 font-serif">
            @if ($selectedReservation)
                Reservasi {{ $selectedReservation->booking_code }}
            @else
                Pilih reservasi
            @endif
        </h2>

        <label class="field-label" for="reservationSelect">Pilih reservasi</label>
        <select id="reservationSelect" class="select-res" onchange="window.location.href = '{{ route('cost-splits.index') }}?reservation_id=' + this.value">
            @if ($reservations->isEmpty())
                <option disabled selected>Belum ada reservasi</option>
            @else
                @foreach ($reservations as $res)
                    <option value="{{ $res->id }}" {{ $selectedReservation && $selectedReservation->id === $res->id ? 'selected' : '' }}>
                        {{ $res->booking_code }} &middot; {{ $res->studio?->name ?? 'Studio Musik' }}
                    </option>
                @endforeach
            @endif
        </select>

        @if ($selectedReservation)
            <div class="res-schedule-text">
                {{ \Carbon\Carbon::parse($selectedReservation->reservation_date)->translatedFormat('d F Y') }} &middot; {{ $selectedReservation->start_time }}–{{ $selectedReservation->end_time }}
            </div>

            <div class="detail-row detail-row-tarip">
                <span>Tarif &times; durasi</span>
                <span>Rp{{ number_format($selectedReservation->studio?->price_per_hour ?? 70000, 0, ',', '.') }} &times; {{ $selectedReservation->duration_hours }} jam</span>
            </div>

            <div class="detail-row detail-row-total">
                <span>Total biaya</span>
                <span>Rp{{ number_format($selectedReservation->total_price, 0, ',', '.') }}</span>
            </div>

            <div class="card-footer-note">
                @if ($selectedReservation->payment_status === 'lunas')
                    Biaya studio lunas. Reservasi sudah dibayar {{ explode(' ', auth()->user()->name)[0] }} kepada studio.
                @else
                    Biaya awal belum lunas ke studio. Catatan ini membantu mengumpulkan uang patungan band.
                @endif
            </div>
        @else
            <div class="card-footer-note" style="margin-top: 24px;">
                Belum ada reservasi aktif. Silakan buat reservasi terlebih dahulu.
            </div>
        @endif
    </div>

    <!-- Kartu Kanan: Kontribusi Anggota -->
    <div class="cost-card">
        <h2 class="cost-card-h2 font-serif">Kontribusi anggota</h2>

        <div class="big-progress-val font-serif">
            Rp{{ number_format($collectedAmount, 0, ',', '.') }} / Rp{{ number_format($totalCost, 0, ',', '.') }}
        </div>

        <div class="progress-track">
            <div class="progress-bar-fill" style="width: {{ $progressPercent }}%;"></div>
        </div>

        <div class="detail-row" style="margin-top: 12px;">
            <span style="color: #475974;">Terkumpul</span>
            <span style="color: #1C3562;">{{ $progressPercent }}% &middot; {{ $paidCount }} dari {{ $totalMembers }} anggota</span>
        </div>

        <div class="detail-row" style="margin-top: 10px;">
            <span style="color: #1C3562; font-weight: 500;">Sisa kontribusi</span>
            <span style="color: #1C3562; font-weight: 600;">Rp{{ number_format($remainingAmount, 0, ',', '.') }}</span>
        </div>

        <div class="card-footer-note">
            Catatan internal band, bukan status pembayaran ke studio.
        </div>
    </div>
</div>

<!-- ================= BARIS 2: KARTU LEBAR PENUH (Anggota & Kontribusi) ================= -->
<div class="cost-card" style="margin-bottom: 20px;">
    <h2 class="cost-card-h2 font-serif">Anggota &amp; kontribusi</h2>

    <div class="member-actions-row">
        <!-- Tombol Bagi Rata -->
        <form method="POST" action="{{ route('cost-splits.equal-split') }}" style="margin: 0;">
            @csrf
            <input type="hidden" name="reservation_id" value="{{ $selectedReservation->id ?? '' }}">
            <button type="submit" class="btn-dark-outline" {{ !$selectedReservation ? 'disabled' : '' }}>
                Bagi rata &middot; {{ $totalMembers > 0 ? $totalMembers : 4 }} orang
            </button>
        </form>

        <!-- Tombol Tambah Anggota -->
        <button type="button" class="btn-dark-outline" onclick="resetFormForNewMember()" {{ !$selectedReservation ? 'disabled' : '' }}>
            + Tambah anggota
        </button>
    </div>

    <div class="split-table-wrap">
        <table class="split-table">
            <thead>
                <tr>
                    <th>Nama anggota</th>
                    <th>Nominal</th>
                    <th>Status bayar</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if ($costSplits->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 32px 12px; color: #475974;">
                            @if (!$selectedReservation)
                                Silakan buat reservasi terlebih dahulu untuk mulai membagi biaya.
                            @else
                                Belum ada anggota yang dicatat. Klik <strong>Bagi rata</strong> atau <strong>+ Tambah anggota</strong> di atas.
                            @endif
                        </td>
                    </tr>
                @else
                    @foreach ($costSplits as $split)
                        <tr>
                            <!-- 1. Nama Anggota -->
                            <td style="font-weight: 500;">
                                {{ $split->member_name }}
                            </td>

                            <!-- 2. Nominal -->
                            <td>
                                Rp{{ number_format($split->amount, 0, ',', '.') }}
                            </td>

                            <!-- 3. Status Bayar -->
                            <td>
                                @if ($split->payment_status === 'sudah_bayar')
                                    <span class="badge-paid">Sudah bayar</span>
                                @else
                                    <span class="badge-unpaid">Belum bayar</span>
                                @endif
                            </td>

                            <!-- 4. Tindakan -->
                            <td>
                                @if ($split->payment_status === 'sudah_bayar')
                                    <button type="button" class="link-action" onclick="loadMemberForEdit({{ $split->id }}, '{{ addslashes($split->member_name) }}', {{ $split->amount }}, '{{ $split->payment_status }}')">
                                        Lihat catatan
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('cost-splits.remind', $split->id) }}" style="display: inline; margin: 0;">
                                        @csrf
                                        <button type="submit" class="link-action">
                                            Ingatkan
                                        </button>
                                    </form>
                                    <span class="action-divider">/</span>
                                    <button type="button" class="link-action" onclick="loadMemberForPayment({{ $split->id }}, '{{ addslashes($split->member_name) }}', {{ $split->amount }})">
                                        catat bayar
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="table-total-row">
        <span style="font-size: 12.5px; color: #475974;">Total pembagian &middot; {{ $totalMembers }} anggota</span>
        <span style="font-size: 13.5px; color: #1C3562; font-weight: 600;">Rp{{ number_format($totalSplitAmount, 0, ',', '.') }}</span>
    </div>
</div>

<!-- ================= BARIS 3: KARTU LEBAR PENUH (Tambah atau Ubah Anggota) ================= -->
<div class="cost-card" id="formMemberCard">
    <h2 class="cost-card-h2 font-serif" id="formMemberTitle">Tambah atau ubah anggota</h2>

    <form id="splitMemberForm" method="POST" action="{{ route('cost-splits.store') }}">
        @csrf
        <input type="hidden" name="reservation_id" value="{{ $selectedReservation->id ?? '' }}">
        <input type="hidden" name="split_id" id="splitIdInput" value="">

        <!-- HANYA 3 KOLOM INPUT SESUAI DESAIN FIGMA -->
        <div class="form-inputs-row">
            <!-- Kolom 1: Nama Anggota -->
            <div>
                <label class="field-label" for="memberNameInput">Nama anggota</label>
                <input type="text" name="member_name" id="memberNameInput" class="input-custom" placeholder="Masukkan nama anggota" required {{ !$selectedReservation ? 'disabled' : '' }}>
            </div>

            <!-- Kolom 2: Nominal Kontribusi -->
            <div>
                <label class="field-label" for="memberAmountInput">Nominal kontribusi</label>
                <input type="text" name="amount" id="memberAmountInput" class="input-custom" placeholder="Rp35.000" required {{ !$selectedReservation ? 'disabled' : '' }}>
            </div>

            <!-- Kolom 3: Status Pembayaran -->
            <div>
                <label class="field-label" for="memberStatusSelect">Status pembayaran</label>
                <select name="payment_status" id="memberStatusSelect" class="select-res" {{ !$selectedReservation ? 'disabled' : '' }}>
                    <option value="belum_bayar">Belum bayar</option>
                    <option value="sudah_bayar">Sudah bayar</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 18px;">
            <button type="submit" class="btn-amber-submit" {{ !$selectedReservation ? 'disabled' : '' }}>
                Simpan pembagian
            </button>
            <button type="button" id="btnCancelSplit" class="btn-cancel-red" onclick="resetFormForNewMember()">
                Batal
            </button>
        </div>
    </form>
</div>
@endsection

@section('page_js')
<script>
    // Format nominal uang otomatis saat mengetik
    const amountInput = document.getElementById('memberAmountInput');
    if (amountInput) {
        amountInput.addEventListener('input', function(e) {
            let val = this.value.replace(/[^0-9]/g, '');
            if (val) {
                this.value = 'Rp' + new Intl.NumberFormat('id-ID').format(val);
            } else {
                this.value = '';
            }
        });
    }

    // Reset formulir kembali ke mode tambah anggota baru
    function resetFormForNewMember() {
        document.getElementById('splitIdInput').value = '';
        document.getElementById('memberNameInput').value = '';
        document.getElementById('memberAmountInput').value = '';
        document.getElementById('memberStatusSelect').value = 'belum_bayar';
        document.getElementById('formMemberTitle').textContent = 'Tambah atau ubah anggota';
        document.getElementById('memberNameInput').focus();
    }

    // Muat data anggota ke formulir untuk diubah
    function loadMemberForEdit(id, name, amount, status) {
        document.getElementById('splitIdInput').value = id;
        document.getElementById('memberNameInput').value = name;
        document.getElementById('memberAmountInput').value = 'Rp' + new Intl.NumberFormat('id-ID').format(amount);
        document.getElementById('memberStatusSelect').value = status;
        document.getElementById('formMemberTitle').textContent = 'Ubah anggota &middot; ' + name;

        // Gulir halus ke formulir
        document.getElementById('formMemberCard').scrollIntoView({ behavior: 'smooth' });
        document.getElementById('memberNameInput').focus();
    }

    // Muat data anggota dan langsung ubah status menjadi Sudah bayar
    function loadMemberForPayment(id, name, amount) {
        document.getElementById('splitIdInput').value = id;
        document.getElementById('memberNameInput').value = name;
        document.getElementById('memberAmountInput').value = 'Rp' + new Intl.NumberFormat('id-ID').format(amount);
        document.getElementById('memberStatusSelect').value = 'sudah_bayar';
        document.getElementById('formMemberTitle').textContent = 'Catat bayar &middot; ' + name;

        // Gulir halus ke formulir
        document.getElementById('formMemberCard').scrollIntoView({ behavior: 'smooth' });
        document.getElementById('memberStatusSelect').focus();
    }
</script>
@endsection
