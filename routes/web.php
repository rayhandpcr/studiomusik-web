<?php

use App\Http\Controllers\AdminContactMessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CostSplitController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationExtensionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman Landing & Formulir Kontak
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/contact', [LandingController::class, 'sendContact'])->name('contact.send');

// Rute Tamu (Guest): Masuk & Daftar & Lupa Kata Sandi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Logout (Hanya User yang Login)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Rute Kompatibilitas Reservasi Baru
Route::get('/reservasi/baru', fn () => redirect()->route('reservations.create'));

// Area Pelanggan (Auth)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Reservasi
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/booked-slots', [ReservationController::class, 'bookedSlots'])->name('reservations.booked-slots');
    Route::get('/reservations/{reservation}/payment', [ReservationController::class, 'payment'])->name('reservations.payment');
    Route::post('/reservations/{reservation}/payment', [ReservationController::class, 'pay'])->name('reservations.pay');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');

    // Perpanjangan Waktu Reservasi
    Route::get('/extensions/create', [ReservationExtensionController::class, 'create'])->name('extensions.create');
    Route::get('/extensions/check-availability', [ReservationExtensionController::class, 'checkAvailability'])->name('extensions.check');
    Route::post('/extensions', [ReservationExtensionController::class, 'store'])->name('extensions.store');

    // Pembagian Biaya
    Route::get('/cost-splits', [CostSplitController::class, 'index'])->name('cost-splits.index');
    Route::post('/cost-splits', [CostSplitController::class, 'store'])->name('cost-splits.store');
    Route::post('/cost-splits/equal-split', [CostSplitController::class, 'equalSplit'])->name('cost-splits.equal-split');
    Route::post('/cost-splits/{costSplit}/remind', [CostSplitController::class, 'remind'])->name('cost-splits.remind');

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Profil & Pengaturan Akun
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Area Administrator (Auth + Admin Role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminContactMessageController::class, 'index'])->name('dashboard');
    Route::get('/messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{message}/read', [AdminContactMessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('/messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');
});
