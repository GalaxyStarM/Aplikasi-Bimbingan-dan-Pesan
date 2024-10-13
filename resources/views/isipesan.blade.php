<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesan Baru</title>

    <!-- Bootstrap 5.3.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts (Open Sans dan Viga) -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">

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
        .btn-kembali, .btn-kirim {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }
        .btn-kembali:hover, .btn-kirim:hover {
            background-color: 
        }
        .content-header h2 {
            font-size: 24px;
            font-weight: bold;
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
        <div class="container">
            <div class="content-header">
                <h2>Buat Pesan Baru</h2>
            </div>
            <hr>

            <a href="/dashboardpesan" class="btn btn-kembali btn-success mb-3">← Kembali</a>

            <form>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subjek<span style="color: red;">*</span></label>
                    <!-- Tambahkan placeholder "Isi subjek" -->
                    <input type="text" class="form-control" id="subject" placeholder="Isi subjek" required>
                </div>
            
                <div class="mb-3">
                    <label for="recipient" class="form-label">Penerima<span style="color: red;">*</span></label>
                    <!-- Tambahkan placeholder "Isi penerima" -->
                    <input type="text" class="form-control" id="recipient" placeholder="Isi penerima" required>
                </div>
            
                <div class="mb-3">
                    <label for="priority" class="form-label">Prioritas<span style="color: red;">*</span></label>
                    <select class="form-select" id="priority" required>
                        <option value="" selected disabled>Pilih Prioritas</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
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
                    <button type="submit" class="btn btn-kirim btn-success">Kirim</button>
                </div>
            </form>            
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
    </script>
</body>
</html>
