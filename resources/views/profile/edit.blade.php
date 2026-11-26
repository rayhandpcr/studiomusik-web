@extends('layouts.pelanggan')

@section('title', 'Pengaturan Akun — Studio Musik Positif')

@section('page_css')
<style>
    /* Header Halaman */
    .profile-header {
        margin-bottom: 26px;
    }

    .profile-eyebrow {
        font-size: 11px;
        color: #475974;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }

    .profile-h1 {
        font-size: 32px;
        font-weight: 400;
        color: #1C3562;
        line-height: 1.2;
        margin-bottom: 6px;
    }

    .profile-sub {
        font-size: 13px;
        color: #475974;
    }

    /* Grid 2 Kolom (1.3fr 1fr) */
    .profile-grid {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 20px;
        align-items: start;
    }

    .profile-card {
        background: #FFFFFF;
        border: 1px solid rgba(71, 89, 116, 0.18);
        box-shadow: 0 1px 3px rgba(28, 53, 98, 0.05);
        border-radius: 10px;
        padding: 24px;
    }

    .profile-card-title {
        font-size: 19px;
        font-weight: 400;
        color: #1C3562;
        margin-bottom: 18px;
    }

    /* Info Header Akun */
    .user-overview-box {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 20px;
        margin-bottom: 22px;
        border-bottom: 1px solid rgba(71, 89, 116, 0.18);
    }

    .avatar-circle {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: #1C3562;
        border: 2px solid #A0AA54;
        color: #F9FAFC;
        font-size: 22px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .user-meta-name {
        font-size: 17px;
        font-weight: 600;
        color: #1C3562;
        line-height: 1.2;
        margin-bottom: 3px;
    }

    .user-meta-sub {
        font-size: 12px;
        color: #475974;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .badge-role {
        font-size: 10.5px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 4px;
        background: rgba(160, 170, 84, 0.15);
        border: 1px solid rgba(160, 170, 84, 0.45);
        color: #4B531B;
        text-transform: capitalize;
    }

    /* Form Fields */
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

    .input-field {
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

    .input-field:focus {
        border-color: #1C3562;
    }

    .input-pass-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-pass-wrap .input-field {
        padding-right: 84px;
    }

    .pass-toggle-btn {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        color: #475974;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        padding: 0;
    }

    .pass-toggle-btn:hover {
        color: #1C3562;
    }

    .btn-submit-amber {
        background: #1C3562;
        color: #F9FAFC;
        font-weight: 600;
        font-size: 13px;
        padding: 10px 20px;
        border-radius: 7px;
        border: none;
        cursor: pointer;
        transition: background 0.15s ease;
        margin-top: 4px;
    }

    .btn-submit-amber:hover {
        background: #15284B;
    }

    .err-text {
        color: #B91C1C;
        font-size: 11.5px;
        margin-top: 3px;
    }

    @media (max-width: 900px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Header Halaman -->
<div class="profile-header">
    <div class="profile-eyebrow">Pelanggan / desktop / pengaturan akun</div>
    <h1 class="profile-h1 font-serif">Pengaturan akun</h1>
    <p class="profile-sub">Kelola informasi data diri dan keamanan kata sandi akunmu.</p>
</div>

<!-- Grid 2 Kolom -->
<div class="profile-grid">
    <!-- ================= KARTU KIRI: DATA DIRI ================= -->
    <div class="profile-card">
        <h2 class="profile-card-title font-serif">Informasi data diri</h2>

        <!-- Ringkasan Avatar & Identitas -->
        <div class="user-overview-box">
            <div class="avatar-circle font-serif">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div class="user-meta-name font-serif">{{ $user->name }}</div>
                <div class="user-meta-sub">
                    <span>{{ $user->email }}</span>
                    <span>&middot;</span>
                    <span class="badge-role">{{ $user->role }}</span>
                </div>
                <div style="font-size: 11.5px; color: #475974; margin-top: 4px;">
                    Bergabung sejak {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div class="form-group">
                <label class="form-label" for="inputName">Nama lengkap</label>
                <input type="text" id="inputName" name="name" value="{{ old('name', $user->name) }}" class="input-field" required>
                @error('name')
                    <span class="err-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="inputEmail">Email</label>
                <input type="email" id="inputEmail" name="email" value="{{ old('email', $user->email) }}" class="input-field" required>
                @error('email')
                    <span class="err-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nomor WhatsApp -->
            <div class="form-group">
                <label class="form-label" for="inputPhone">Nomor WhatsApp</label>
                <input type="text" id="inputPhone" name="phone" value="{{ old('phone', $user->phone) }}" class="input-field" placeholder="081234567890" required>
                @error('phone')
                    <span class="err-text">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit-amber">
                Simpan perubahan
            </button>
        </form>
    </div>

    <!-- ================= KARTU KANAN: UBAH KATA SANDI ================= -->
    <div class="profile-card">
        <h2 class="profile-card-title font-serif">Ubah kata sandi</h2>

        <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')

            <!-- Kata Sandi Saat Ini -->
            <div class="form-group">
                <label class="form-label" for="currentPasswordInput">Kata sandi saat ini</label>
                <div class="input-pass-wrap">
                    <input type="password" id="currentPasswordInput" name="current_password" class="input-field" placeholder="••••••••" required>
                    <button type="button" class="pass-toggle-btn" onclick="togglePasswordVisibility('currentPasswordInput', this)">Tampilkan</button>
                </div>
                @error('current_password')
                    <span class="err-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Kata Sandi Baru -->
            <div class="form-group">
                <label class="form-label" for="newPasswordInput">Kata sandi baru</label>
                <div class="input-pass-wrap">
                    <input type="password" id="newPasswordInput" name="password" class="input-field" placeholder="Minimal 8 karakter" required>
                    <button type="button" class="pass-toggle-btn" onclick="togglePasswordVisibility('newPasswordInput', this)">Tampilkan</button>
                </div>
                @error('password')
                    <span class="err-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Konfirmasi Kata Sandi Baru -->
            <div class="form-group">
                <label class="form-label" for="confirmPasswordInput">Konfirmasi kata sandi baru</label>
                <div class="input-pass-wrap">
                    <input type="password" id="confirmPasswordInput" name="password_confirmation" class="input-field" placeholder="Ulangi kata sandi baru" required>
                    <button type="button" class="pass-toggle-btn" onclick="togglePasswordVisibility('confirmPasswordInput', this)">Tampilkan</button>
                </div>
            </div>

            <button type="submit" class="btn-submit-amber">
                Perbarui kata sandi
            </button>
        </form>
    </div>
</div>
@endsection

@section('page_js')
<script>
    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Sembunyikan';
        } else {
            input.type = 'password';
            btn.textContent = 'Tampilkan';
        }
    }
</script>
@endsection
