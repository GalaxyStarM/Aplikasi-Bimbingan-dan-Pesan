<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    private $dosenList = [
        'Yusnita Rahayu, ST, M.Eng, Ph.D',
        'Feri Candra, S.T., M.T., Ph.D',
        'Rahmat Rizal Andhi, S.T., M.Τ.',
        'Edi Susilo, S.Pd., M.Kom., M.Eng.',
        'Dahliyusmanto S.Kom., MSc., Ph.D',
        'Dr. Irsan Taufik Ali, S.T., Μ.Τ.',
        'Rahyul Amri, S.T., M.T.',
        'T. Yudi Hadiwandra, S.Kom., M.Kom.',
        'Salhazan Nasution, S.Kom., MIT.',
        'Noveri Lysbetti Marpaung, ST., M.Sc.',
        'Linna Oktaviana Sari, ST., MT',
        'Dian Ramadhani, S.T., M.T.',
        'Prof. Azriyenni, S.T., M.Eng., Ph.D',
        'Iswadi HR, S.T., M.T., Ph.D.',
        'Dr. Febrizal, S.T., M.T.',
        'Dr. Ir. Antonius Rajagukguk, M.T.',
        'Indra Yasri, S.T., M.T., Ph.D',
        'Suwitno, S.T., Μ.Τ.',
        'Nurhalim S.T., M.T.',
        'Dian Yayan Sukma, S.T., M.Τ.',
        'Ery Safrianti, S.T., M.T.',
        'Feranita, S.T., M.T.',
        'R.A Rizka Qori Yuliani Putri S.ST., MT.',
        'Dr. Fri Murdiya, S.T., M.T.',
        'Ir. Edy Ervianto, M.T.',
        'Eddy Hamdani, S.T., M.T.',
        'Budhi Anto, S.T., MT.',
        'Anhar, S.T., M.T., Ph.D.',
        'Amir Hamzah, ST., MT',
        'Dr. Dewi Nasien., M.Sc',
        'Dr. Esa Prakasa, MT',
        'Assoc. Prof. Ping Jack Soh, PhD',
        'Yudi Yulius Maulana, ST., MT',
        'Yussi Perdana Saputra S.T., M.T., IPM., Asean-Eng',
        'Teguh Praludi, M.T',
        'Arbiansyah Ali',
        'Prof. Dr. Ing. Mudrik Alaydrus',
        'Dr Eng Teguh Firmansyah, ST., MT., IPM',
        'Dr. HUANYU LARRY CHENG',
        'Prof. Chia Hao Ku Ph.D'
    ];

    public function create()
    {
        return view('bimbingan.mahasiswa.pilihjadwal', [
            'dosenList' => $this->dosenList
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pilihDosen' => 'required',
            'jenisBimbingan' => 'required',
            'pilihTanggal' => 'required',
            'pilihJadwal' => 'required',
            'deskripsi' => 'required'
        ]);

        // Logika penyimpanan data akan ditambahkan di sini

        return redirect('/')->with('success', 'Jadwal bimbingan berhasil diajukan');
    }
}
