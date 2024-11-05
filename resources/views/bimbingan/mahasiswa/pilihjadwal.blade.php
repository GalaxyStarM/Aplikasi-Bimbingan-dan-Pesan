@extends('layouts.app')

@section('title', 'Pilih Jadwal Bimbingan')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
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
    <h1 class="mb-2 gradient-text fw-bold">Pilih Jadwal Bimbingan</h1>
    <hr>
    <button class="btn btn-gradient mb-4 mt-2">
        <a href="/usulanbimbingan" class="d-flex align-items-center justify-content-center">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </button>

    <form method="POST" action="{{ route('pilihjadwal.store') }}" id="formBimbingan">
        @csrf
        <div class="mb-3">
            <label for="pilihDosen" class="form-label">Pilih Dosen<span style="color: red;">*</span></label>
            <select class="form-select" id="pilihDosen" name="nip" required>
                <option value="" selected disabled>- Pilih Dosen -</option>
                @foreach($dosenList as $dosen)
                    <option value="{{ $dosen['nip'] }}">{{ $dosen['nama'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jenisBimbingan" class="form-label">Pilih Jenis Bimbingan<span style="color: red;">*</span></label>
            <select class="form-select" id="jenisBimbingan" name="jenis_bimbingan" required>
                <option value="" selected disabled>- Pilih Jenis Bimbingan -</option>
                <option value="skripsi">Bimbingan Skripsi</option>
                <option value="kp">Bimbingan KP</option>
                <option value="akademik">Bimbingan Akademik</option>
                <option value="konsultasi">Konsultasi Pribadi</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="pilihJadwal" class="form-label">Pilih Jadwal<span style="color: red;">*</span></label>
            <select class="form-select" id="pilihJadwal" name="jadwal_id" required>
                <option value="" selected disabled>- Pilih Dosen Terlebih Dahulu -</option>
            </select>
            <small class="text-muted">Menampilkan jadwal yang masih tersedia</small>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi<small class="text-muted"> (Opsional)</small></label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" 
                placeholder="Tuliskan deskripsi atau topik bimbingan Anda" required></textarea>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-gradient">
                <i class="fas fa-paper-plane me-2"></i>Kirim
            </button>
        </div>
    </form>            
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dosenSelect = document.getElementById('pilihDosen');
    const jadwalSelect = document.getElementById('pilihJadwal');
    const jenisBimbinganSelect = document.getElementById('jenisBimbingan');
    const form = document.getElementById('formBimbingan');
    
    // Fungsi untuk menampilkan pesan dengan SweetAlert2
    const tampilkanPesan = (icon, title, text) => {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            confirmButtonColor: '#1a73e8'
        });
    };

    async function getAvailableJadwal() {
        const nip = dosenSelect.value;
        const jenisBimbingan = jenisBimbinganSelect.value;
        
        if (!nip || !jenisBimbingan) {
            jadwalSelect.innerHTML = '<option value="" selected disabled>Pilih dosen dan jenis bimbingan terlebih dahulu</option>';
            return;
        }

        try {
            jadwalSelect.innerHTML = '<option value="" selected disabled>Memuat jadwal...</option>';
            
            const response = await fetch(`/pilihjadwal/available?nip=${nip}&jenis_bimbingan=${jenisBimbingan}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const result = await response.json();
            
            jadwalSelect.innerHTML = '<option value="" selected disabled>- Pilih Jadwal -</option>';

            if (result.status === 'success') {
                const jadwalList = result.data;
                
                if (jadwalList.length === 0) {
                    jadwalSelect.innerHTML = '<option value="" disabled>Belum ada jadwal tersedia</option>';
                    tampilkanPesan('info', 'Informasi', 'Belum ada jadwal tersedia untuk dosen ini');
                    return;
                }

                jadwalList.forEach(jadwal => {
                    // Skip jadwal yang sudah pernah dipilih oleh mahasiswa
                    if (jadwal.is_selected) {
                        const option = document.createElement('option');
                        option.value = jadwal.id;
                        option.textContent = `${jadwal.tanggal} | ${jadwal.waktu}`;
                        option.disabled = true;
                        option.textContent += ' (Sudah dipilih)';
                        jadwalSelect.appendChild(option);
                    } else {
                        const option = document.createElement('option');
                        option.value = jadwal.id;
                        option.textContent = `${jadwal.tanggal} | ${jadwal.waktu}`;
                        if (jadwal.sisa_kapasitas) {
                            option.textContent += ` (Sisa Kuota: ${jadwal.sisa_kapasitas})`;
                        }
                        jadwalSelect.appendChild(option);
                    }
                });
            } else {
                throw new Error(result.message);
            }

        } catch (error) {
            console.error('Error:', error);
            jadwalSelect.innerHTML = '<option value="" disabled>Gagal memuat jadwal</option>';
            tampilkanPesan('error', 'Gagal', 'Tidak dapat memuat jadwal: ' + error.message);
        }
    }

    // Panggil getAvailableJadwal saat dosen atau jenis bimbingan berubah
    dosenSelect.addEventListener('change', getAvailableJadwal);
    jenisBimbinganSelect.addEventListener('change', getAvailableJadwal);

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            // Validasi form
            const formData = new FormData(form);
            const jadwalId = formData.get('jadwal_id');
            const jenisBimbingan = formData.get('jenis_bimbingan');
            
            // Cek apakah sudah pernah mengajukan bimbingan yang sama
            const checkResponse = await fetch(`/pilihjadwal/check?jadwal_id=${jadwalId}&jenis_bimbingan=${jenisBimbingan}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            const checkResult = await checkResponse.json();
            
            if (!checkResult.available) {
                tampilkanPesan('warning', 'Tidak Dapat Mengajukan', 
                    'Anda sudah pernah mengajukan bimbingan untuk jadwal ini atau jenis bimbingan yang sama masih dalam proses');
                return;
            }

            // Tampilkan loading saat mengirim data
            Swal.fire({
                title: 'Memproses',
                text: 'Mohon tunggu...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(Object.fromEntries(formData))
            });

            const result = await response.json();

            if (result.status === 'success') {
                // Tampilkan pesan sukses dan langsung redirect
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pengajuan bimbingan telah berhasil dikirim',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '/usulanbimbingan';
                });
            } else {
                throw new Error(result.message);
            }

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal mengajukan bimbingan: ' + error.message,
                confirmButtonColor: '#1a73e8'
            });
        }
    });
});
</script>
@endpush