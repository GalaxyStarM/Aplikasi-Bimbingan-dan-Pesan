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
    <h1 class="mb-2 gradient-text fw-bold">Pilih Jadwal Bimbingan</h1>
    <hr>
    <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
        <a href="/">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </button>

    <form method="POST" action="{{ route('jadwal.store') }}">
        @csrf
        <div class="mb-3">
            <label for="pilihDosen" class="form-label">Pilih Dosen<span style="color: red;">*</span></label>
            <select class="form-select" id="pilihDosen" required>
                <option value="" selected disabled>- Pilih Dosen -</option>
                @foreach($dosenList as $dosen)
                    <option value="{{ $dosen }}">{{ $dosen }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="jenisBimbingan" class="form-label">Pilih Jenis Bimbingan<span style="color: red;">*</span></label>
            <select class="form-select" id="jenisBimbingan" required>
                <option value="" selected disabled>- Pilih Jenis Bimbingan -</option>
                <option value="krs">Kartu Rencana Studi (KRS)</option>
                <option value="kp">Kerja Praktek (KP)</option>
                <option value="mbkm">Merdeka Belajar Kampus Merdeka (MBKM)</option>
                <option value="skripsi">Skripsi</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="pilihTanggal" class="form-label">Pilih Tanggal<span style="color: red;">*</span></label>
            <select class="form-select" id="pilihTanggal" required>
                <option value="" selected disabled>- Pilih Tanggal -</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="pilihJadwal" class="form-label">Pilih Jadwal<span style="color: red;">*</span></label>
            <select class="form-select" id="pilihJadwal" required>
                <option value="" selected disabled>- Pilih Jadwal -</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" rows="5" placeholder="Deskripsi" required></textarea>
        </div>
        
        <div class="text-end">
            <button type="submit" class="btn btn-gradient mb-4 mt-2">
                <a href="/">
                    <i class=""></i>Kirim
                </a>
            </button>
        </div>
    </form>            
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalSelect = document.getElementById('pilihTanggal');
    const jadwalSelect = document.getElementById('pilihJadwal');
    
    function addDays(date, days) {
        const result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }
    
    function formatDate(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }
    
    const today = new Date();
    for (let i = 0; i < 30; i++) {
        const date = addDays(today, i);
        const option = document.createElement('option');
        option.value = formatDate(date);
        option.textContent = formatDate(date);
        tanggalSelect.appendChild(option);
    }

    function populateJadwal(selectedDate) {
        jadwalSelect.innerHTML = '<option value="" selected disabled>- Pilih Jadwal -</option>';

        const jadwalContoh = [
            { waktu: '09:00 - 10:00', tersedia: true },
            { waktu: '10:00 - 11:00', tersedia: false },
            { waktu: '11:00 - 12:00', tersedia: true },
            { waktu: '13:00 - 14:00', tersedia: true },
            { waktu: '14:00 - 15:00', tersedia: false }
        ];

        jadwalContoh.forEach(jadwal => {
            const option = document.createElement('option');
            option.value = jadwal.waktu;
            option.textContent = jadwal.waktu;
            option.disabled = !jadwal.tersedia;
            jadwalSelect.appendChild(option);
        });

        if (jadwalSelect.options.length === 1) {
            const option = document.createElement('option');
            option.value = "";
            option.textContent = "Belum Ada Jadwal";
            option.disabled = true;
            jadwalSelect.appendChild(option);
        }
    }

    tanggalSelect.addEventListener('change', function() {
        populateJadwal(this.value);
    });
});
</script>
@endpush