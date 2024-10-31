<!-- File: resources/views/bimbingan/pilih-jadwal.blade.php -->
@extends('layouts.app')

@section('title', 'Pilih Jadwal Bimbingan')

@push('styles')
<style>
    form .form-label {
        font-weight: bold;
    }
    
    select.form-select option {
        color: black;
        font-weight: bold;
    }

    select.form-select option:disabled {
        color: #6c757d;
    }
</style>
@endpush

@section('content')
    <div class="container mt-5">
        <h1 class="mb-2 gradient-text fw-bold">Detail Daftar Bimbingan</h1>
        <hr></hr>
        <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
            <a href="/usulanbimbingan#jadwal">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </button>
    
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white p-0">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link px-4 py-3">Data Bimbingan Edi Susilo, S.Pd., M.Kom., M.Eng.</a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="bimbinganTabContent">
                    <!--Usulan-->
                    <div class="tab-pane fade show active" id="usulan" role="tabpanel" aria-labelledby="usulan-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                Tampilkan 
                                <select class="form-select form-select-sm d-inline-block w-auto">
                                    <option>50</option>
                                </select> 
                                entri
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th class="text-center">No.</th>
                                        <th class="text-center">NIM</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Jenis Bimbingan</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelUsulan">
                                    <tr>
                                        <td colspan="8" class="text-center text-muted fst-italic">Belum ada usulan Bimbingan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3">
                        <p class="mb-2">Menampilkan 1 sampai 1 dari 1 entri</p>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item disabled"><a class="page-link" href="#">Selanjutnya</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Mengambil data dari file JSON
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/dataDummy.json')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('tabelUsulan');
            tableBody.innerHTML = '';

            data.forEach(item => {
                let statusClass = '';
                let statusText = item.status.toUpperCase();
                
                const row = `
                    <tr>
                        <td class="text-center">${item.no}</td>
                        <td class="text-center">${item.nim}</td>
                        <td class="text-center">${item.nama}</td>
                        <td class="text-center">${item.jenis_bimbingan}</td>
                        <td class="text-center">${item.tanggal}</td>
                        <td class="text-center">${item.waktu}</td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endpush