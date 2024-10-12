<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function usulanBimbingan()
    {
        return view('mahasiswa.usulan_bimbingan');
    }
}
