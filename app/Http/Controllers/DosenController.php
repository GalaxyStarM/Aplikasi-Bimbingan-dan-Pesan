<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function persetujuanBimbingan()
    {
        return view('dosen.persetujuan_bimbingan');
    }
}
