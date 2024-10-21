<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITEI | Edit Usulan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Viga&display=swap" rel="stylesheet">

    <style>
        /* Yang diambil */
        body{
            font-family: "Open Sans", sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
        }
        .bg-gradient-bar {
            height: 3px;
            background: linear-gradient(to right, #4ade80, #3b82f6, #8b5cf6);
        }
        .blob-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none; 
            z-index: -1; 
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            mix-blend-mode: multiply;
            animation: blob 7s infinite;
            pointer-events: none;
        }
        .blob-1 { top: 0; left: 0; width: 300px; height: 300px; background-color: rgba(74, 222, 128, 0.1); }
        .blob-2 { top: 50%; right: 0; width: 350px; height: 350px; background-color: rgba(251, 191, 36, 0.1); animation-delay: 2s;}
        .blob-3 { bottom: 0; left: 50%; width: 350px; height: 350px; background-color: rgba(239, 68, 68, 0.1); animation-delay: 4s;}
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }
        .navbar{
            box-shadow: 0px 0px 10px 1px #afafaf
        }
        .navbar-brand {
            font-family: "Viga", sans-serif;
            font-weight: 600;
            font-size: 25px;
        }
        .nav-link {
            position: relative;
            color: #4b5563;
            transition: color 0.3s ease;
            font-weight: bold;
        }
        .nav-link:hover, .nav-link.active {
            color: #059669;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #059669;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }
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
        .btn-gradient:hover a{
            color: black;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 12px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .green-text {
            color: #28a745;
        }
        .container {
            flex: 1; 
        }
        .status-badge {
            display: inline-block;
            background-color: #17a2b8;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9em;
            margin-top: 10px;
            font-weight: 600;
        }
        .text-bold {
            font-weight: 600;
        }
        .btn-ubah-data,
        .btn-selesai {
            width: 100%;
            margin-bottom: 10px;
        }
        .btn-ubah-data {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #ffffff;
            font-weight: 600;
        }
        .btn-ubah-data:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }
        .btn-simpan-perubahan {
            width: 100%;
            margin-bottom: 10px;
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }
        .btn-simpan-perubahan:hover {
            background-color: #218838;
            border-color: #218838;
        }
        .btn-selesai {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
            font-weight: 600;
        }
        .btn-selesai:hover {
            background-color: #138496;
            border-color: #138496;
        }
        .edit-icon {
            cursor: pointer;
            margin-left: 10px;
            display: none;
        }
        .edit-input {
            display: none;
            width: 100%;
        }
    </style>
</head>

<body class="bg-light">
    <div class="bg-gradient-bar"></div>
    <div class="blob-container">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand me-4" href="/persetujuan">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="SITEI Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
                SITEI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" style="font-weight: bold;" href="/persetujuan">BIMBINGAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="font-weight: bold;" href="/dashboardpesan">PESAN</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn text-dark dropdown-toggle" style="font-weight: bold;" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            AKUN
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/login">Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-2 gradient-text fw-bold">Detail Mahasiswa</h1>
        <hr></hr>
        <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
            <a href="/persetujuan">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </button>

        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 bg-white rounded-start px-4 py-3 mb-2 shadow-sm">
                    <h5 class="text-bold">Mahasiswa</h5>
                    <hr>
                    <p class="card-title text-muted text-sm">Nama</p>
                    <p class="card-text text-start">Syahirah Tri Meilina</p>
                    <p class="card-title text-muted text-sm">NIM</p>
                    <p class="card-text text-start">2107110255</p>
                    <p class="card-title text-muted text-sm">Program Studi</p>
                    <p class="card-text text-start">Teknik Informatika S1</p>
                    <p class="card-title text-muted text-sm">Konsentrasi</p>
                    <p class="card-text text-start">Rekayasa Perangkat Lunak</p>
                </div>

                <div class="col-lg-6 col-md-12 bg-white rounded-end px-4 py-3 mb-2 shadow-sm">
                    <h5 class="text-bold">Dosen Pembimbing</h5>
                    <hr>
                    <p class="card-title text-secondary text-sm">Nama Pembimbing</p>
                    <p class="card-text text-start">Edi Susilo, S.Pd., M.Kom., M.Eng.</p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 px-4 py-3 mb-2 bg-white rounded-start shadow-sm">
                    <h5 class="text-bold">Data Usulan Jadwal Bimbingan</h5>
                    <hr>
                    <p class="card-title text-muted text-sm">Jenis Bimbingan</p>
                    <p class="card-text text-start">Bimbingan Skripsi</p>
                    <p class="card-title text-muted text-sm">Tanggal</p>
                    <p class="card-text text-start">
                        <span id="tanggal-text">Senin, 30 September 2024</span>
                        <i class="fas fa-edit edit-icon" onclick="toggleEdit('tanggal')"></i>
                        <input type="date" id="tanggal-input" class="edit-input form-control" value="2024-09-30">
                    </p>
                    <p class="card-title text-muted text-sm">Waktu</p>
                    <p class="card-text text-start">
                        <span id="waktu-text">13.30 - 16.00</span>
                        <i class="fas fa-edit edit-icon" onclick="toggleEdit('waktu')"></i>
                        <select id="waktu-input-start" class="edit-input form-control mb-2">
                            <!-- Options will be populated by JavaScript -->
                        </select>
                        <select id="waktu-input-end" class="edit-input form-control">
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </p>
                    <p class="card-title text-muted text-sm">Deskripsi</p>
                    <p class="card-text text-start">Izin bapak, saya ingin melakukan bimbingan bab 1 skripsi saya pak
                    </p>
                </div>

                <div class="col-lg-6 col-md-12 px-4 py-3 mb-2 bg-white rounded-end shadow-sm">
                    <h5 class="text-bold">Keterangan Usulan</h5>
                    <hr>
                    <p class="card-title text-secondary text-sm">Status Usulan</p>
                    <p class="card-text text-start">
                        <span id="status-badge" class="status-badge">USULAN DISETUJUI</span>
                    </p>
                    <p class="card-title text-secondary text-sm">Keterangan</p>
                    <p id="keterangan-text" class="card-text text-start">Usulan Jadwal Bimbingan Disetujui</p>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <button id="btn-ubah-data" class="btn btn-ubah-data">Ubah Data</button>
                </div>
                <div class="col-md-12 mb-2">
                    <button id="btn-selesai" class="btn btn-selesai">Selesai</button>
                </div>
            </div>
        </div>

    </div>

    <footer class="footer mt-5">
        <div class="container text-center">
            <p class="mb-0">
                Dikembangkan oleh Mahasiswa Prodi Teknik Informatika UNRI
                (<span class="green-text">Desi, Murni, dan Syahirah</span>)
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startTimeSelect = document.getElementById('waktu-input-start');
            const endTimeSelect = document.getElementById('waktu-input-end');
            populateTimeOptions(startTimeSelect);
            populateTimeOptions(endTimeSelect);
    
            // Set initial values based on the current text
            const waktuText = document.getElementById('waktu-text').textContent;
            const [startTime, endTime] = waktuText.split(' - ');
            startTimeSelect.value = startTime.trim();
            endTimeSelect.value = endTime.trim();
    
            document.getElementById('btn-ubah-data').addEventListener('click', function () {
                const editIcons = document.querySelectorAll('.edit-icon');
                if (this.textContent === 'Ubah Data') {
                    editIcons.forEach(icon => icon.style.display = 'inline');
                    this.textContent = 'Simpan Perubahan Data';
                    this.classList.remove('btn-ubah-data');
                    this.classList.add('btn-simpan-perubahan');
                } else {
                    editIcons.forEach(icon => icon.style.display = 'none');
                    this.textContent = 'Ubah Data';
                    this.classList.remove('btn-simpan-perubahan');
                    this.classList.add('btn-ubah-data');
    
                    // Save changes
                    const tanggalInput = document.getElementById('tanggal-input');
                    const tanggalText = document.getElementById('tanggal-text');
                    const waktuStartInput = document.getElementById('waktu-input-start');
                    const waktuEndInput = document.getElementById('waktu-input-end');
                    const waktuText = document.getElementById('waktu-text');
    
                    if (tanggalInput.style.display !== 'none') {
                        const date = new Date(tanggalInput.value);
                        const options = {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        tanggalText.textContent = date.toLocaleDateString('id-ID', options);
                        tanggalInput.style.display = 'none';
                        tanggalText.style.display = 'inline';
                    }
    
                    if (waktuStartInput.style.display !== 'none') {
                        // Validate time
                        const startTime = waktuStartInput.value;
                        const endTime = waktuEndInput.value;
                        if (startTime >= endTime) {
                            alert('Apakah anda yakin ingin merubah data?');
                        } else {
                            waktuText.textContent = `${startTime} - ${endTime}`;
                            waktuStartInput.style.display = 'none';
                            waktuEndInput.style.display = 'none';
                            waktuText.style.display = 'inline';
                        }
                    }
                }
            });
    
            document.getElementById('btn-selesai').addEventListener('click', function () {
                const statusBadge = document.getElementById('status-badge');
                const keteranganText = document.getElementById('keterangan-text');
    
                statusBadge.textContent = 'BIMBINGAN SELESAI';
                statusBadge.style.backgroundColor = '#28a745';
                keteranganText.textContent = 'Bimbingan telah selesai dilaksanakan';
    
                this.disabled = true;
                document.getElementById('btn-ubah-data').disabled = true;
            });
        });
    
        function populateTimeOptions(selectElement, startHour = 7, endHour = 17) {
            selectElement.innerHTML = ''; // Clear existing options
            for (let hour = startHour; hour <= endHour; hour++) {
                for (let minute = 0; minute < 60; minute += 30) {
                    const time = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    selectElement.appendChild(option);
                }
            }
        }
    
        function toggleEdit(field) {
            const textElement = document.getElementById(`${field}-text`);
            const inputElement = document.getElementById(`${field}-input`);
            const inputElementEnd = document.getElementById(`${field}-input-end`);
    
            if (textElement.style.display !== 'none') {
                textElement.style.display = 'none';
                inputElement.style.display = 'block';
                if (inputElementEnd) {
                    inputElementEnd.style.display = 'block';
                }
            } else {
                textElement.style.display = 'inline';
                inputElement.style.display = 'none';
                if (inputElementEnd) {
                    inputElementEnd.style.display = 'none';
                }
    
                if (field === 'tanggal') {
                    const date = new Date(inputElement.value);
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    textElement.textContent = date.toLocaleDateString('id-ID', options);
                } else if (field === 'waktu') {
                    textElement.textContent = `${inputElement.value} - ${inputElementEnd.value}`;
                }
            }
        }
    </script>
    

</body>

</html>
