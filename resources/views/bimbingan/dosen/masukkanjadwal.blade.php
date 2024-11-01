@extends('layouts.app')

@section('title', 'Masukkan Jadwal')

@push('styles')
<style>
    .form-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .form-select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #fff;
    }

    .calendar-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        padding: 20px;
        position: relative;
    }

    .calendar-wrapper {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
    }

    .calendar-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    .btn-action {
        background: #1a73e8;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-action:hover {
        background: #1557b0;
    }

    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background: #fff;
        padding: 24px;
        border-radius: 8px;
        width: 90%;
        max-width: 400px;
    }

    .modal-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .modal-buttons {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 24px;
    }

    .btn-confirm {
        background: #1a73e8;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-cancel {
        background: #dc3545;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .calendar-wrapper {
            padding-bottom: 75%; /* Adjusted for mobile */
        }
    }
</style>
@endpush

@section('content')
<div class="container mt-5">
    <div class="container mt-5">
    <h1 class="mb-2 gradient-text fw-bold">Masukkan Jadwal Bimbingan</h1>
    <hr>
    <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
        <a href="{{ url('/persetujuan') }}">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </button>
    
    <!-- Cek apakah sudah pernah terhubung ke Google Calendar -->
    @if(!Auth::guard('dosen')->user()->googleToken)
        <div class="alert alert-info">
            <p>Untuk menggunakan fitur ini, Anda perlu memberikan izin akses ke Google Calendar dengan email: <strong>{{ Auth::guard('dosen')->user()->email }}</strong></p>
            <a href="{{ route('dosen.google.connect') }}" class="btn btn-primary">
                Izinkan Akses Google Calendar
            </a>
        </div>
    @else
        <div class="form-container">
            <form id="scheduleForm">
                <div class="mb-3">
                    <label class="form-label">Pilih Kegiatan<span class="text-danger">*</span></label>
                    <select class="form-select" id="pilihKegiatan" required>
                        <option value="" selected disabled>- Pilih Kegiatan -</option>
                        <option value="krs">Kartu Rencana Studi (KRS)</option>
                        <option value="kp">Kerja Praktek (KP)</option>
                        <option value="mbkm">Merdeka Belajar Kampus Merdeka (MBKM)</option>
                        <option value="skripsi">Skripsi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pilih Jadwal<span class="text-danger">*</span></label>
                    <div class="calendar-container">
                        <div class="calendar-wrapper">
                            <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FJakarta&showTitle=0&showNav=1&showDate=1&showPrint=0&showTabs=1&showCalendars=0&showTz=0" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn-action">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>

<!-- Modal tetap sama -->
<div id="saveModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Simpan Jadwal Bimbingan?</h5>
            <p class="text-muted">Apakah Anda Yakin?</p>
        </div>
        <div class="modal-buttons">
            <button id="confirmSave" class="btn-confirm">Simpan</button>
            <button id="cancelSave" class="btn-cancel">Batal</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://apis.google.com/js/api.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedDateTime = null;
    let isInitialized = false;

    function initGoogleCalendar() {
        return new Promise((resolve, reject) => {
            gapi.load('client:auth2', async () => {
                try {
                    await gapi.client.init({
                        apiKey: '{{ config("google-calendar.api_key") }}',
                        clientId: '{{ config("google-calendar.client_id") }}',
                        discoveryDocs: ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"],
                        scope: "https://www.googleapis.com/auth/calendar.events"
                    });

                    // Cek status auth setelah inisialisasi
                    if (!isInitialized) {
                        isInitialized = true;
                        const authInstance = gapi.auth2.getAuthInstance();
                        authInstance.isSignedIn.listen(updateSigninStatus);
                        updateSigninStatus(authInstance.isSignedIn.get());
                    }

                    resolve();
                } catch (error) {
                    console.error('Error initializing Google Calendar:', error);
                    reject(error);
                }
            });
        });
    }

    async function updateSigninStatus(isSignedIn) {
        if (!isSignedIn) {
            try {
                // Redirect ke halaman connect jika belum sign in
                window.location.href = '{{ route("dosen.google.connect") }}';
            } catch (error) {
                console.error('Sign in error:', error);
            }
        }
    }

    // Pasang event listener untuk pesan dari iframe
    window.addEventListener('message', function(event) {
        // Verifikasi origin
        if (event.origin !== "https://calendar.google.com") return;
        
        if (event.data.action === "select") {
            selectedDateTime = event.data.dates[0];
            console.log('Selected date/time:', selectedDateTime);
        }
    });

    // Function untuk menambah event dengan error handling
    async function addEventToGoogleCalendar(event) {
        try {
            const authInstance = gapi.auth2.getAuthInstance();
            if (!authInstance.isSignedIn.get()) {
                await authInstance.signIn();
            }

            const response = await gapi.client.calendar.events.insert({
                'calendarId': 'primary',
                'resource': event
            });
            
            console.log('Event created:', response.result);
            return response.result;
        } catch (error) {
            console.error('Error creating event:', error);
            throw new Error('Gagal membuat jadwal: ' + error.message);
        }
    }

    // Form handling
    const form = document.getElementById('scheduleForm');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const kegiatan = document.getElementById('pilihKegiatan').value;
        if (!kegiatan) {
            alert('Silakan pilih kegiatan terlebih dahulu');
            return;
        }

        if (!selectedDateTime) {
            alert('Silakan pilih tanggal dan waktu di kalender');
            return;
        }

        try {
            const startTime = new Date(selectedDateTime);
            const endTime = new Date(startTime);
            endTime.setHours(startTime.getHours() + 1);

            const event = {
                'summary': `Bimbingan ${kegiatan.toUpperCase()}`,
                'description': 'Jadwal bimbingan mahasiswa',
                'start': {
                    'dateTime': startTime.toISOString(),
                    'timeZone': 'Asia/Jakarta'
                },
                'end': {
                    'dateTime': endTime.toISOString(),
                    'timeZone': 'Asia/Jakarta'
                },
                'reminders': {
                    'useDefault': false,
                    'overrides': [
                        {'method': 'email', 'minutes': 24 * 60},
                        {'method': 'popup', 'minutes': 30}
                    ]
                }
            };

            const result = await addEventToGoogleCalendar(event);
            alert('Jadwal berhasil ditambahkan!');
            
            // Refresh kalender
            const calendarFrame = document.querySelector('.calendar-wrapper iframe');
            calendarFrame.src = calendarFrame.src;
            
        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'Terjadi kesalahan saat menyimpan jadwal');
        }
    });

    // Initialize Google Calendar
    initGoogleCalendar();
});
</script>
@endpush