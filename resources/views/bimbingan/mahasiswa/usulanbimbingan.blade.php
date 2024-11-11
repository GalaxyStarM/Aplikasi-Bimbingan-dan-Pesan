{{-- resources/views/bimbingan/mahasiswa/usulanbimbingan.blade.php --}}
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

    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        color: #2563eb;
        border: 1px solid #e5e7eb;
        padding: 0.5rem 0.75rem;
    }
    
    .page-link:hover {
        color: #1d4ed8;
        background-color: #f3f4f6;
    }
    
    .page-item.active .page-link {
        background-color: #2563eb;
        border-color: #2563eb;
    }
    
    .page-item.disabled .page-link {
        color: #9ca3af;
        background-color: #ffffff;
        border-color: #e5e7eb;
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
                    <a href="{{ route('mahasiswa.usulanbimbingan', ['tab' => 'usulan', 'per_page' => request('per_page', 10)]) }}" 
                       class="nav-link px-4 py-3 {{ $activeTab == 'usulan' ? 'active' : '' }}">
                        Usulan Bimbingan
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('mahasiswa.usulanbimbingan', ['tab' => 'jadwal', 'per_page' => request('per_page', 10)]) }}" 
                       class="nav-link px-4 py-3 {{ $activeTab == 'jadwal' ? 'active' : '' }}">
                        Daftar Jadwal
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('mahasiswa.usulanbimbingan', ['tab' => 'riwayat', 'per_page' => request('per_page', 10)]) }}" 
                       class="nav-link px-4 py-3 {{ $activeTab == 'riwayat' ? 'active' : '' }}">
                        Riwayat
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <label class="me-2">Tampilkan</label>
                        <select class="form-select form-select-sm w-auto" 
                                onchange="window.location.href='{{ route('mahasiswa.usulanbimbingan', ['tab' => $activeTab]) }}&per_page=' + this.value">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            <option value="150" {{ request('per_page') == 150 ? 'selected' : '' }}>150</option>
                        </select>
                        <label class="ms-2">entries</label>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="bimbinganTabContent">
                @if($activeTab == 'usulan')
                <div class="tab-pane fade show active" id="usulan" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Jenis Bimbingan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($usulan as $index => $item)
                                <tr class="text-center">
                                    <td>{{ ($usulan->currentPage() - 1) * $usulan->perPage() + $loop->iteration }}</td>
                                    <td>{{ $item->nim }}</td>
                                    <td>{{ $item->mahasiswa_nama }}</td>
                                    <td>{{ ucfirst($item->jenis_bimbingan) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}</td>
                                    <td>{{ $item->lokasi ?? '-' }}</td>
                                    <td class="fw-bold bg-{{ $item->status === 'DISETUJUI' ? 'success' : 
                                        ($item->status === 'DITOLAK' ? 'danger' : 'warning') }}">
                                        {{ $item->status }}
                                    </td>
                                    <td>
                                        @if($item->status === 'DISETUJUI')
                                            <div class="d-flex gap-2 justify-content-center">
                                                <button class="btn btn-sm btn-success selesai-btn" 
                                                        data-id="{{ $item->id }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalSelesai"
                                                        title="Selesai">
                                                    <i class="bi bi-check2-circle"></i>
                                                </button>
                                                <a href="{{ route('mahasiswa.aksiInformasi', $item->id) }}" 
                                                class="btn btn-sm btn-info"
                                                title="Info">
                                                    <i class="bi bi-info-circle"></i>
                                                </a>
                                            </div>
                                        @else
                                            <a href="{{ route('mahasiswa.aksiInformasi', $item->id) }}" 
                                            class="btn btn-sm btn-info"
                                            title="Info">
                                                <i class="bi bi-info-circle"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data usulan bimbingan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                @if($activeTab == 'jadwal')
                <div class="tab-pane fade show active" id="jadwal" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>NIP</th>
                                    <th>Nama Dosen</th>
                                    <th>Total Bimbingan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($daftarDosen as $index => $dosen)
                                <tr class="text-center">
                                    <td>{{ ($daftarDosen->currentPage() - 1) * $daftarDosen->perPage() + $loop->iteration }}</td>
                                    <td>{{ $dosen->nip }}</td>
                                    <td>{{ $dosen->nama }}</td>
                                    <td>{{ $dosen->total_bimbingan }}</td>
                                    <td>
                                        <a href="{{ route('mahasiswa.detaildaftar', $dosen->nip) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data dosen</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                @if($activeTab == 'riwayat')
                <div class="tab-pane fade show active" id="riwayat" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Jenis Bimbingan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $index => $item)
                                <tr class="text-center">
                                    <td>{{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y') }}</td>
                                    <td>{{ $item->dosen_nama }}</td>
                                    <td>{{ ucfirst($item->jenis_bimbingan) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}</td>
                                    <td>{{ $item->lokasi && trim($item->lokasi) !== '' ? $item->lokasi : '-' }}</td>
                                    <td class="fw-bold {{ $item->status === 'SELESAI' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->status }}
                                    </td>
                                    <td>
                                        <a href="{{ route('mahasiswa.aksiInformasi', $item->id) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada riwayat bimbingan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3">
                <p class="mb-2">
                    @if($activeTab == 'usulan' && $usulan->total() > 0)
                        Menampilkan {{ $usulan->firstItem() }} sampai {{ $usulan->lastItem() }} dari {{ $usulan->total() }} entri
                    @elseif($activeTab == 'jadwal' && $daftarDosen->total() > 0)
                        Menampilkan {{ $daftarDosen->firstItem() }} sampai {{ $daftarDosen->lastItem() }} dari {{ $daftarDosen->total() }} entri
                    @elseif($activeTab == 'riwayat' && $riwayat->total() > 0)
                        Menampilkan {{ $riwayat->firstItem() }} sampai {{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} entri
                    @endif
                </p>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end mb-0">
                        {{-- Previous Page --}}
                        @if($activeTab == 'usulan')
                            @if($usulan->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Sebelumnya</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $usulan->previousPageUrl() }}&tab=usulan">Sebelumnya</a>
                                </li>
                            @endif
                            
                            {{-- Page Numbers --}}
                            @foreach($usulan->getUrlRange(1, $usulan->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $usulan->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}&tab=usulan">{{ $page }}</a>
                                </li>
                            @endforeach
                            
                            {{-- Next Page --}}
                            @if($usulan->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $usulan->nextPageUrl() }}&tab=usulan">Selanjutnya</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Selanjutnya</span>
                                </li>
                            @endif
                        @elseif($activeTab == 'jadwal')
                            @if($daftarDosen->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Sebelumnya</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $daftarDosen->previousPageUrl() }}&tab=jadwal">Sebelumnya</a>
                                </li>
                            @endif
                            
                            @foreach($daftarDosen->getUrlRange(1, $daftarDosen->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $daftarDosen->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}&tab=jadwal">{{ $page }}</a>
                                </li>
                            @endforeach
                            
                            @if($daftarDosen->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $daftarDosen->nextPageUrl() }}&tab=jadwal">Selanjutnya</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Selanjutnya</span>
                                </li>
                            @endif
                        @elseif($activeTab == 'riwayat')
                            @if($riwayat->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Sebelumnya</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $riwayat->previousPageUrl() }}&tab=riwayat">Sebelumnya</a>
                                </li>
                            @endif
                            
                            @foreach($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $riwayat->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}&tab=riwayat">{{ $page }}</a>
                                </li>
                            @endforeach
                            
                            @if($riwayat->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $riwayat->nextPageUrl() }}&tab=riwayat">Selanjutnya</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Selanjutnya</span>
                                </li>
                            @endif
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Modal Selesai -->
<div class="modal fade" id="modalSelesai" tabindex="-1" aria-labelledby="modalSelesaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="modalSelesaiLabel">
                    <i class="bi bi-check2-circle text-success me-2"></i>
                    Konfirmasi Selesai Bimbingan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-success" id="confirmSelesai">
                    <i class="bi bi-check2-circle me-2"></i>Selesai
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentId = null;
    const modalSelesai = new bootstrap.Modal(document.getElementById('modalSelesai'));

    // Setup modal handler untuk tombol selesai
    document.querySelectorAll('.selesai-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            currentId = this.getAttribute('data-id');
            modalSelesai.show();
        });
    });

    // Handle konfirmasi selesai
    document.getElementById('confirmSelesai')?.addEventListener('click', async function() {
        if (!currentId) return;
        
        try {
            // Show loading state
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

            const response = await fetch(`/usulanbimbingan/selesai/${currentId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Close modal
                modalSelesai.hide();

                // Show success notification
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: error.message || 'Terjadi kesalahan saat memproses usulan'
            });
        } finally {
            // Reset button state
            this.disabled = false;
            this.innerHTML = '<i class="bi bi-check2-circle me-2"></i>Selesai';
        }
    });

    // Reset currentId when modal is closed
    document.getElementById('modalSelesai')?.addEventListener('hidden.bs.modal', function() {
        currentId = null;
    });
});
</script>
@endpush
@endsection