<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITEI - Sistem Informasi Teknik Elektro dan Informatika</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 1px 2px rgba(0,0,0,.1);
        }
        .navbar-brand {
            font-family: "Viga", sans-serif;
            font-weight: 700;
            font-size: 24px;
        }
        .nav-link {
            font-weight: 600;
        }
        .nav-link.active {
            color: #28a745 !important;
            font-weight: bold;
        }
        .nav-link:hover {
            color: #36c482;
        }
        .content {
            margin-top: 80px;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .table-dark th {
            background-color: #343a40;
            border-color: #454d55;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .green-text {
            color: #28a745;
        }
        .table {
            margin-bottom: 0;
        }
        .pagination {
            margin-bottom: 0;
        }
        .card-header {
            background-color: #e9ecef;
            border-bottom: none;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
        }
        .nav-tabs .nav-link.active {
            color: #495057;
            background-color: transparent;
            border-bottom: 3px solid #28a745;
        }
        .nav-tabs .nav-link:hover{
            color: #36c482;
        }
        .sub-title{
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="Logo UNRI" width="30" height="30" class="d-inline-block align-top me-2">
                SITEI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">BIMBINGAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboardpesan">PESAN</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <div class="content container">
        <h4 class="sub-title pt-2">Usulan Bimbingan</h4>
        <hr>
        <button class="btn btn-success mb-4">+ Pilih Jadwal Bimbingan</button>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Usulan Bimbingan (0)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Daftar Jadwal (0)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Riwayat (0)</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
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
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-dark">
                                <th>No. <i class="fas fa-sort"></i></th>
                                <th>NIM <i class="fas fa-sort"></i></th>
                                <th>Nama <i class="fas fa-sort"></i></th>
                                <th>Jenis Bimbingan <i class="fas fa-sort"></i></th>
                                <th>Tanggal <i class="fas fa-sort"></i></th>
                                <th>Waktu <i class="fas fa-sort"></i></th>
                                <th>Status <i class="fas fa-sort"></i></th>
                                <th>Aksi <i class="fas fa-sort"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="text-center">Belum ada usulan Bimbingan</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="mb-0">Menampilkan 1 sampai 1 dari 1 entri</p>
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