<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan ini ada
use App\Http\Controllers\JadwalController;

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

  Route::get('/pilihjadwal', [JadwalController::class, 'create'])->name('jadwal.create');
  Route::post('/pilihjadwal', [JadwalController::class, 'store'])->name('jadwal.store');

  Route::get('/riwayatmahasiswa', function(){
    return view('bimbingan.riwayatmahasiswa');
  });

  Route::get('/profilmahasiswa', function(){
    return view('bimbingan.mahasiswa.profilmahasiswa');
  });

  Route::get('/gantipassword', function(){
    return view('bimbingan.mahasiswa.gantipassword');
  });

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

  Route::get('/masukkanjadwal', function(){
    return view('bimbingan.dosen.masukkanjadwal');
  });

});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


