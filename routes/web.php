<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\PilihJadwalController;
use App\Http\Controllers\MasukkanJadwalController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\ProfilController;

// Route untuk guest (belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::get('/profilmahasiswa', function(){
    return view('bimbingan.mahasiswa.profilmahasiswa');
  });

  Route::get('/gantipassword', function(){
    return view('bimbingan.mahasiswa.gantipassword');
  });

Route::get('/datausulanbimbingan', function(){
    return view('bimbingan.admin.datausulanbimbingan');
});
Route::get('/conso', function(){
    return view('pesan.contohdashboard');
});

Route::get('/isipesandosen', function () {
    return view('pesan.dosen.isipesandosen');
});

Route::get('/buatpesandosen', function () {
    return view('pesan.dosen.buatpesandosen');
});

Route::middleware(['auth:mahasiswa,dosen'])->group(function () {
    Route::prefix('pesan')->group(function () {
        Route::get('/dashboardkonsultasi', [PesanController::class, 'indexMahasiswa'])
            ->name('pesan.dashboardkonsultasi');
        Route::get('/dashboardkonsultasi', [PesanController::class, 'indexDosen'])
            ->name('pesan.dashboardkonsultasi');
        // Route lainnya untuk pesan
        Route::get('/create', [PesanController::class, 'create'])->name('pesan.create');
        Route::post('/store', [PesanController::class, 'store'])->name('pesan.store');
        Route::get('/{id}', [PesanController::class, 'show'])->name('pesan.show');
        Route::patch('/{id}/status', [PesanController::class, 'updateStatus'])->name('pesan.updateStatus');
        Route::post('/request-notification', [PesanController::class, 'requestNotification'])->name('pesan.requestNotification');
        Route::get('/filterAktif', [PesanController::class, 'filterAktif'])->name('pesan.filterAktif');
        Route::get('/filterSelesai', [PesanController::class, 'filterSelesai'])->name('pesan.filterSelesai');
        Route::get('/getDosen', [PesanController::class, 'getDosen'])->name('pesan.getDosen');
        Route::post('/reply/{id}', [PesanController::class, 'storeReply'])->name('pesan.reply');
        Route::post('/end/{id}', [PesanController::class, 'endChat'])->name('pesan.end');
        Route::get('/attachment/{id}', [PesanController::class, 'downloadAttachment'])->name('pesan.attachment');
    });
});

// Route untuk mahasiswa
Route::middleware(['auth:mahasiswa', 'checkRole:mahasiswa'])->group(function () {
    // Route view biasa

    Route::controller(MahasiswaController::class)->group(function () {
        Route::get('/usulanbimbingan', 'index')->name('mahasiswa.usulanbimbingan');
        Route::post('/usulanbimbingan/selesai/{id}', 'selesaiBimbingan')->name('mahasiswa.selesaibimbingan');
        Route::get('/aksiInformasi/{id}', 'getDetailBimbingan')->name('mahasiswa.aksiInformasi');
        Route::get('/detaildaftar/{nip}', 'getDetailDaftar')->name('mahasiswa.detaildaftar');
    });

    // Bimbingan routes
    Route::controller(PilihJadwalController::class)->prefix('pilihjadwal')->group(function () {
        Route::get('/', 'index')->name('pilihjadwal.index');
        Route::post('/store', 'store')->name('pilihjadwal.store');
        Route::get('/available', 'getAvailableJadwal')->name('pilihjadwal.available');
        Route::get('/check', 'checkAvailability')->name('pilihjadwal.check');
        Route::post('/create-event/{usulanId}', 'createGoogleCalendarEvent')->name('pilihjadwal.create-event');
    });
    
    Route::controller(GoogleCalendarController::class)->prefix('mahasiswa')->group(function () {
        Route::get('/google/connect','connect')->name('mahasiswa.google.connect');
        Route::get('/google/callback','callback')->name('mahasiswa.google.callback');
    });

    
    Route::prefix('profil')->group(function () {
        Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profil/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profil/remove-foto', [ProfileController::class, 'remove'])->name('profile.remove-foto');
    });
});

// Route untuk dosen
Route::middleware(['auth:dosen', 'checkRole:dosen'])->group(function () {
    // Route view biasa

    Route::controller(DosenController::class)->group(function () {
        Route::get('/persetujuan', 'index')->name('dosen.persetujuan');
        Route::get('/terimausulanbimbingan/{id}', 'getDetailBimbingan')->name('dosen.detailbimbingan');
        Route::post('/terimausulanbimbingan/terima/{id}', 'terima')->name('dosen.detailbimbingan.terima');
        Route::post('/terimausulanbimbingan/tolak/{id}', 'tolak')->name('dosen.detailbimbingan.tolak');
        Route::post('/persetujuan/terima/{id}', 'terima')->name('dosen.persetujuan.terima');
        Route::post('/persetujuan/tolak/{id}', 'tolak')->name('dosen.persetujuan.tolak');
    });

    // Jadwal routes
    Route::controller(MasukkanJadwalController::class)->prefix('masukkanjadwal')->group(function () {
        Route::get('/', 'index')->name('dosen.jadwal.index');
        Route::post('/store', 'store')->name('dosen.jadwal.store');
        Route::delete('/{eventId}', 'destroy')->name('dosen.jadwal.destroy');
    });

    Route::controller(GoogleCalendarController::class)->prefix('dosen')->group(function () {
        Route::get('/google/connect', 'connect')->name('dosen.google.connect');
        Route::get('/google/events', 'getEvents')->name('dosen.google.events');
        Route::get('/google/callback', 'callback')->name('dosen.google.callback');
    });
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
