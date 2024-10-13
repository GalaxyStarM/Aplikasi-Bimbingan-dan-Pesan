<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Isi Pesan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f6f9;
            padding-top: 56px;
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
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .main-content {
            padding: 20px 0 60px 0;
        }
        .btn-kembali {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border: none;
        }
        .btn-kembali:hover {
            background-color: #218838;
        }
        .btn-kembali:active, 
        .btn-kembali:focus {
            background-color: #1e7e34;
            color: white;
            outline: none;
            box-shadow: none;
        }
        .message-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
        }
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .message-header .name {
            font-weight: bold;
            font-size: 18px;
        }
        .message-header .priority {
            color: red;
            font-weight: bold;
        }
        .message-body {
            font-size: 16px;
        }
        .attachment {
            margin-top: 20px;
            font-size: 14px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 10px;
        }
        .attachment-header {
            font-weight: bold;
            margin-bottom: 10px;
            color: #495057;
        }
        .attachment-item {
            display: flex;
            align-items: center;
            padding: 5px 0;
        }
        .attachment-icon {
            margin-right: 10px;
            font-size: 18px;
            color: #28a745;
        }
        .attachment-link {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }
        .attachment-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .attachment-size {
            margin-left: auto;
            color: #6c757d;
            font-size: 12px;
        }
        .title-divider {
            border-bottom: 1px solid #ccc;
            width: 100%;
        }
        .profile-img {
            border: 2px solid blue;
        }
        .name-and-id .name {
            font-size: 18px;
            font-weight: bold;
        }
        .name-and-id .id {
            color: #6c757d;
            font-size: 14px;
        }
        .priority {
            font-weight: bold;
        }
        .message-time {
            font-size: 14px;
            color: #6c757d;
        }
        h2.mb-4 {
            font-size: 24px;
            font-weight: bold;
            margin-top: 1rem;
        }
        h4.mb-4 {
            font-size: 20px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 20px;
            }
            .main-content {
                padding-top: 15px;
            }
            h2.mb-4 {
                font-size: 22px;
            }
            h4.mb-4 {
                font-size: 18px;
            }
            .message-info {
                flex-direction: row;
                align-items: center;
                flex-wrap: wrap;
            }
            .name-and-id {
                margin-left: 10px;
            }
            .col-md-4.text-md-end {
                text-align: left !important;
                margin-top: 10px;
            }
            .message-card {
                padding: 15px;
            }
            .message-body {
                font-size: 14px;
            }
            .attachment {
                font-size: 12px;
            }
            .footer {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
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

    <div class="main-content">
        <div class="container">
            <h2 class="mb-4">Isi Pesan</h2>
            <hr class="title-divider mb-4">
            <a href="/dashboardpesan" class="btn btn-kembali mb-3">← Kembali</a>

            <h4 class="mb-4">Bimbingan KRS</h4>
            <div class="row mb-4">
                <div class="col-12 col-md-8">
                    <div class="message-info d-flex align-items-center">
                        <img src="{{ asset('images/fotodesi.jpeg') }}" alt="Profile" class="profile-img rounded-circle" width="50" height="50">
                        <div class="name-and-id ms-3">
                            <div class="name">Desi Maya Sari</div>
                            <div class="id text-muted">2107110665</div>
                        </div>
                    </div>                                                                           
                </div>
                <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="priority text-danger fw-bold">High</div>
                    <div class="message-time text-muted">15:30, 26 September 2024</div>
                </div>
            </div>

            <div class="message-card mt-4">
                <div class="message-body">
                    <p>Assalamualaikum ibu,</p>
                    
                    <p>Selamat sore.</p>
                    
                    <p>Saya Desi Maya Sari dari Prodi Teknik Informatika ingin melakukan bimbingan KRS. Karena itu, apakah ibu ada di kampus?</p>
                    
                    <p>Terima kasih, bu.</p>
                    
                    <p>Selamat sore.</p>
                    
                    <p>Wassalamualaikum.</p>
                </div>
                <div class="attachment">
                    <div class="attachment-header">
                        <i class="fas fa-paperclip"></i> Lampiran
                    </div>
                    <div class="attachment-item">
                        <i class="fas fa-file-pdf attachment-icon"></i>
                        <a href="#" class="attachment-link">KHS_Desi Maya Sari.pdf</a>
                        <span class="attachment-size">2.3 MB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">
                Dikembangkan oleh Mahasiswa Prodi Teknik Informatika UNRI 
                (<span style="color: #28a745;">Desi, Murni dan Syahirah</span>)
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>