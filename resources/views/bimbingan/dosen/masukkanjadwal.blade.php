@extends('layouts.app')

@section('title', 'Masukkan Jadwal')

@push('styles')
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.js' rel='stylesheet'>
<style>
    /* Form Styling */
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    /* Calendar Styles */
    #calendar {
        background-color: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-top: 20px;
    }

    .fc td, .fc th { border: 1px solid #e9ecef !important; }

    .fc .fc-daygrid-day {
        border-radius: 0;
        transition: background-color 0.2s;
    }

    .fc .fc-daygrid-day-number {
        font-size: 0.9em;
        font-weight: 500;
        color: #495057;
        text-decoration: none !important;
        margin: 4px;
    }

    .fc .fc-col-header-cell-cushion {
        color: #28a745;
        font-weight: 600;
        padding: 10px;
        text-decoration: none !important;
    }

    .fc .fc-daygrid-day:hover {
        background-color: rgba(40, 167, 69, 0.05);
    }

    .fc .fc-day-today {
        background: rgba(40, 167, 69, 0.1) !important;
    }

    .fc .fc-day-today .fc-daygrid-day-number {
        background: #28a745;
        color: white;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fc .fc-event {
        background: #28a745;
        border: none;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 0.85em;
        transition: transform 0.2s ease;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.3;
    }

    .fc .fc-event:hover { transform: scale(1.02); }

    /* Custom Toolbar Styles */
    .fc .fc-toolbar {
        background: linear-gradient(135deg, #36c482, #28a745);
        margin: -20px -20px 20px -20px;
        padding: 20px;
        border-radius: 12px 12px 0 0;
    }

    .fc .fc-toolbar-title {
        color: white;
        font-size: 1.3em !important;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .fc .fc-button-primary {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        border-radius: 20px;
        padding: 6px 15px;
        transition: all 0.3s ease;
    }

    .fc .fc-button-primary:hover {
        background: white;
        color: #28a745;
        transform: translateY(-2px);
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal.show { display: flex; }

    .modal-content {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        max-width: 400px;
        width: 90%;
    }

    .modal-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-simpan {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-batal {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-simpan:hover { background-color: #218838; }
    .btn-batal:hover { background-color: #c82333; }

    .question-mark {
        width: 60px;
        height: 60px;
        background-color: #f0f0f0;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 20px;
    }

    .question-mark span {
        color: #17a2b8;
        font-size: 40px;
        font-weight: bold;
    }

    /* Responsive Calendar */
    @media (max-width: 768px) {
        .fc .fc-toolbar {
            flex-direction: column;
            gap: 10px;
        }

        .fc .fc-toolbar-title { font-size: 1.1em !important; }
        .fc .fc-button { 
            padding: 5px 10px;
            font-size: 0.9em;
        }
    }
</style>
@endpush

@section('content')
<div class="container mt-5">
    <h1 class="mb-2 gradient-text fw-bold">Masukkan Jadwal Bimbingan</h1>
    <hr>
    <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
        <a href="{{ url('/persetujuan') }}">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </button>

    <form id="scheduleForm">
        <div class="mb-3">
            <label for="pilihKegiatan" class="form-label">Pilih Kegiatan<span style="color: red;">*</span></label>
            <select class="form-select" id="pilihKegiatan" required>
                <option value="" selected disabled>- Pilih Kegiatan -</option>
                <option value="krs">Kartu Rencana Studi (KRS)</option>
                <option value="kp">Kerja Praktek (KP)</option>
                <option value="mbkm">Merdeka Belajar Kampus Merdeka (MBKM)</option>
                <option value="skripsi">Skripsi</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="pilihKegiatan" class="form-label">Pilih Jadwal<span style="color: red;">*</span></label>
        </div>

        <div id="calendar"></div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-gradient mb-4 mt-2">
                <i class=""></i>Simpan
            </button>
        </div>
    </form>
</div>

<!-- Save Confirmation Modal -->
<div id="saveModal" class="modal">
    <div class="modal-content">
        <div class="question-mark">
            <i class="fas fa-question" style="font-size: 40px; color: #00bcd4;"></i>
        </div>
        <h2>Simpan Jadwal Bimbingan?</h2>
        <p>Apakah Anda Yakin</p>
        <div class="modal-buttons">
            <button id="confirmSave" class="btn-simpan">Simpan</button>
            <button id="cancelSave" class="btn-batal">Batal</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        firstDay: 1,
        locale: 'id',
        buttonIcons: false,
        weekNumbers: true,
        navLinks: true,
        editable: true,
        dayMaxEvents: true,
        selectable: true,
        select: function(arg) {
            var title = prompt('Masukkan keterangan jadwal bimbingan:');
            if (title) {
                calendar.addEvent({
                    title: title,
                    start: arg.start,
                    end: arg.end,
                    allDay: arg.allDay,
                    backgroundColor: '#28a745',
                    borderColor: '#28a745',
                    textColor: 'white'
                })
            }
            calendar.unselect()
        },
        eventClick: function(arg) {
            if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
                arg.event.remove()
            }
        },
        eventDidMount: function(info) {
            info.el.title = info.event.title;
        },
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            day: 'Hari',
            list: 'Agenda'
        },
        dayHeaderFormat: {
            weekday: 'long'
        },
        eventContent: function(arg) {
            return {
                html: '<div class="fc-event-main-frame">' +
                    '<div class="fc-event-title-container">' +
                    '<div class="fc-event-title fc-sticky">' + arg.event.title + '</div>' +
                    '</div>' +
                    '</div>'
            }
        }
    });
    calendar.render();

    // Modal handling
    const form = document.getElementById('scheduleForm');
    const modal = document.getElementById('saveModal');
    const confirmBtn = document.getElementById('confirmSave');
    const cancelBtn = document.getElementById('cancelSave');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        modal.style.display = 'flex';
    });

    confirmBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        window.location.href = '{{ url("/masukkanjadwal") }}';
    });

    cancelBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
@endpush