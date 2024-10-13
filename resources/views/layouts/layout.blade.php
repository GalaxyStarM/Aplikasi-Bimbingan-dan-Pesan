<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pesan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            font-family: 'Open Sans', sans-serif; /* Menggunakan font Open Sans untuk teks */
        }

        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            position: fixed;
            height: 100%;
            padding-top: 10px; /* Mengurangi margin atas di sidebar */
            margin-top: 60px; /* Menghindari overlap dengan navbar */
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
            margin-left: 250px;
            padding: 10px;
            width: calc(100% - 250px);
            flex-grow: 1;
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
            position: fixed; /* Tetap di atas */
            top: 0; /* Tetap di bagian atas */
            z-index: 1000; /* Pastikan navbar di atas elemen lain */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Menambahkan shadow pada navbar */
        }

        .navbar-left {
            display: flex;
            align-items: center;
            margin-left: 60px; /* Menambah jarak ke kiri untuk menggeser ke kanan */
        }

        .navbar-left img {
            height: 40px;
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
            margin-top: 0; /* Menghapus margin atas untuk meratakan dengan logo */
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

        .btn-buat-pesan {
            background-color: #28a745;
            color: white;
            width: 90%;
            margin: 15px auto;
            display: block;
            padding: 10px;
            text-align: center;
            border: none;
            border-radius: 5px;
            margin-top: 20px; /* Memberi jarak dari atas sidebar */
            font-weight: bold; /* Membuat teks pada tombol tebal */
        }

        .btn-buat-pesan i {
            margin-right: 8px; /* Memberi jarak antara ikon dan teks */
        }

        .btn-buat-pesan:hover {
            background-color: #218838; /* Warna latar saat tombol hover */
        }

        .footer {
            background-color: #4f5458; /* Abu-abu */
            color: white; /* Warna font putih */
            text-align: center;
            padding: 15px;
            font-size: 14px;
            position: fixed;
            width: 100%; /* Lebar 100% untuk memenuhi seluruh layar */
            bottom: 0;
            left: 0; /* Mulai dari ujung kiri */
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

        /* Gaya untuk teks "Tidak Ada Pesan" */
        .no-message {
            text-align: center; /* Rata tengah */
            margin: 250px 0; /* Margin vertikal (40px atas dan bawah) */
            font-size: 14px; /* Ukuran font */
            color: #a1a6aa; /* Warna teks */
            font-weight: bold; /* Teks tebal */
            font-family: 'Open Sans', sans-serif; 
        }

        /* Gaya untuk teks hijau di footer */
        .green-text {
            color: #28a745; /* Warna hijau */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-left">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="Logo UNRI"> <!-- Mengganti logo UNRI -->
            <span>SITEI</span> <!-- Bacaan SITEI -->
            <div class="nav-feature">
                <a href="/" class="active" style="margin-left: 50px;">BIMBINGAN</a> <!-- Tambahkan style margin di sini -->
                <a href="#">PESAN</a>
            </div>            
        </div>
        <div class="navbar-right">
            <a href="#" class="account-link">AKUN <i class="fas fa-caret-down"></i></a> <!-- Tautan Akun dengan ikon segitiga terbalik -->
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <button class="btn-buat-pesan">
            <i class="fas fa-pencil-alt"></i> Buat Pesan <!-- Tambahkan ikon pensil -->
        </button>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-inbox"></i> Pesan Masuk
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-paper-plane"></i> Pesan Terkirim
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-history"></i> Riwayat
                </a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container mt-4">
            @yield('content')
        </div>
        <!-- Footer -->
        <div class="footer">
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
</body>
</html>
