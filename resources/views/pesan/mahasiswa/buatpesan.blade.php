<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesan Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        form .form-label {
            font-weight: bold;
        }
        
        /* Style untuk opsi dalam select */
        select.form-select option {
            color: black;
            font-weight: bold;
        }
        /* Warna abu-abu untuk opsi yang disabled */
        select.form-select option:disabled {
            color: #6c757d;
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
                        <a class="nav-link active" style="font-weight: bold;" href="/dashboardpesan">KONSULTASI</a>
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

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="mb-2 gradient-text fw-bold">Buat Pesan Baru</h1>
        <hr></hr>
        <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
            <a href="/dashboardpesan">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </button>

        <form>
            <div class="mb-3">
                <label for="subject" class="form-label">Subjek<span style="color: red;">*</span></label>
                <!-- Tambahkan placeholder "Isi subjek" -->
                <input type="text" class="form-control" id="subject" placeholder="Isi subjek" required>
            </div>
            
            <div class="mb-3">
                <label for="recipient" class="form-label">Penerima<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="recipient" placeholder="Isi penerima" required>
            </div>
            
            <div class="mb-3">
                <label for="priority" class="form-label">Prioritas<span style="color: red;">*</span></label>
                <select class="form-select" id="priority" required>
                    <option value="" selected disabled>Pilih Prioritas</option>
                    <option value="high">Medesak</option>
                    <option value="medium">Umum</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="attachment" class="form-label">Lampiran (Opsional)</label>
                <!-- Tambahkan placeholder "Isi lampiran berupa link Google Drive" -->
                <input type="text" class="form-control" id="attachment" placeholder="Isi lampiran berupa link Google Drive">
            </div>
            
            <div class="mb-3">
                <label for="message" class="form-label">Pesan<span style="color: red;">*</span></label>
                <!-- Tambahkan placeholder "Isi pesan" -->
                <textarea class="form-control" id="message" rows="5" placeholder="Isi pesan" required></textarea>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-gradient">Kirim</button>
            </div>
        </form>            
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container text-center">
            <p class="mb-0">
                Dikembangkan oleh Mahasiswa Prodi Teknik Informatika UNRI 
                (<span class="green-text">Desi, Murni, dan Syahirah</span>)
            </p>
        </div>
        <footer>
            <!-- Footer content -->
        </footer>
        
        <!-- Bootstrap 5.3.3 JS CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery UI CDN -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        
        <script>
            // Mengubah warna teks "Pilih Prioritas" saat ini menggunakan JavaScript
            const prioritySelect = document.getElementById('priority');
            prioritySelect.addEventListener('change', function() {
                if (this.value === "") {
                    this.style.color = "#6c757d";  // Warna abu-abu
                } else {
                    this.style.color = "black";  // Warna normal
                }
            });
        
            // Mengatur warna awal ketika halaman dimuat
            if (prioritySelect.value === "") {
                prioritySelect.style.color = "#6c757d";  // Warna abu-abu
            }
        
            // Menginisialisasi autocomplete untuk input penerima
            $(document).ready(function() {
                var dosenList = [
                    "Dr. Feri Candra, S.T., M.T.",
                    "Dr. Dahliyusmanto S.Kom., M.Sc.",
                    "Dr. Irsan Taufik Ali, S.T., M.T.",
                    "Noveri Lysbetti Marpaung, S.T., M.Sc.",
                    "Rahyul Amri, S.T., M.T.",
                    "Linna Oktaviana Sari, S.T., M.T.",
                    "Salhazan Nasution, S.Kom., MIT.",
                    "T. Yudi Hadiwandra, S.Kom., M.Kom.",
                    "Rahmat Rizal Andhi, S.T., M.T.",
                    "Edi Susilo, Spd., M,Kom.,M.Eng",
                    "Dian Ramadhani, S.T., M.T.",
                ];
        
                $("#recipient").autocomplete({
                    source: dosenList,
                    minLength: 1 // Menampilkan saran setelah 1 karakter diketik
                });
            });
        </script>
        
        </body>
        </html>        
