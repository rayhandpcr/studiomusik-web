<?php

use App\Http\Controllers\AdminContactMessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
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

// Rute Reservasi Baru (Mengarahkan ke login bila belum masuk)
Route::get('/reservasi/baru', fn () => redirect()->route('login'))->name('reservations.create');

// Area Pelanggan (Auth)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.customer', [
            'user' => Auth::user(),
        ]);
    })->name('dashboard');
});

// Area Administrator (Auth + Admin Role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminContactMessageController::class, 'index'])->name('dashboard');
    Route::get('/messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{message}/read', [AdminContactMessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('/messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');
});
