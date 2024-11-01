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
            <select class="form-select" id="pilihDosen" name="dosen" required>
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
    const dosenSelect = document.getElementById('pilihDosen');
    const tanggalSelect = document.getElementById('pilihTanggal');
    const jadwalSelect = document.getElementById('pilihJadwal');
    const form = document.querySelector('form');
    
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
    
    // Populate tanggal options
    const today = new Date();
    for (let i = 0; i < 30; i++) {
        const date = addDays(today, i);
        const option = document.createElement('option');
        option.value = formatDate(date);
        option.textContent = formatDate(date);
        tanggalSelect.appendChild(option);
    }

    async function getAvailableSlots() {
        const dosen = dosenSelect.value;
        const tanggal = tanggalSelect.value;
        
        if (!dosen || !tanggal) return;

        try {
            const response = await fetch(`/jadwal/available-slots?dosen_id=${dosen}&tanggal=${tanggal}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const slots = await response.json();
            
            // Reset jadwal select
            jadwalSelect.innerHTML = '<option value="" selected disabled>- Pilih Jadwal -</option>';

            if (slots.error) {
                throw new Error(slots.error);
            }

            if (slots.length === 0) {
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "Belum Ada Jadwal";
                option.disabled = true;
                jadwalSelect.appendChild(option);
                return;
            }

            // Populate available slots
            slots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot.waktu;
                option.textContent = slot.waktu;
                option.disabled = !slot.tersedia;
                jadwalSelect.appendChild(option);
            });

        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mengambil jadwal tersedia: ' + error.message);
        }
    }

    // Event listeners
    dosenSelect.addEventListener('change', getAvailableSlots);
    tanggalSelect.addEventListener('change', getAvailableSlots);

    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const formData = {
                dosen: dosenSelect.value,
                jenis_bimbingan: document.getElementById('jenisBimbingan').value,
                tanggal: tanggalSelect.value,
                jadwal: jadwalSelect.value,
                deskripsi: document.getElementById('deskripsi').value
            };

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (result.success) {
                alert('Jadwal berhasil dibooking!');
                window.location.href = '/dashboard';
            } else {
                throw new Error(result.message);
            }

        } catch (error) {
            console.error('Error:', error);
            alert('Gagal membooking jadwal: ' + error.message);
        }
    });
});
</script>
@endpush