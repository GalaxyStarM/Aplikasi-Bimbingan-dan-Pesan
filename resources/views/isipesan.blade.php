<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesan Baru</title>

    <!-- Bootstrap 5.3.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts (Open Sans dan Viga) -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .navbar-brand {
            font-family: 'Viga', sans-serif;
            font-size: 25px;
        }
        .navbar-nav .nav-link {
            font-weight: bold;
            color: black;
        }
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
            color: #28a745;
        }
        .main-content {
            padding: 80px 0 100px 0;
        }
        .footer {
            background-color: #4f5458;
            color: white;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 1000;
        }
        .green-text {
            color: #28a745;
        }
        .btn-kembali, .btn-kirim {
            background-color: #28a745;
            color: white;
            font-weight: bold;
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
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="Logo UNRI" width="40" height="40" style="margin-right: 10px;">
                SITEI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="bimbingan-link">BIMBINGAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#" id="pesan-link">PESAN</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            AKUN
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
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

            <a href="#" class="btn btn-kembali mb-3">← Kembali</a>

            <form>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subjek*</label>
                    <!-- Tambahkan placeholder "Isi subjek" -->
                    <input type="text" class="form-control" id="subject" placeholder="Isi subjek" required>
                </div>
            
                <div class="mb-3">
                    <label for="recipient" class="form-label">Penerima*</label>
                    <!-- Tambahkan placeholder "Isi penerima" -->
                    <input type="text" class="form-control" id="recipient" placeholder="Isi penerima" required>
                </div>
            
                <div class="mb-3">
                    <label for="priority" class="form-label">Prioritas*</label>
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
                    <label for="message" class="form-label">Pesan*</label>
                    <!-- Tambahkan placeholder "Isi pesan" -->
                    <textarea class="form-control" id="message" rows="5" placeholder="Isi pesan" required></textarea>
                </div>
            
                <div class="text-end">
                    <button type="submit" class="btn btn-kirim">Kirim</button>
                </div>
            </form>            
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            Dikembangkan oleh Mahasiswa Prodi Teknik Informatika UNRI 
            (<span class="green-text" style="font-weight: bold; font-family: 'Open Sans', sans-serif;">Desi, Murni, dan Syahirah</span>)
        </div>
    </footer>

    <!-- Bootstrap 5.3.3 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mengatur klik pada navbar
        const bimbinganLink = document.getElementById('bimbingan-link');
        const pesanLink = document.getElementById('pesan-link');

        bimbinganLink.addEventListener('click', function() {
            pesanLink.classList.remove('active');
            bimbinganLink.classList.add('active');
        });

        pesanLink.addEventListener('click', function() {
            bimbinganLink.classList.remove('active');
            pesanLink.classList.add('active');
        });

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
