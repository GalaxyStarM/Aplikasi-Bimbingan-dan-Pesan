<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan ini ada
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\DosenController;

// Route::get('/buatpesan', function () {
//     return view('pesan.mahasiswa.buatpesan');
// });

// Route::get('/isipesan', function () {
//     return view('pesan.mahasiswa.isipesan');
// });

// // Route ke dashboard pesan (dasboarpesan.blade.php)
// Route::get('/dashboardpesan', function () {
//     return view('pesan.dashboardpesan');
// });

// Route::get('/buatpesandosen', function () {
//   return view('pesan.dosen.buatpesandosen');
// });

// Route::get('/isipesandosen', function () {
//   return view('pesan.dosen.isipesandosen');
// });

// Route::get('/contohdashboard', function(){
//   return view('pesan.contohdashboard');
// });

// Route::get('/datausulanbimbingan', function(){
//   return view('bimbingan.admin.datausulanbimbingan');
// });

// Route untuk guest (belum login)
Route::middleware(['guest'])->group(function () {
  Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});


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

  Route::get('/pilihjadwal', [BimbinganController::class, 'create'])->name('jadwal.create');
  Route::post('/pilihjadwal', [BimbinganController::class, 'store'])->name('jadwal.store');

  Route::get('/riwayatmahasiswa', function(){
    return view('bimbingan.riwayatmahasiswa');
  });

  Route::get('/bimbingan/create', [BimbinganController::class, 'create'])->name('bimbingan.create');
    Route::post('/bimbingan', [BimbinganController::class, 'store'])->name('bimbingan.store');

});

Route::middleware(['auth:dosen', 'checkRole:dosen'])->group(function () {
  
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

  // Halaman utama masukkan jadwal
  Route::get('/masukkanjadwal', [DosenController::class, 'index'])
  ->name('dosen.jadwal.index');

  // Google Calendar auth routes
  Route::get('/jadwal', [DosenController::class, 'index'])->name('dosen.jadwal.index');
  Route::get('/google/connect', [DosenController::class, 'connect'])->name('dosen.google.connect');
  Route::get('/dosen/google/callback', [DosenController::class, 'callback'])->name('dosen.google.callback');
  Route::get('/events', [DosenController::class, 'getEvents'])->name('dosen.jadwal.events');
  Route::post('/jadwal', [DosenController::class, 'store'])->name('dosen.jadwal.store');
  Route::delete('/jadwal/{eventId}', [DosenController::class, 'destroy'])->name('dosen.jadwal.destroy');

});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


