<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DosenController;

// Route untuk guest (belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Route untuk pesanan
Route::get('/buatpesan', function () {
    return view('pesan.mahasiswa.buatpesan');
});

Route::get('/isipesan', function () {
    return view('pesan.mahasiswa.isipesan');
});

Route::get('/dashboardpesan', function () {
    return view('pesan.dashboardpesan');
});

Route::get('/buatpesandosen', function () {
    return view('pesan.dosen.buatpesandosen');
});

Route::get('/isipesandosen', function () {
    return view('pesan.dosen.isipesandosen');
});

Route::get('/profilmahasiswa', function(){
    return view('bimbingan.mahasiswa.profilmahasiswa');
  });

  Route::get('/gantipassword', function(){
    return view('bimbingan.mahasiswa.gantipassword');
  });

Route::get('/contohdashboard', function(){
    return view('pesan.contohdashboard');
});

Route::get('/datausulanbimbingan', function(){
    return view('bimbingan.admin.datausulanbimbingan');
});

// Route untuk mahasiswa
Route::middleware(['auth:mahasiswa', 'checkRole:mahasiswa'])->group(function () {
    Route::get('/usulanbimbingan', function() {
        return view('bimbingan.mahasiswa.usulanbimbingan');
    })->name('mahasiswa.usulanbimbingan');

    Route::get('/aksiInformasi', function(){
        return view('bimbingan.aksiInformasi');
    });

    Route::get('/detaildaftar', function(){
        return view('bimbingan.mahasiswa.detaildaftar');
    })->name('detaildaftar');

    Route::get('/riwayatmahasiswa', function(){
        return view('bimbingan.riwayatmahasiswa');
    });

    // Bimbingan routes
    Route::get('/pilihjadwal', [JadwalController::class, 'index'])->name('pilihjadwal.index');
    Route::post('/pilihjadwal/store', [JadwalController::class, 'store'])->name('pilihjadwal.store');
    Route::get('/pilihjadwal/available', [JadwalController::class, 'getAvailableJadwal'])->name('pilihjadwal.available');
    
});

// Route untuk dosen
Route::middleware(['auth:dosen', 'checkRole:dosen'])->group(function () {
    // Route view biasa
    Route::get('/persetujuan', function() {
        return view('bimbingan.dosen.persetujuan');
    })->name('dosen.persetujuan');

    Route::get('/riwayatdosen', function(){
        return view('bimbingan.riwayatdosen');
    });

    Route::get('/terimausulanbimbingan', function(){
        return view('bimbingan.dosen.terimausulanbimbingan');
    });

    Route::get('/editusulan', function(){
        return view('bimbingan.dosen.editusulan');
    });

    // Jadwal routes
    Route::get('/masukkanjadwal', [DosenController::class, 'index'])->name('dosen.jadwal.index');
    Route::get('/masukkanjadwal/events', [DosenController::class, 'getEvents'])->name('dosen.jadwal.events');
    Route::post('/masukkanjadwal/store', [DosenController::class, 'store'])->name('dosen.jadwal.store');
    Route::delete('/masukkanjadwal/{eventId}', [DosenController::class, 'destroy'])->name('dosen.jadwal.destroy');

    // Google Calendar auth routes - moved outside prefix to match callback URL
    Route::get('/google/connect', [DosenController::class, 'connect'])->name('dosen.google.connect');
    Route::get('dosen/google/callback', [DosenController::class, 'callback'])->name('dosen.google.callback');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');