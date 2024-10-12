<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'identifier' => ['required'],
            'password' => ['required'],
        ]);

        $identifier = $credentials['identifier'];
        $password = $credentials['password'];

        // Cek apakah user ada berdasarkan NIM atau NIP
        $user = User::where('nim', $identifier)->orWhere('nip', $identifier)->first();

        if (!$user) {
            // Jika NIM/NIP tidak ditemukan
            return back()->withErrors([
                'identifier' => 'NIP/NIM tidak ditemukan.',
            ]);
        }

        // Cek apakah password benar
        if (!Hash::check($password, $user->password)) {
            // Jika password salah
            return back()->withErrors([
                'password' => 'Password salah.',
            ]);
        }

        // Jika kredensial benar, lakukan login
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect sesuai role
        if ($user->isDosen()) {
            return redirect()->route('dosen.persetujuan_bimbingan');
        } else {
            return redirect()->route('mahasiswa.usulan_bimbingan');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}