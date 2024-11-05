@extends('layouts.app')

@section('title', 'Masukkan Jadwal Bimbingan')

@push('styles')
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
<style>
    /* Event Styling */
    .external-event {
        background-color: #9e9e9e !important;
        border-color: #757575 !important;
        color: #000 !important;
        font-style: italic;
    }

    .fc-event {
        border: none !important;
        padding: 2px 4px !important;
        margin: 2px !important;
        border-radius: 4px !important;
    }

    /* Base Styles */
    :root {
        --fc-button-text-color: #3c4043;
        --fc-button-bg-color: #fff;
        --fc-button-border-color: #dadce0;
        --fc-button-hover-bg-color: #f1f3f4;
        --fc-button-hover-border-color: #dadce0;
        --fc-button-active-bg-color: #e8f0fe;
        --fc-button-active-border-color: #1a73e8;
    }

    .fc-day-header, 
    .fc-day-number,
    .fc-daygrid-day-number {
        color: #000 !important;
    }

    /* Hapus dekorasi text */
    .fc a {
        text-decoration: none !important;
    }

    .fc-toolbar-title {
        text-decoration: none !important;
    }

    /* Container Kalender */
    .calendar-container {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 30px;
    }

    .calendar-header {
        margin-bottom: 20px;
    }

    .calendar-header h1 {
        color: #1a73e8;
        font-size: 24px;
        font-weight: 600;
    }

    /* Styling Kalender */
    #calendar {
        background: #fff;
        border-radius: 8px;
        min-height: 700px;
    }

    /* Toolbar Styling */
    .fc .fc-toolbar {
        padding: 16px;
        background: #fff;
        border-bottom: 1px solid #dadce0;
    }

    .fc .fc-toolbar-title {
        font-size: 22px !important;
        color: #3c4043;
        font-weight: 400;
    }

    /* Button Styling */
    .fc .fc-button {
        border-radius: 4px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        height: 36px !important;
        padding: 0 16px !important;
        text-transform: capitalize !important;
    }

    .fc .fc-button-primary {
        background: #fff !important;
        color: #3c4043 !important;
        border: 1px solid #dadce0 !important;
    }

    .fc .fc-button-primary:hover {
        background: #f1f3f4 !important;
        border-color: #dadce0 !important;
    }

    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background: #e8f0fe !important;
        color: #1a73e8 !important;
        border-color: #1a73e8 !important;
    }

    /* Event Styling */
    .fc-event {
        border: none !important;
        padding: 2px 4px !important;
        margin: 2px !important;
        border-radius: 4px !important;
    }

    .fc-event-krs {
        background-color: #e8f0fe !important;
        color: #1967d2 !important;
    }

    .fc-event-kp {
        background-color: #fce8e6 !important;
        color: #c5221f !important;
    }

    .fc-event-mbkm {
        background-color: #fef7e0 !important;
        color: #ea8600 !important;
    }

    .fc-event-skripsi {
        background-color: #e6f4ea !important;
        color: #137333 !important;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 8px;
        border: none;
        box-shadow: 0 24px 38px 3px rgba(60,64,67,0.14);
    }

    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dadce0;
        padding: 16px 24px;
    }

    .modal-body {
        padding: 24px;
    }

    .form-label {
        font-weight: 500;
        color: #000;
        margin-bottom: 8px;
    }

    /* Info Box Styling */
    .info-box {
        background-color: #e8f0fe;
        border: 1px solid #1a73e8;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
    }

    .info-box p {
        color: #1967d2;
        margin-bottom: 10px;
    }

    .info-box .btn-connect {
        background-color: #1a73e8;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 500;
    }

    .info-box .btn-connect:hover {
        background-color: #1557b0;
    }

    /* Legend Styling */
    .calendar-legend {
        margin-top: 20px;
        padding: 15px;
        border-radius: 8px;
        background: #f8f9fa;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        margin-right: 8px;
    }

    .swal2-popup {
        padding: 1.5em;
    }

    .swal2-html-container {
        text-align: left !important;
        margin: 1em 0;
    }

    /* Styling untuk container detail */
    .detail-container {
        text-align: left;
        padding: 10px 0;
    }

    /* Styling untuk setiap item detail */
    .detail-item {
        margin-bottom: 12px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-item:last-child {
        margin-bottom: 0;
    }

    .detail-item strong {
        color: #1a73e8;
        font-weight: 600;
        font-size: 0.9em;
    }

    .detail-item span {
        color: #333;
        padding-left: 4px;
    }

    /* Styling untuk tombol */
    .swal2-confirm.swal2-styled {
        padding: 0.5em 2em;
        font-weight: 500;
    }

    .swal2-cancel.swal2-styled {
        padding: 0.5em 2em;
        font-weight: 500;
    }

    @media (max-width: 768px) {
    .fc .fc-toolbar {
        flex-direction: column;
        gap: 1rem;
    }
    
    .fc .fc-toolbar-title {
        font-size: 18px !important;
    }

    .fc-header-toolbar {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        text-align: center;
    }

    .fc-toolbar-chunk {
        display: flex;
        justify-content: center;
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .calendar-container {
        padding: 10px;
    }

    #calendar {
        min-height: 500px;
    }

    @media (max-width: 576px) {
        .swal2-popup {
            padding: 1em;
            font-size: 14px;
        }
        
        .detail-container {
            padding: 5px 0;
        }
        
        .detail-item {
            margin-bottom: 8px;
        }
    }
}
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h1 class="mb-2 gradient-text fw-bold">Masukkan Jadwal</h1>
    <hr>
    <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
        <a href="{{ url('/persetujuan') }}">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </button>
    <div class="calendar-container">
        @if(!Auth::guard('dosen')->user()->googleToken)
            <div class="info-box">
                <p class="mb-2">Untuk menggunakan fitur ini, Anda perlu memberikan izin akses ke Google Calendar dengan email: <strong>{{ Auth::guard('dosen')->user()->email }}</strong></p>
                <a href="{{ route('dosen.google.connect') }}" class="btn btn-connect">
                    <i class="fas fa-calendar-plus me-2"></i>
                    Hubungkan dengan Google Calendar
                </a>
            </div>
        @endif

        <div id="calendar">
            
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal -->
<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="h4 gradient-text fw-bold">Tambah Jadwal Bimbingan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control" id="startTime" required>
                            </div>
                            <div class="col">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time" class="form-control" id="endTime" required>
                            </div>
                        </div>
                        <div id="timeValidationFeedback"></div>
                        <small class="text-muted mt-2 d-block">Jadwal tersedia pada jam kerja (08:00 - 18:00)<br>Durasi minimum bimbingan adalah 30 menit</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kapasitas Mahasiswa</label>
                        <input type="number" class="form-control" id="capacity" min="1" max="10" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="eventDescription" rows="3" ></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveEvent">Simpan Jadwal</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/locale/id.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/id.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrfToken) {
        console.error('CSRF token tidak ditemukan');
        return;
    }

    let calendar;
    let selectedDate = null;

    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) {
        console.error('Elemen kalender tidak ditemukan');
        return;
    }

    function formatDateTime(date) {
        return moment(date).format('DD MMM YYYY HH:mm');
    }

    const tampilkanPesan = (icon, text) => {
        Swal.fire({
            icon: icon,
            text: text,
            confirmButtonColor: '#1a73e8'
        });
    };

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        views: {
            dayGridMonth: {
                titleFormat: { year: 'numeric', month: 'long' }
            },
            timeGridWeek: {
                titleFormat: { year: 'numeric', month: 'long', day: '2-digit' }
            },
            timeGridDay: {
                titleFormat: { year: 'numeric', month: 'long', day: '2-digit' }
            }
        },
        firstDay: 1,
        locale: 'id',
        buttonIcons: true,
        navLinks: true,
        editable: true,
        dayMaxEvents: true,
        selectable: true,
        selectMirror: true,
        nowIndicator: true,
        height: '800px',
        slotMinTime: '08:00:00',
        slotMaxTime: '18:00:00',
        allDaySlot: false,
        slotDuration: '00:30:00',
        businessHours: {
            daysOfWeek: [1, 2, 3, 4, 5],
            startTime: '08:00',
            endTime: '18:00',
        },

        eventDidMount: function(info) {
            const eventEl = info.el;
            const event = info.event;
            
            if (event.classNames.includes('external-event')) {
                eventEl.style.opacity = '0.7';
            }
        },
        
        dateClick: function(info) {
            const hari = info.date.getDay();
            if (hari === 0 || hari === 6) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Tersedia',
                    text: 'Tidak dapat membuat jadwal di hari Sabtu atau Minggu',
                    confirmButtonColor: '#1a73e8'
                });
                return;
            }

            selectedDate = info.date;
            const modal = new bootstrap.Modal(document.getElementById('eventModal'));
            modal.show();
        },

        eventClassNames: function(arg) {
            return ['fc-event-' + arg.event.extendedProps.jenis];
        },

        eventContent: function(arg) {
            return {
                html: `
                    <div class="fc-content">
                        <div class="fc-title">${arg.event.title}</div>
                        ${arg.event.extendedProps.status ? 
                            `<div class="fc-status small">${arg.event.extendedProps.status}</div>` : 
                            ''}
                    </div>
                `
            };
        },

        eventClick: function(info) {
            if (info.event.classNames.includes('external-event')) {
                Swal.fire({
                    title: info.event.title,
                    html: `
                        <div class="text-left">
                            <p><strong>Waktu:</strong> ${moment(info.event.start).format('HH:mm')} - ${moment(info.event.end).format('HH:mm')}</p>
                            ${info.event.extendedProps.description ? `<p><strong>Deskripsi:</strong> ${info.event.extendedProps.description}</p>` : ''}
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#1a73e8'
                });
                return;
            }

            // Parse description untuk memisahkan informasi
            const description = info.event.extendedProps.description || '';
            const descriptionLines = description.split('\n').filter(line => line.trim());
            
            // Membuat tampilan yang lebih terstruktur
            const details = descriptionLines.reduce((acc, line) => {
                if (line.startsWith('Status:')) {
                    acc.status = line.replace('Status:', '').trim();
                } else if (line.startsWith('Catatan:')) {
                    acc.catatan = line.replace('Catatan:', '').trim();
                } else if (line.startsWith('Kapasitas:')) {
                    acc.kapasitas = line.replace('Kapasitas:', '').trim();
                }
                return acc;
            }, {});

            Swal.fire({
                title: 'Detail Jadwal Bimbingan',
                html: `
                    <div class="detail-container">
                        <div class="detail-item">
                            <strong>Tanggal:</strong>
                            <span>${moment(info.event.start).format('DD MMMM YYYY')}</span>
                        </div>
                        <div class="detail-item">
                            <strong>Waktu:</strong>
                            <span>${moment(info.event.start).format('HH:mm')} - ${moment(info.event.end).format('HH:mm')}</span>
                        </div>
                        ${details.kapasitas ? `
                            <div class="detail-item">
                                <strong>Kapasitas:</strong>
                                <span>${details.kapasitas || ''}</span>
                            </div>
                        ` : ''}
                        ${details.catatan ? `
                            <div class="detail-item">
                                <strong>Catatan:</strong>
                                <span>${details.catatan}</span>
                            </div>
                        ` : ''}
                        <div class="detail-item">
                            <strong>Status:</strong>
                            <span>${details.status || 'Tersedia'}</span>
                        </div>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus Jadwal',
                cancelButtonText: 'Tutup',
                showCloseButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Konfirmasi penghapusan
                    Swal.fire({
                        title: 'Hapus Jadwal?',
                        text: "Jadwal yang dihapus tidak dapat dikembalikan",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            hapusJadwal(info.event.id);
                        }
                    });
                }
            });
        },

        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('/masukkanjadwal/events')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(events => {
                    successCallback(events);
                })
                .catch(error => {
                    console.error('Error:', error);
                    failureCallback(error);
                    tampilkanPesan('error', 'Gagal memuat jadwal');
                });
        }
    });

    calendar.render();

    // Handler Simpan Jadwal
    document.getElementById('saveEvent')?.addEventListener('click', async function() {
        try {
            const description = document.getElementById('eventDescription').value;
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;
            const capacity = parseInt(document.getElementById('capacity').value);

            if (!startTime || !endTime) {
                throw new Error('Mohon isi waktu mulai dan selesai');
            }

            if (isNaN(capacity) || capacity < 1) {
                throw new Error('Kapasitas minimal adalah 1 mahasiswa');
            }

            // Buat objek tanggal dari selectedDate
            const startDateTime = new Date(selectedDate);
            const endDateTime = new Date(selectedDate);
            
            // Parse waktu
            const [startHour, startMinute] = startTime.split(':');
            const [endHour, endMinute] = endTime.split(':');
            
            // Set jam dan menit
            startDateTime.setHours(parseInt(startHour), parseInt(startMinute), 0, 0);
            endDateTime.setHours(parseInt(endHour), parseInt(endMinute), 0, 0);

            // Debug log sebelum mengirim request
            console.log('Selected Date:', selectedDate);
            console.log('Start DateTime to send:', startDateTime.toISOString());
            console.log('End DateTime to send:', endDateTime.toISOString());
            
            // Validasi waktu selesai harus setelah waktu mulai
            if (endDateTime <= startDateTime) {
                throw new Error('Waktu selesai harus setelah waktu mulai');
            }

            // Validasi jam kerja (08:00 - 18:00)
            const startHourInt = parseInt(startHour);
            if (startHourInt < 8 || startHourInt >= 18) {
                throw new Error('Jadwal harus dalam jam kerja (08:00 - 18:00)');
            }

            // Hitung durasi dalam menit
            const durationMs = endDateTime.getTime() - startDateTime.getTime();
            const durationMinutes = Math.floor(durationMs / (1000 * 60));

            // Debug log durasi
            console.log('Duration (minutes):', durationMinutes);

            // Validasi durasi minimum (30 menit)
            if (durationMinutes < 30) {
                throw new Error(`Durasi minimum bimbingan adalah 30 menit. Durasi saat ini: ${durationMinutes} menit`);
            }

            // Tampilkan loading
            Swal.fire({
                title: 'Menyimpan Jadwal',
                text: 'Mohon tunggu...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Log data yang akan dikirim
            const requestData = {
                start: startDateTime.toISOString(),
                end: endDateTime.toISOString(),
                description: description,
                capacity: capacity
            };
            console.log('Request Data:', requestData);

            const response = await fetch('/masukkanjadwal/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(requestData)
            });

            // Log response status dan headers
            console.log('Response Status:', response.status);
            console.log('Response Headers:', response.headers);

            const result = await response.json();
            
            if (!response.ok) {
                throw new Error(result.message || 'Terjadi kesalahan pada server');
            }
            
            if (result.success) {
                bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
                document.getElementById('eventForm').reset();
                calendar.refetchEvents();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Jadwal berhasil ditambahkan',
                    confirmButtonColor: '#1a73e8'
                });
            } else {
                throw new Error(result.message || 'Terjadi kesalahan');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: error.message,
                confirmButtonColor: '#1a73e8'
            });
        }
    });

    // Fungsi Hapus Jadwal
    async function hapusJadwal(eventId) {
        try {
            // Tampilkan loading
            Swal.fire({
                title: 'Menghapus Jadwal',
                text: 'Mohon tunggu...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const response = await fetch(`/masukkanjadwal/${eventId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            
            if (result.success) {
                calendar.refetchEvents();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Jadwal berhasil dihapus dari sistem dan Google Calendar',
                    confirmButtonColor: '#1a73e8'
                });
            } else {
                throw new Error(result.message || 'Terjadi kesalahan');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal menghapus jadwal: ' + error.message,
                confirmButtonColor: '#1a73e8'
            });
        }
    }

    document.getElementById('eventModal').addEventListener('show.bs.modal', function () {
        document.getElementById('startTime').value = '';
        document.getElementById('endTime').value = '';
        document.getElementById('eventDescription').value = '';
        document.getElementById('capacity').value = '';
    });
    document.getElementById('startTime')?.addEventListener('change', validateTimes);
    document.getElementById('endTime')?.addEventListener('change', validateTimes);

    function validateTimes() {
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;
        const saveButton = document.getElementById('saveEvent');
        const feedbackEl = document.getElementById('timeValidationFeedback');

        if (startTime && endTime) {
            const [startHour, startMinute] = startTime.split(':');
            const [endHour, endMinute] = endTime.split(':');
            
            const start = new Date();
            start.setHours(parseInt(startHour), parseInt(startMinute), 0, 0);
            
            const end = new Date();
            end.setHours(parseInt(endHour), parseInt(endMinute), 0, 0);

            const durationMinutes = Math.floor((end.getTime() - start.getTime()) / (1000 * 60));
            
            console.log('Real-time validation - Duration:', durationMinutes);

            let errorMessage = '';
            
            if (end <= start) {
                errorMessage = 'Waktu selesai harus lebih besar dari waktu mulai';
            } else if (durationMinutes < 30) {
                errorMessage = `Durasi minimum bimbingan adalah 30 menit. Durasi saat ini: ${durationMinutes} menit`;
            } else if (parseInt(startHour) < 8 || parseInt(startHour) >= 18 || 
                    parseInt(endHour) < 8 || parseInt(endHour) > 18) {
                errorMessage = 'Jadwal harus dalam jam kerja (08:00 - 18:00)';
            }

            if (errorMessage) {
                feedbackEl.innerHTML = `<div class="text-danger small mt-2">${errorMessage}</div>`;
                saveButton.disabled = true;
            } else {
                feedbackEl.innerHTML = `<div class="text-success small mt-2">Durasi bimbingan: ${durationMinutes} menit</div>`;
                saveButton.disabled = false;
            }
        }
    }

});
</script>
@endpush