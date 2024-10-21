<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pesan</title>

    <!-- Bootstrap 5.3.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts (Open Sans dan Viga) -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

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
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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
        .message-list {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .message-item {
            display: flex;
            align-items: flex-start;
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .message-item-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .message-item-link:hover .message-item,
        .message-item-link:focus .message-item{
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .message-item:last-child {
            border-bottom: none;
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
            flex-direction: column;
            justify-content: space-between;
        }
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
        }

        .sender-info {
            display: flex;
            flex-direction: column;
            min-width: 150px;
        }

        .message-subject {
            flex-grow: 1;
            padding: 0 15px;
            font-weight: bold;
            color: #192F59;
        }

        .message-meta {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .message-priority {
            margin-right: 10px;
        }

        .message-time {
            min-width: 50px;
            text-align: right;
        }
        
        .dashboard-summary {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .summary-item {
            text-align: center;
            padding: 15px;
        }
        .summary-icon {
            font-size: 2.5rem;
            color: #28a745;
            margin-bottom: 10px;
        }
        .summary-title {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #343a40;
        }
        .message-filters {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px;
            margin-bottom: 20px;
        }
        .filter-button {
            margin-right: 10px;
            margin-bottom: 10px;
        }
        .nav-pill .nav-link {
            color: #495057;
            padding: 10px 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .nav-pill .nav-link:hover,
        .nav-pill .nav-link:focus {
            background-color: #e9ecef;
        }
        .nav-pill .nav-link.active{
            background-color: #e9ecef;
        }
        .message-count {
            background-color: #28a745;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
            margin-left: 5px;
        }
        .sidebar {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        /* Responsive styles */
        @media (max-width: 767px) {
            .main-content {
                padding: 60px 0 80px 0;
            }
            .message-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .sender-info {
                margin-bottom: 5px;
            }

            .message-subject {
                padding: 0;
                margin-bottom: 5px;
            }

            .message-meta {
                justify-content: flex-start;
            }
            .summary-item {
                margin-bottom: 15px;
            }
            .filter-button {
                width: calc(50% - 5px);
                margin-right: 5px;
            }
            .filter-button:nth-child(2n) {
                margin-right: 0;
            }
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
            <a class="navbar-brand me-4" href="/dashboard">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="SITEI Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
                SITEI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" style="font-weight: bold;" href="/dashboard">BIMBINGAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" style="font-weight: bold;" href="/dashboardpesan">PESAN</a>
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

    <!-- Konten Utama -->
    <div class="container mt-5">        
        <!-- Ringkasan Dashboard -->
        <div class="dashboard-summary row">
            <div class="col-md-4 col-sm-6 summary-item">
                <i class="bi bi-envelope summary-icon"></i>
                <h3 class="summary-title">Total Pesan</h3>
                <p class="summary-value">25</p>
            </div>
            <div class="col-md-4 col-sm-6 summary-item">
                <i class="bi bi-envelope-open summary-icon"></i>
                <h3 class="summary-title">Pesan Terbaca</h3>
                <p class="summary-value">18</p>
            </div>
            <div class="col-md-4 col-sm-6 summary-item">
                <i class="bi bi-envelope-exclamation summary-icon"></i>
                <h3 class="summary-title">Pesan Belum Dibaca</h3>
                <p class="summary-value">7</p>
            </div>
        </div>

        <div class="row">
        <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="sidebar">
                    <button class="btn btn-buat-pesan w-100 mb-3" onclick="window.location.href='http://127.0.0.1:8000/buatpesan';">
                        <i class="bi bi-plus-circle"></i> Buat Pesan Baru
                    </button>                        
                    <div class="nav flex-column nav-pill" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="btn nav-link" id="v-pills-active-tab" data-bs-toggle="pill" data-bs-target="#v-pills-active" type="button" role="tab">
                            Pesan Aktif <span class="message-count">3</span>
                        </button>
                        <button class="btn nav-link" id="v-pills-history-tab" data-bs-toggle="pill" data-bs-target="#v-pills-history" type="button" role="tab">
                            Riwayat Pesan <span class="message-count">5</span>
                        </button>
                    </div>
                </div>
            </div>

               <!-- Main Content -->
               <div class="col-md-9">
                <!-- Filter Pesan -->
                <div class="message-filters">
                    <div class="row">
                        <div class="col-6 col-sm-3 mb-2">
                            <button class="btn btn-outline-primary filter-button active w-100" id="filter-all">Semua</button>
                        </div>
                        <div class="col-6 col-sm-3 mb-2">
                            <button class="btn btn-outline-danger filter-button w-100" id="filter-tinggi">Prioritas Tinggi</button>
                        </div>
                        <div class="col-6 col-sm-3 mb-2">
                            <button class="btn btn-outline-warning filter-button w-100" id="filter-sedang">Prioritas Sedang</button>
                        </div>
                        <div class="col-6 col-sm-3 mb-2">
                            <button class="btn btn-outline-success filter-button w-100" id="filter-rendah">Prioritas Rendah</button>
                        </div>
                    </div>
                </div>

                 <!-- Daftar Pesan -->
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-active" role="tabpanel">
                            <div class="message-list">
                                <a href="/tampilanpesan" class="message-item-link">
                                    <div class="message-item" data-priority="tinggi">
                                        <img src="https://via.placeholder.com/40" alt="Avatar" class="avatar">
                                        <div class="message-content">
                                            <div class="message-header">
                                                <div class="sender-info">
                                                    <strong>Syahirah Tri Meilina</strong>
                                                    <small>2107110255</small>
                                                </div>
                                                <div class="message-subject">Bimbingan Skripsi</div>
                                                <div class="message-meta">
                                                    <span class="message-priority badge bg-danger">Tinggi</span>
                                                    <span class="message-time">15:30</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                </a>
                                <a href="http://127.0.0.1:8000/isipesan" class="message-item-link">
                                    <div class="message-item" data-priority="sedang">
                                        <img src="https://via.placeholder.com/40" alt="Avatar" class="avatar">
                                        <div class="message-content">
                                            <div class="message-header">
                                                <div class="sender-info">
                                                    <strong>Desi Maya Sari</strong>
                                                    <small>2107110665</small>
                                                </div>
                                                <div class="message-subject">Bimbingan KRS</div>
                                                <div class="message-meta">
                                                    <span class="message-priority badge bg-warning">Sedang</span>
                                                    <span class="message-time">Kemarin</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="/tampilanpesan" class="message-item-link">
                                    <div class="message-item" data-priority="rendah">
                                        <img src="https://via.placeholder.com/40" alt="Avatar" class="avatar">
                                        <div class="message-content">
                                            <div class="message-header">
                                                <div class="sender-info">
                                                    <strong>Tri Murniati</strong>
                                                    <small>2107112735</small>
                                                </div>
                                                <div class="message-subject">Konsultasi MBKM</div>
                                                <div class="message-meta">
                                                    <span class="message-priority badge bg-success">Rendah</span>
                                                    <span class="message-time">2 hari lalu</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    <div class="tab-pane fade" id="v-pills-history" role="tabpanel">
                        <!-- Add content for history messages here -->
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

<!-- Custom JavaScript for filtering -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-button');
        const messageItems = document.querySelectorAll('.message-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.id.split('-')[1]; // Get the filter type from button id

                // Remove active class from all buttons and add it to the clicked button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Show/hide message items based on the selected filter
                messageItems.forEach(item => {
                    if (filter === 'all' || item.dataset.priority === filter) {
                        item.closest('.message-item-link').style.display = 'block';
                    } else {
                        item.closest('.message-item-link').style.display = 'none';
                    }
                });
            });
        });
    });
</script>
</body>

</html>
