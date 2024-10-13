@extends('layouts.navfooter')

@section('content')
<div class="container">
    <div class="sub-title">
        <h4 class="usulan-bimbingan">Usulan Bimbingan</h4>
        <hr>
    </div>

    <!-- Tombol untuk memilih jadwal bimbingan -->
    <button class="btn btn-success mb-4">+ Pilih Jadwal Bimbingan</button>

    <!-- Tabel usulan bimbingan -->
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Usulan Bimbingan (1)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Daftar Jadwal (3)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Riwayat (0)</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-dark">
                                <th class="text-center sorting">
                                    
                                    Nomor</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Jenis Bimbingan</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data dummy sementara -->
                            <tr>
                                <td>1</td>
                                <td>2101701025</td>
                                <td>Syahriah Tri Melika</td>
                                <td>Bimbingan Skripsi</td>
                                <td>30 September 2024</td>
                                <td>13:30 - 15:00</td>
                                <td><span class="badge bg-info text-white">Usulan Diterima</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
