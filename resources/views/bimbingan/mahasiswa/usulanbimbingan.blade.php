<!-- File: resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard Bimbingan')

@push('styles')
<style>
    .gradient-text {
        background: linear-gradient(to right, #059669, #2563eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .btn-gradient {
        background: linear-gradient(to right, #4ade80, #3b82f6);
        border: none;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative; 
        z-index: 1; 
        cursor: pointer; 
    }
    
    .btn-gradient a {
        color: white;
        text-decoration: none;
    }
    
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btn-gradient:hover a {
        color: black;
    }
</style>
@endpush

@section('content')
<div class="container mt-5">
    <h1 class="mb-2 gradient-text fw-bold">Usulan Bimbingan</h1>
    <hr>
    <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
        <a href="/pilihjadwal">
            <i class="bi bi-plus-lg me-2"></i> Pilih Jadwal Bimbingan
        </a>
    </button>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white p-0">
            <ul class="nav nav-tabs" id="bimbinganTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active px-4 py-3" id="usulan-tab" data-bs-toggle="tab" data-bs-target="#usulan" type="button" role="tab" aria-controls="usulan" aria-selected="true">
                        Usulan Bimbingan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-3" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button" role="tab" aria-controls="jadwal" aria-selected="false">
                        Daftar Jadwal
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-3" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab" aria-controls="riwayat" aria-selected="false">
                        Riwayat
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="bimbinganTabContent">
                <!-- Usulan Tab -->
                <div class="tab-pane fade show active" id="usulan" role="tabpanel" aria-labelledby="usulan-tab">
                    @include('components.tabs.usulan')
                </div>

                <!-- Jadwal Tab -->
                <div class="tab-pane fade" id="jadwal" role="tabpanel" aria-labelledby="jadwal-tab">
                    @include('components.tabs.jadwal')
                </div>

                <!-- Riwayat Tab -->
                <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                    @include('components.tabs.riwayat')
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash) {
        const tabId = hash.replace('#', '');
        const tabEl = document.querySelector(`#bimbinganTab button[data-bs-target="#${tabId}"]`);
        if (tabEl) {
            const tab = new bootstrap.Tab(tabEl);
            tab.show();
        }
    }

    fetch('/dataDummy.json')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('tabelUsulan');
            if(!data || data.length === 0) return;
            
            tableBody.innerHTML = '';

            data.forEach(item => {
                let statusClass = '';
                let statusText = item.status.toUpperCase();
                
                if (statusText === 'DISETUJUI') {
                    statusClass = 'bg-info';
                } else if (statusText === 'DITOLAK') {
                    statusClass = 'bg-danger';
                } else if (statusText === 'USULAN') {
                    statusClass = 'bg-warning';
                }
                
                const row = `
                    <tr>
                        <td class="text-center">${item.no}</td>
                        <td class="text-center">${item.nim}</td>
                        <td class="text-center">${item.nama}</td>
                        <td class="text-center">${item.jenis_bimbingan}</td>
                        <td class="text-center">${item.tanggal}</td>
                        <td class="text-center">${item.waktu}</td>
                        <td class="text-center">${item.lokasi}</td>
                        <td class="text-center ${statusClass}" style="color: white;">${statusText}</td>
                        <td class="text-center">
                            <a href="/aksiInformasi" class="badge btn btn-info p-1 mb-1">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endpush