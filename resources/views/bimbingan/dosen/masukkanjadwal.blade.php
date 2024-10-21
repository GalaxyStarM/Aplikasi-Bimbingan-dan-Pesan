<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITEI | Masukkan Jadwal</title>

    <!-- Required CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap"
        rel="stylesheet">

    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.js'></script>

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0px 0px 10px 1px #afafaf;
        }

        .navbar-brand {
            font-family: "Viga", sans-serif;
            font-weight: 600;
            font-size: 20px;
        }

        .nav-link {
            color: #192f59;
            font-weight: bold;
        }

        .nav-link.active {
            color: #28a745 !important;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #36c482;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 1;
        }

        .main-content {
            padding: 80px 0 100px 0;
        }
        .h4, h4 {
            font-size: 1.5rem;
        }
        .mb-4 {
            margin-bottom: 15px;
            border-bottom: 1px solid #acb5be;
            padding-bottom: 10px;
            font-weight: 600;
        }
        .mb-3{
            margin-bottom: 15px;
            padding-bottom: 10px;
            font-weight: 600;
        }
        .green-text {
            color: #28a745;
        }
        .btn-kembali {
            background-color: #28a745;
            color: white;
            font-size: 14px;
            border-radius: 5px;
            width: 100px;
        }
        .btn-kembali, .btn-kirim {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-kembali:hover,
        .btn-kirim:hover {
            background-color: #218838;
            color: white;
            transform: translateY(-2px);
        }

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

        /* Enhanced Calendar Styles */
        /* Calendar Styles */
        #calendar {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        /* Restore grid but remove text underlines */
        .fc td,
        .fc th {
            border: 1px solid #e9ecef !important;
        }

        .fc .fc-daygrid-day {
            border-radius: 0;
            transition: background-color 0.2s;
        }

        /* Remove underline from day numbers but keep the grid */
        .fc .fc-daygrid-day-number {
            font-size: 0.9em;
            font-weight: 500;
            color: #495057;
            text-decoration: none !important;
            margin: 4px;
        }

        /* Remove underline from header text but keep the grid */
        .fc .fc-col-header-cell-cushion {
            color: #28a745;
            font-weight: 600;
            padding: 10px;
            text-decoration: none !important;
        }

        /* Hover effect for days */
        .fc .fc-daygrid-day:hover {
            background-color: rgba(40, 167, 69, 0.05);
        }

        /* Today's date styling */
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

        /* Event styling */
        .fc .fc-event {
            background: #28a745;
            border: none;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 0.85em;
            transition: transform 0.2s ease;
        }

        .fc .fc-event:hover {
            transform: scale(1.02);
        }

        /* Remove week numbers */
        .fc .fc-daygrid-week-number {
            display: none !important;
        }

        /* Custom FullCalendar Toolbar Styles */
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

        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background: white;
            color: #28a745;
            border-color: white;
        }

        .fc .fc-daygrid-day-frame {
            padding: 8px;
        }

        .fc .fc-day-today {
            background: rgba(40, 167, 69, 0.1) !important;
        }

        .fc .fc-daygrid-day-number {
            font-size: 1em;
            padding: 8px;
            color: #495057;
        }

        .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            background: #28a745;
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 4px;
        }

        .fc .fc-col-header-cell-cushion {
            color: #28a745;
            font-weight: 600;
            padding: 10px;
        }

        .fc .fc-event {
            background: #28a745;
            border: none;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 0.85em;
            transition: transform 0.2s ease;
        }

        .fc .fc-event:hover {
            transform: scale(1.02);
        }

        .fc td,
        .fc th {
            border: 1px solid #e9ecef;
        }

        .fc .fc-daygrid-week-number {
            background: #f8f9fa;
            color: #28a745;
            border-radius: 15px;
            padding: 2px 8px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .fc .fc-daygrid-more-link {
            color: #28a745;
            font-weight: 600;
        }

        .fc .fc-daygrid-day:hover {
            background-color: rgba(40, 167, 69, 0.05);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .fc .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }

            .fc .fc-toolbar-title {
                font-size: 1.1em !important;
            }

            .fc .fc-button {
                padding: 5px 10px;
                font-size: 0.9em;
            }
        }

        .mb-4 {
            font-weight: 600;
        }

        @media (max-width: 375px) {
            body {
                font-size: 14px;
            }

            .navbar-brand {
                font-size: 18px;
            }

            .nav-link {
                font-size: 14px;
            }

            .fc .fc-toolbar-title {
                font-size: 0.9em !important;
            }

            .fc .fc-daygrid-day-number {
                font-size: 0.85em;
            }

            .fc .fc-button {
                font-size: 0.8em;
                padding: 4px 8px;
            }

            .fc .fc-event {
                font-size: 0.75em;
                padding: 2px 6px;
            }

            .mb-4 {
                font-size: 1.1em;
            }
        }

        /* Mobile - Medium screens (376px - 425px) */
        @media (min-width: 376px) and (max-width: 425px) {
            body {
                font-size: 15px;
            }

            .navbar-brand {
                font-size: 19px;
            }

            .nav-link {
                font-size: 15px;
            }

            .fc .fc-toolbar-title {
                font-size: 1em !important;
            }

            .fc .fc-daygrid-day-number {
                font-size: 0.9em;
            }

            .fc .fc-button {
                font-size: 0.85em;
                padding: 4px 10px;
            }

            .fc .fc-event {
                font-size: 0.8em;
                padding: 2px 7px;
            }

            .mb-4 {
                font-size: 1.2em;
            }
        }

        /* Tablet (426px - 768px) */
        @media (min-width: 426px) and (max-width: 768px) {
            body {
                font-size: 16px;
            }

            .navbar-brand {
                font-size: 20px;
            }

            .nav-link {
                font-size: 16px;
            }

            .fc .fc-toolbar-title {
                font-size: 1.1em !important;
            }

            .fc .fc-daygrid-day-number {
                font-size: 0.95em;
            }

            .fc .fc-button {
                font-size: 0.9em;
            }

            .fc .fc-event {
                font-size: 0.85em;
            }

            .mb-4 {
                font-size: 1.3em;
            }
        }

        /* Small Desktop (769px - 992px) */
        @media (min-width: 769px) and (max-width: 992px) {
            body {
                font-size: 16px;
            }

            .fc .fc-toolbar-title {
                font-size: 1.2em !important;
            }

            .fc .fc-event {
                font-size: 0.9em;
            }
        }

        /* Large Desktop (993px and above) */
        @media (min-width: 993px) {
            body {
                font-size: 16px;
            }

            .fc .fc-toolbar-title {
                font-size: 1.3em !important;
            }

            .fc .fc-event {
                font-size: 0.95em;
            }
        }

        /* Calendar Event enhanced visibility */
        .fc .fc-event {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
        }

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

        .modal.show {
            display: flex;
        }

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

        .btn-simpan:hover {
            background-color: #218838;
        }

        .btn-batal:hover {
            background-color: #c82333;
        }

        .modal h2 {
            margin-bottom: 10px;
            color: #333;
            font-size: 24px;
        }

        .modal p {
            color: #666;
            margin-bottom: 20px;
        }


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

        a {
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="Logo UNRI"
                    width="30" height="30" class="d-inline-block align-top me-2">
                SITEI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">BIMBINGAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboardpesan">PESAN</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            AKUN
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="/login">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="container">
            <div class="content-header">
                <h4 class="mb-4">Masukkan Jadwal Bimbingan</h4>
            </div>

            <a href="/" class="btn btn-kembali mb-4">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <form id="scheduleForm">
                <div class="mb-3">
                    <label for="pilih Kegiatan" class="form-label">Pilih Kegiatan<span
                            style="color: red;">*</span></label>
                    <select class="form-select" id="pilih Kegiatan" required>
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
                    <button type="submit" class="btn btn-kirim">
                        {{-- <i class="fas fa-save me-2"></i>Simpan --}}
                        <i></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="saveModal" class="modal" style="display: none;">
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

    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">
                Dikembangkan oleh Mahasiswa Prodi Teknik Informatika UNRI
                (<span class="green-text">Desi, Murni, dan Syahirah</span>)
            </p>
        </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Calendar Initialization Script -->
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
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('scheduleForm');
            const modal = document.getElementById('saveModal');
            const confirmBtn = document.getElementById('confirmSave');
            const cancelBtn = document.getElementById('cancelSave');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                modal.style.display = 'flex'; // Menggunakan display flex langsung
            });

            confirmBtn.addEventListener('click', function() {
                modal.style.display = 'none';
                // Add your save logic here
                // alert('Jadwal berhasil disimpan!');
                window.location.href = '/masukkanjadwal';
            });

            cancelBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
