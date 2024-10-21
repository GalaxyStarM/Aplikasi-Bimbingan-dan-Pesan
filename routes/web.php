<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan ini ada

// Route ke halaman login
Route::get('/login', function () {
  return redirect('/login');
});

Route::get('/isipesan', function () {
    return view('pesan.isipesan');
});

Route::get('/tampilanisipesan', function () {
    return view('pesan.tampilanisipesan');
});

// Route ke dashboard pesan (dasboarpesan.blade.php)
Route::get('/dashboardpesan', function () {
    return view('pesan.dasboarpesan');
});

Route::get('/', function () {
  return view('bimbingan.usulanbimbingan');
});

Route::get('/aksiInformasi', function(){
  return view('aksiInformasi');
});

Route::get('/pilihjadwal', function(){
  return view('bimbingan.pilihjadwal');
});

Route::get('/terimausulanbimbingan', function(){
  return view('dosen.terimausulanbimbingan');
});

Route::get('/editusulan', function(){
  return view('dosen.editusulan');
});

Route::get('/masukkanjadwal', function(){
  return view('dosen.masukkanjadwal');
});

Route::get('/persetujuan', function(){
  return view('dosen.persetujuan');
});

Route::get('/dashboard', function(){
  return view('bimbinganc.usulanbimbingan');
});

// Route ke halaman login dengan AuthController
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//view halaman
Route::get('/pilihjadwal', function () { return view('bimbingan.pilihjadwal');})->name('pilihjadwal');
Route::get('/masukkanjadwal', function () { return view('dosen.masukkanjadwal');})->name('masukkanjadwal');

