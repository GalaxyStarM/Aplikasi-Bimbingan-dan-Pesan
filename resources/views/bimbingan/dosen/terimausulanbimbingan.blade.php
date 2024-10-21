<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITEI | Terima Usulan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">

    <style>
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
            background-color: #17a2b8;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9em;
            display: inline-block;
            margin-top: 10px;
            padding: 5px 15px;
        }

        .status {
            background-color: #FFBE01;
            color: white;
            border-radius: 5px;
            font-size: 0.9em;
            display: inline-block;
            margin-top: 10px;
            padding: 5px 15px;
        }

        .status-badge {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 15px;
        }

        .text-bold {
            font-weight: 600;
        }

        /* Updated styles for modals */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 10px;
            text-align: center;
        }

        .modal-content h2 {
            margin-top: 0;
            font-size: 1.5rem;
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

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-terima {
            background-color: #28a745;
            color: white;
        }

        .btn-tolak {
            background-color: #dc3545;
            color: white;
        }

        .btn-batal {
            background-color: #6c757d;
            color: white;
        }

        #alasanPenolakan {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
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
                    <p class="card-text text-start">Senin, 30 September 2024</p>
                    <p class="card-title text-muted text-sm">Waktu</p>
                    <p class="card-text text-start">13.30 - 16.00</p>
                    <p class="card-title text-muted text-sm">Deskripsi</p>
                    <p class="card-text text-start">Izin bapak, saya ingin melakukan bimbingan bab 1 skripsi saya pak
                    </p>
                </div>

                <div class="col-lg-6 col-md-12 px-4 py-3 mb-2 bg-white rounded-end shadow-sm">
                    <h5 class="text-bold">Keterangan Usulan</h5>
                    <hr>
                    <p class="card-title text-secondary text-sm">Status Usulan</p>
                    <p class="card-text text-start">
                        <span id="status" class="status">BELUM DIPROSES</span>
                    </p>
                    <p class="card-title text-secondary text-sm">Keterangan</p>
                    <p id="keteranganText" class="card-text text-start">-</p>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <button id="btnTerima" class="btn btn-success w-100">Terima</button>
                </div>
                <div class="col-md-12 mb-2">
                    <button id="btnTolak" class="btn btn-danger w-100">Tolak</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Updated Modal for Terima -->
    <div id="modalTerima" class="modal">
        <div class="modal-content">
            <div class="question-mark">
                <span>?</span>
            </div>
            <h2>Setujui Usulan Jadwal Bimbingan?</h2>
            <p>Apakah Anda Yakin</p>
            <div class="modal-buttons">
                <button id="confirmTerima" class="btn-terima">Terima</button>
                <button class="btn-batal close-modal">Batal</button>
            </div>
        </div>
    </div>

    <!-- Updated Modal for Tolak -->
    <div id="modalTolak" class="modal">
        <div class="modal-content">
            <div class="question-mark">
                <span>?</span>
            </div>
            <h2>Tolak Usulan Jadwal Bimbingan?</h2>
            <p>Apakah Anda Yakin</p>
            <div class="modal-buttons">
                <button id="confirmTolak" class="btn-tolak">Tolak</button>
                <button class="btn-batal close-modal">Batal</button>
            </div>
        </div>
    </div>

    <!-- Updated Modal for Alasan Penolakan -->
    <div id="modalAlasanPenolakan" class="modal">
        <div class="modal-content">
            <h2>Tolak Usulan Jadwal Bimbingan</h2>
            <p>Alasan Penolakan:</p>
            <textarea id="alasanPenolakan" rows="4"></textarea>
            <div class="modal-buttons">
                <button id="submitPenolakan" class="btn-tolak">Kirim</button>
                <button class="btn-batal close-modal">Batal</button>
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
        // Get modal elements
        var modalTerima = document.getElementById("modalTerima");
        var modalTolak = document.getElementById("modalTolak");
        var modalAlasanPenolakan = document.getElementById("modalAlasanPenolakan");

        // Get buttons
        var btnTerima = document.getElementById("btnTerima");
        var btnTolak = document.getElementById("btnTolak");
        var confirmTerima = document.getElementById("confirmTerima");
        var confirmTolak = document.getElementById("confirmTolak");
        var submitPenolakan = document.getElementById("submitPenolakan");

        // Get close buttons
        var closeButtons = document.getElementsByClassName("close-modal");

        // Get status and keterangan elements
        var statusBadge = document.getElementById("status");
        var keteranganText = document.getElementById("keteranganText");

        // Open Terima modal
        btnTerima.onclick = function() {
            modalTerima.style.display = "block";
        }

        // Open Tolak modal
        btnTolak.onclick = function() {
            modalTolak.style.display = "block";
        }

        // Confirm Terima
        confirmTerima.onclick = function() {
            statusBadge.innerHTML = "USULAN DISETUJUI";
            statusBadge.style.backgroundColor = "#28a745";
            keteranganText.innerHTML = "Usulan Jadwal Bimbingan Disetujui";
            modalTerima.style.display = "none";
            disableButtons();
        }

        // Confirm Tolak
        confirmTolak.onclick = function() {
            modalTolak.style.display = "none";
            modalAlasanPenolakan.style.display = "block";
        }

        // Submit Penolakan
        submitPenolakan.onclick = function() {
            var alasan = document.getElementById("alasanPenolakan").value;
            if (alasan.trim() !== "") {
                statusBadge.innerHTML = "USULAN DITOLAK";
                statusBadge.style.backgroundColor = "#dc3545";
                keteranganText.innerHTML = alasan;
                modalAlasanPenolakan.style.display = "none";
                disableButtons();
            } else {
                alert("Harap isi alasan penolakan.");
            }
        }

        // Close modals
        for (var i = 0; i < closeButtons.length; i++) {
            closeButtons[i].onclick = function() {
                modalTerima.style.display = "none";
                modalTolak.style.display = "none";
                modalAlasanPenolakan.style.display = "none";
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modalTerima || event.target == modalTolak || event.target == modalAlasanPenolakan) {
                modalTerima.style.display = "none";
                modalTolak.style.display = "none";
                modalAlasanPenolakan.style.display = "none";
            }
        }

        // Disable Terima and Tolak buttons after action
        function disableButtons() {
            btnTerima.disabled = true;
            btnTolak.disabled = true;
        }
    </script>
</body>

</html>