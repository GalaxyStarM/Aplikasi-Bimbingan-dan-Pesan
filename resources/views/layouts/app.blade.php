<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Bimbingan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
        }
        /* body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            font-family: 'Open Sans', sans-serif; /* Menggunakan font Open Sans untuk teks */
        } */
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0 auto;
            max-width: 1200px;
        }
        .nav-link {
            color: #000; /* Mengatur warna teks menjadi hitam */
            padding: 10px 15px;
            display: block;
            font-weight: bold; /* Mengatur teks menjadi tebal */
        }
        .nav-link i {
            margin-right: 10px; /* Memberi jarak antara ikon dan teks */
        }
        .nav-link:hover {
            background-color: #e9ecef; /* Mengatur latar belakang saat hover */
            color: #28a745; /* Mengubah warna teks menjadi hijau saat hover */
        }
        /* Ganti warna saat tautan aktif atau setelah diklik */
        .nav-link:focus, .nav-link:active {
            background-color: #e9ecef; /* Latar belakang hijau terang saat aktif */
            color: #28a745; /* Mengubah warna teks menjadi hijau */
        }
        .nav-link.active {
            color: #28a745;
            font-weight: bold;
        }
        .content {
            flex-grow: 1;
            padding: 10px;
            padding-top: 20px; /* Ruang dari navbar */
            margin-top: 46px; /* Tambahkan ini untuk memberikan ruang ekstra di atas */
        }
        .navbar {
            background-color: white; /* Mengubah warna navbar menjadi putih */
            color: black; /* Mengubah warna font menjadi hitam */
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            top: 0; /* Tetap di bagian atas */
            z-index: 1000; /* Pastikan navbar di atas elemen lain */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Menambahkan shadow pada navbar */
        }
        .navbar-left {
            display: flex;
            align-items: center;
        }
        .navbar-left img {
            height: 30px;
            margin-right: 15px;
        }
        .navbar-left span {
            font-size: 24px;
            font-weight: bold; /* Mengatur teks menjadi tebal */
            font-family: 'Viga', sans-serif; /* Menggunakan font Viga untuk SITEI */
        }
        .nav-feature {
            display: flex;
            gap: 20px; /* Jarak antar-tautan */
            margin-left: 20px; /* Mengurangi margin untuk mendekatkan ke teks SITEI */
        }
        .navbar-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .nav-feature a {
            color: black; /* Mengubah warna tautan menjadi hitam */
            text-decoration: none;
            font-weight: bold; /* Mengatur teks menjadi tebal */
        }
        .nav-feature a:hover { /* Hover untuk tautan di navbar */
            color: #28a745; /* Mengubah warna teks menjadi hijau saat hover */
        }
        .nav-feature a.active {
            color: #28a745; /* Mengubah warna tautan aktif menjadi hijau */
        }
        .footer {
            background-color: #4f5458; /* Abu-abu */
            color: white; /* Warna font putih */
            text-align: center;
            padding: 15px;
            font-size: 14px;
            position: fixed;
            width: 100%; /* Lebar 100% untuk memenuhi seluruh layar */
        }
        .account-link {
            display: flex;
            align-items: center;
            color: black; /* Mengubah warna teks Akun menjadi hitam */
            text-decoration: none;
            font-weight: bold; /* Mengatur teks menjadi tebal */
            margin-left: -100px; /* Menggeser sedikit ke kiri */
        }
        .account-link:hover {
            color: #28a745; /* Mengubah warna teks Akun menjadi hijau saat hover */
        }
        .account-link i {
            margin-left: 5px; /* Jarak antara teks dan ikon */
            color: black; /* Mengubah warna ikon menjadi hitam */
        }
        .account-link:hover i {
            color: #28a745; /* Mengubah warna ikon menjadi hijau saat hover */
        }
        /* Gaya untuk teks hijau di footer */
        .green-text {
            color: #28a745; /* Warna hijau */
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Navbar -->
        <div class="navbar navbar-expand-lg fixed-top">
            <div class="navbar-left">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="Logo UNRI"> <!-- Mengganti logo UNRI -->
                <span>SITEI</span> <!-- Bacaan SITEI -->
                <div class="nav-feature">
                    <a href="#" class="active" style="margin-left: 50px;">BIMBINGAN</a> <!-- Tambahkan style margin di sini -->
                    <a href="#">PESAN</a>
                </div>            
            </div>
            <div class="navbar-right">
                <a href="#" class="account-link">AKUN <i class="fas fa-caret-down"></i></a> <!-- Tautan Akun dengan ikon segitiga terbalik -->
            </div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div>
                @yield('content')
            </div>
            <!-- Footer -->
            <div class="footer fixed-bottom">
                Dikembangkan oleh Mahasiswa Prodi Teknik Informatika UNRI 
                (<span class="green-text">Desi, Murni, dan Syahirah</span>) <!-- Ubah teks menjadi hijau -->
            </div>
        </div>
        <script>
            const links = document.querySelectorAll('.nav-feature a');
            links.forEach(link => {
                link.addEventListener('click', function() {
                    links.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        </script>
    </div>
</body>
</html>