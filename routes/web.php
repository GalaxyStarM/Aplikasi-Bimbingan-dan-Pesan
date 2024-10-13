<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan ini ada

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', function () {
    return redirect('/login');
});

Route::get('/dashboardpesan', function () {
  return view('dasboarpesan');
});

Route::get('/isipesan', function () {
    return view('isipesan'); // Pastikan ini merujuk ke file isipesan.blade.php
});

Route::get('/', function () {
    return view('bimbingan.usulanbimbingan');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
