<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pesan</title>

    <!-- Bootstrap 5.3.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts (Open Sans dan Viga) -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f6f9;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 1px 2px rgba(0,0,0,.1);
        }
        .navbar-brand {
            font-family: "Viga", sans-serif;
            font-weight: 600;
            font-size: 25px;
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
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .main-content {
            padding: 80px 0 100px 0;
        }
        .green-text {
            color: #28a745;
        }
        .btn-buat-pesan {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            margin-top: 0;
        }
        .btn-buat-pesan:hover {
            background-color: #218838;
        }
        .sidebar {
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            height: calc(100vh - 56px);
            position: fixed;
            top: 56px;
            width: 250px;
            padding-top: 20px;
            z-index: 1000;
        }
        .sidebar .nav-link {
            color: #333;
            padding: 10px 20px;
        }
        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .priority-tabs {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        .priority-tabs .nav-link {
            color: black;
            font-weight: bold;
            padding: 0 15px;
            border-right: 1px solid #dee2e6;
            margin-right: 10px;
            white-space: nowrap;
        }
        .priority-tabs .nav-link:last-child {
            border-right: none;
            margin-right: 0;
        }
        .priority-tabs .nav-link.active {
            color: #28a745 !important;
        }
        .row.d-flex {
            align-items: flex-start;
        }
        .sidebar .position-sticky {
            top: 100px;
        }
        .message-list {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .message-item {
            border-bottom: 1px solid #dee2e6;
            padding: 15px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, transform 0.2s ease;
            cursor: pointer;
        }
        .message-item-link {
        text-decoration: none;
        color: inherit;
        }
        .message-item-link:hover .message-item {
        background-color: #f8f9fa;
        cursor: pointer;
        }
        .message-item:last-child {
            border-bottom: none;
        }
        .message-item:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .message-item:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        .message-content {
            flex-grow: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: padding 0.3s ease;
        }
        .message-item:hover .message-content {
            padding-left: 10px;
        }
        .sender-info {
            display: flex;
            flex-direction: column;
            min-width: 150px;
        }
        .message-subject {
            flex-grow: 1;
            padding-right: 10px;
            font-weight: bold;
            color: #192F59;
        }
        .message-meta {
            display: flex;
            align-items: center;
        }
        .message-priority {
            margin-right: 15px;
        }
        .message-time {
            min-width: 50px;
            text-align: right;
        }

        /* Responsive styles */
        @media (max-width: 991.98px) {
            .sidebar {
                position: static;
                height: auto;
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #dee2e6;
            }
            .content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            .main-content {
                padding-top: 60px;
            }
            .message-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .avatar {
                margin-bottom: 10px;
            }
            .message-content {
                width: 100%;
            }
            .sender-info {
                margin-bottom: 5px;
            }
            .message-subject {
                padding-left: 0;
                margin-bottom: 5px;
            }
            .message-meta {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (min-width: 992px) {
            .sidebar {
                width: 20%;
                max-width: 250px;
            }
            .content {
                margin-left: 20%;
                width: 80%;
                max-width: calc(100% - 250px);
            }
        }

        @media (min-width: 1200px) {
            .sidebar {
                width: 16.666667%;
            }
            .content {
                margin-left: 16.666667%;
                width: 83.333333%;
            }
        }

        @media (min-width: 1400px) {
            .sidebar {
                width: 14.285714%;
            }
            .content {
                margin-left: 14.285714%;
                width: 85.714286%;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="Logo UNRI" width="40" height="40" class="d-inline-block align-top me-2">
                SITEI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">BIMBINGAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/dashboardpesan">PESAN</a>
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row d-flex">
                <!-- Sidebar -->
                <div class="col-lg-3 col-xl-2 d-lg-block sidebar">
                    <div class="position-sticky">
                        <button class="btn btn-buat-pesan w-100 mb-3">
                            <i class="bi bi-plus-circle"></i> Buat pesan
                        </button>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    <i class="bi bi-inbox"></i> Pesan Masuk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-send"></i> Pesan Terkirim
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-clock-history"></i> Riwayat
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Content -->
                <div class="col-lg-9 col-xl-10 content">
                    <!-- Priority Tabs -->
                    <div class="priority-tabs mb-3">
                        <a class="nav-link active" href="#">High (1)</a>
                        <a class="nav-link" href="#">Medium (0)</a>
                        <a class="nav-link" href="#">Low (0)</a>
                        <a class="nav-link" href="#">Semua (1)</a>
                    </div>

                    <!-- Message List -->
                    <div class="message-list">
                        <a href="/tampilanisipesan" class="message-item-link">
                            <div class="message-item">
                                <img src="{{ asset('images/fotodesi.jpeg') }}" alt="Avatar" class="avatar">
                                <div class="message-content">
                                    <div class="sender-info">
                                        <strong>Desi Maya Sari</strong>
                                        <small>2107110665</small>
                                    </div>
                                    <div class="message-subject">Bimbingan KRS</div>
                                    <div class="message-meta">
                                        <span class="message-priority badge bg-danger">High</span>
                                        <span class="message-time">15:30</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>                                       
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container text-center">
            <p class="mb-0">
                Dikembangkan oleh Mahasiswa Prodi Teknik Informatika UNRI 
                (<span class="green-text">Desi, Murni, dan Syahirah</span>)
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5.3.3 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>