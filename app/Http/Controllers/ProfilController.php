<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'mahasiswa') {
            $profile = Mahasiswa::where('nim', $user->nim)->first();
        } else {
            $profile = Dosen::where('nip', $user->nip)->first();
        }

        return view('bimbingan.mahasiswa.profilmahasiswa', compact('profile', 'role'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $role = $user->role;

        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            if ($role === 'mahasiswa') {
                $profile = Mahasiswa::where('nim', $user->nim)->first();
                $identifier = $user->nim;
            } else {
                $profile = Dosen::where('nip', $user->nip)->first();
                $identifier = $user->nip;
            }

            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($profile->foto && Storage::disk('public')->exists('foto_profil/' . $profile->foto)) {
                    Storage::disk('public')->delete('foto_profil/' . $profile->foto);
                }

                // Upload foto baru
                $file = $request->file('foto');
                $filename = $identifier . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('foto_profil', $filename, 'public');

                $profile->update(['foto' => $filename]);
            }

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui foto profil');
        }
    }

    public function remove()
    {
        $user = auth()->user();
        $role = $user->role;

        try {
            if ($role === 'mahasiswa') {
                $profile = Mahasiswa::where('nim', $user->nim)->first();
            } else {
                $profile = Dosen::where('nip', $user->nip)->first();
            }

            if ($profile->foto && Storage::disk('public')->exists('foto_profil/' . $profile->foto)) {
                Storage::disk('public')->delete('foto_profil/' . $profile->foto);
            }

            $profile->update(['foto' => null]);

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus foto profil');
        }
    }
}