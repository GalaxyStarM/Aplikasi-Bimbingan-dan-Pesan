<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan ini ada

// Route ke halaman login
Route::get('/login', function () {
  return redirect('/login');
});

Route::get('/buatpesan', function () {
    return view('pesan.mahasiswa.buatpesan');
});

Route::get('/isipesan', function () {
    return view('pesan.mahasiswa.isipesan');
});

// Route ke dashboard pesan (dasboarpesan.blade.php)
Route::get('/dashboardpesan', function () {
    return view('pesan.dashboardpesan');
});

Route::get('/', function () {
  return view('bimbingan.mahasiswa.usulanbimbingan');
});

Route::get('/isipesandosen', function () {
  return view('pesan.dosen.isipesandosen');
});

Route::get('/aksiInformasi', function(){
  return view('bimbingan.aksiInformasi');
});

Route::get('/riwayatmahasiswa', function(){
  return view('bimbingan.riwayatmahasiswa');
});

Route::get('/riwayatdosen', function(){
  return view('bimbingan.riwayatdosen');
});

Route::get('/pilihjadwal', function(){
  return view('bimbingan.mahasiswa.pilihjadwal');
})->name('pilihjadwal');

Route::get('/detaildaftar', function(){
  return view('bimbingan.mahasiswa.detaildaftar');
})->name('pilihjadwal');

Route::get('/terimausulanbimbingan', function(){
  return view('bimbingan.dosen.terimausulanbimbingan');
});

Route::get('/editusulan', function(){
  return view('bimbingan.dosen.editusulan');
});

Route::get('/masukkanjadwal', function(){
  return view('bimbingan.dosen.masukkanjadwal');
});

Route::get('/persetujuan', function(){
  return view('bimbingan.dosen.persetujuan');
});


// Route ke halaman login dengan AuthController
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//view halaman
Route::get('/masukkanjadwal', function () { return view('bimbingan.dosen.masukkanjadwal');})->name('masukkanjadwal');

