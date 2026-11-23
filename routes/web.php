<?php

use App\Http\Controllers\AdminContactMessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationExtensionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman Landing & Formulir Kontak
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/contact', [LandingController::class, 'sendContact'])->name('contact.send');

// Rute Tamu (Guest): Masuk & Daftar
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
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
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');

    // Perpanjangan Waktu Reservasi
    Route::get('/extensions/create', [ReservationExtensionController::class, 'create'])->name('extensions.create');
    Route::get('/extensions/check-availability', [ReservationExtensionController::class, 'checkAvailability'])->name('extensions.check');
    Route::post('/extensions', [ReservationExtensionController::class, 'store'])->name('extensions.store');
});

// Area Administrator (Auth + Admin Role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminContactMessageController::class, 'index'])->name('dashboard');
    Route::get('/messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{message}/read', [AdminContactMessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('/messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');
});
