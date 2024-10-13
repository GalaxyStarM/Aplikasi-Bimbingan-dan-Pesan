<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan ini ada

// Route ke halaman login
Route::get('/login', function () {
    return redirect('/login');
});

// Route untuk menampilkan tampilan isi pesan (menggunakan file tampilanisipesan.blade.php)
Route::get('/isipesan', function () {
    return view('pesan.isipesan'); // Mengarahkan ke file tampilanisipesan.blade.php di folder pesan
});

Route::get('/tampilanisipesan', function () {
    return view('pesan.tampilanisipesan'); // Mengarahkan ke file tampilanisipesan.blade.php di folder pesan
});

// Route ke dashboard pesan (dasboarpesan.blade.php)
Route::get('/dashboardpesan', function () {
    return view('pesan.dasboarpesan');
});

// Route ke halaman bimbingan usulan
Route::get('/', function () {
    return view('bimbingan.usulanbimbingan');
});

// Route ke halaman login dengan AuthController
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
