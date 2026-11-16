<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/contact', [LandingController::class, 'sendContact'])->name('contact.send');

// Rute navigasi tombol Masuk, Daftar, dan Reservasi
Route::get('/login', fn () => 'Halaman Login')->name('login');
Route::get('/register', fn () => 'Halaman Daftar')->name('register');
Route::get('/reservasi/baru', fn () => redirect()->route('login'))->name('reservations.create');
