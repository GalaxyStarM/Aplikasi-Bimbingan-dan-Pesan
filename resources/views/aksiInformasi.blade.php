<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITEI | Detail Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Viga&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f6f9;
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
            font-weight: 600;
        }
        .nav-link.active {
            color: #28a745 !important;
            font-weight: bold;
        }
        .nav-link:hover {
            color: #36c482;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .content{
            margin-top: 80px;
        }

        .footer {
            background-color: #343A40;
            color: #fff;
            padding: 10px 0;
            margin-top: 20px;
        }

        .green-text {
            color: #28a745;
        }

        .btn-kembali {
            background-color: #28a745;
            color: white;
        }

        .btn-kembali:hover {
            background-color: #218838;
            color: white;
        }

        .status-badge {
            background-color: #17a2b8;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .mb-4 {
            margin-bottom: 15px;
            border-bottom: 1px solid #acb5be;
            padding-bottom: 10px;
            font-weight: 600;
        }

        .h4,
        h4 {
            font-size: 1.5rem;
        }

        .btn-kembali {
            background-color: #28a745;
            color: white;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
            width: 100px;
        }

        .btn-kembali i {
            font-size: 12px;
        }

        .btn-kembali:hover {
            background-color: #218838;
            color: white;
        }

        .status-badge {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 15px;
        }

        .text-bold {
            font-weight: 600;
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
                        <a class="nav-link active" href="/">BIMBINGAN</a>
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

    <div class="container content">
        <h4 class="mb-4">Detail Mahasiswa</h4>

        <a href="#" class="btn btn-kembali mb-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

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
                        <span class="status-badge">USULAN DISETUJUI</span>
                    </p>
                    <p class="card-title text-secondary text-sm">Keterangan</p>
                    <p class="card-text text-start">Usulan Jadwal Bimbingan Disetujui</p>
                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
