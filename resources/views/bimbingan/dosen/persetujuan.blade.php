<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITEI - Sistem Informasi Teknik Elektro dan Informatika</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts (Open Sans dan Viga) -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap"
        rel="stylesheet">

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

        /* Tambahan style untuk action icons */
        .action-icons {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .action-icon {
            padding: 5px;
            border-radius: 4px;
            cursor: pointer;
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.2s;
        }

        .action-icon:hover {
            opacity: 0.8;
        }

        .info-icon {
            background-color: #17a2b8;
            color: white;
        }

        .approve-icon {
            background-color: #28a745;
            color: white;
        }

        .reject-icon {
            background-color: #dc3545;
            color: white;
        }

        .action-icons {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .action-icon {
            padding: 5px;
            border-radius: 4px;
            cursor: pointer;
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.2s;
            text-decoration: none;
            /* Menghilangkan garis bawah pada link */
        }

        .action-icon:hover {
            opacity: 0.8;
        }

        .info-icon {
            background-color: #17a2b8;
            color: white !important;
            /* Memastikan warna icon tetap putih */
        }

        .approve-icon {
            background-color: #28a745;
            color: white !important;
        }

        .reject-icon {
            background-color: #dc3545;
            color: white;
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
            <a class="navbar-brand me-4" href="/">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="SITEI Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
                SITEI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" style="font-weight: bold;" href="/">BIMBINGAN</a>
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

    <!--Content-->
    <div class="container mt-5">
        <h1 class="mb-2 gradient-text fw-bold">Persetujuan Bimbingan</h1>
        <hr></hr>
        <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
            <a href="/masukkanjadwal">
                <i class="bi bi-plus-lg me-2"></i> Masukkan Jadwal Bimbingan
            </a>
        </button>
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white p-0">
                <ul class="nav nav-tabs" id="bimbinganTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active px-4 py-3" id="usulan-tab" data-bs-toggle="tab" data-bs-target="#usulan" type="button" role="tab" aria-controls="usulan" aria-selected="true">Usulan Bimbingan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-3" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button" role="tab" aria-controls="jadwal" aria-selected="false">Daftar Jadwal</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-3" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat</button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="bimbinganTabContent">
                    <!--Usulan-->
                    <div class="tab-pane fade show active" id="usulan" role="tabpanel" aria-labelledby="usulan-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                Tampilkan 
                                <select class="form-select form-select-sm d-inline-block w-auto">
                                    <option>50</option>
                                </select> 
                                entri
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th class="text-center">No.</th>
                                        <th class="text-center">NIM</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Jenis Bimbingan</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Waktu</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelUsulan">
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">2107110255</td>
                                        <td class="text-center">Syahirah Tri Meilina</td>
                                        <td class="text-center">Bimbingan Skripsi</td>
                                        <td class="text-center">Senin, 30 September 2024</td>
                                        <td class="text-center">13.30 - 16.00</td>
                                        <td class="text-center">USULAN</td>
                                        <td class="text-center">
                                            <div class="action-icons">
                                                <a href="/terimausulanbimbingan" class="action-icon info-icon">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                                <a href="/" class="action-icon approve-icon">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <span class="action-icon reject-icon">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--Daftar Jadwal-->
                    <div class="tab-pane fade" id="jadwal" role="tabpanel" aria-labelledby="jadwal-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                Tampilkan 
                                <select class="form-select form-select-sm d-inline-block w-auto">
                                    <option>50</option>
                                </select> 
                                entri
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Kode Dosen</th>
                                        <th class="text-center">Nama Dosen</th>
                                        <th class="text-center">Total Bimbingan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted fst-italic">Belum ada usulan Bimbingan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--Riwayat-->
                    <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                Tampilkan 
                                <select class="form-select form-select-sm d-inline-block w-auto">
                                    <option>50</option>
                                </select> 
                                entri
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th class="text-center">No.</th>
                                        <th class="text-center">NIM</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Jenis Bimbingan</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Waktu</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted fst-italic">Belum ada usulan Bimbingan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3">
                        <p class="mb-2">Menampilkan 1 sampai 1 dari 1 entri</p>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item disabled"><a class="page-link" href="#">Selanjutnya</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Footer-->
    <footer class="footer mt-5">
        <div class="container text-center">
            <p class="mb-0">
                Dikembangkan oleh Mahasiswa Prodi Teknik Informatika UNRI
                (<span class="green-text">Desi, Murni, dan Syahirah</span>)
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>