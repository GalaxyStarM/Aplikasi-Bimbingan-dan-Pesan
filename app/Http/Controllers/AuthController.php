<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'identifier' => 'required',
            'password' => 'required',
        ]);

        $identifier = $credentials['identifier'];
        $password = $credentials['password'];

        // Cek mahasiswa
        $user = Mahasiswa::where('nim', $identifier)->first();
        $role = 'mahasiswa';

        if (!$user) {
            // Jika tidak ditemukan di tabel mahasiswa, cek tabel dosen
            $user = Dosen::where('nip', $identifier)->first();
            $role = 'dosen';
        }

        // Verifikasi user dan password
        if(!$user && Hash::check($password, $user->password)) {
            Auth::login($user);
            session(['role' => $role]);

            if($role == 'mahasiswa') {
                return redirect()->intended(route('mahasiswa.usulan_bimbingan'));
            } else {
                return redirect()->intended(route('dosen.persetujuan_bimbingan'));
            }
        }

        // Cek apakah password benar
        if (!Hash::check($password, $user->password)) {
            // Jika password salah
            return back()->withErrors([
                'password' => 'Password salah.',
            ]);
        }
        return back()->withErrors(['identifier' => 'NIM/NIP atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('auth.login');
    }
}