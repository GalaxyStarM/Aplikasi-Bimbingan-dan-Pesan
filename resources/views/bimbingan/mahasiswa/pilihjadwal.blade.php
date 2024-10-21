<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITEI | Pilih Jadwal</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts (Open Sans dan Viga) -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">

    <style>
        /* Yang diambil */
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
        form .form-label {
            font-weight: bold;
        }
        
        select.form-select option {
            color: black;
            font-weight: bold;
        }

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
            <a class="navbar-brand me-4" href="/">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="SITEI Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
                SITEI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" style="font-weight: bold;" href="/">BIMBINGAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="font-weight: bold;" href="/dashboardpesan">PESAN</a>
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
    
    <!--Content-->
    <div class="container mt-5">
        <h1 class="mb-2 gradient-text fw-bold">Pilih Jadwal Bimbingan</h1>
        <hr></hr>
        <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
            <a href="/">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </button>

        <form>
            <div class="mb-3">
                <label for="Pilih Dosen" class="form-label">Pilih Dosen<span style="color: red;">*</span></label>
                <select class="form-select" id="Pilih Dosen" required>
                    <option value="" selected disabled>- Pilih Dosen -</option>
                    <option value="">Yusnita Rahayu, ST, M.Eng, Ph.D</option>
                    <option value="">Feri Candra, S.T., M.T., Ph.D</option>
                    <option value="">Rahmat Rizal Andhi, S.T., M.Τ.</option>
                    <option value="">Edi Susilo, S.Pd., M.Kom., M.Eng.</option>
                    <option value="">Dahliyusmanto S.Kom., MSc., Ph.D</option>
                    <option value="">Dr. Irsan Taufik Ali, S.T., Μ.Τ.</option>
                    <option value="">Rahyul Amri, S.T., M.T.</option>
                    <option value="">T. Yudi Hadiwandra, S.Kom., M.Kom.</option>
                    <option value="">Salhazan Nasution, S.Kom., MIT.</option>
                    <option value="">Noveri Lysbetti Marpaung, ST., M.Sc.</option>
                    <option value="">Linna Oktaviana Sari, ST., MT</option>
                    <option value="">Dian Ramadhani, S.T., M.T.</option>
                    <option value="">Prof. Azriyenni, S.T., M.Eng., Ph.D</option>
                    <option value="">Iswadi HR, S.T., M.T., Ph.D.</option>
                    <option value="">Dr. Febrizal, S.T., M.T.</option>
                    <option value="">Dr. Ir. Antonius Rajagukguk, M.T.</option>
                    <option value="">Indra Yasri, S.T., M.T., Ph.D</option>
                    <option value="">Suwitno, S.T., Μ.Τ.</option>
                    <option value="">Nurhalim S.T., M.T.</option>
                    <option value="">Dian Yayan Sukma, S.T., M.Τ.</option>
                    <option value="">Ery Safrianti, S.T., M.T.</option>
                    <option value="">Feranita, S.T., M.T.</option>
                    <option value="">R.A Rizka Qori Yuliani Putri S.ST., MT.</option>
                    <option value="">Dr. Fri Murdiya, S.T., M.T.</option>
                    <option value="">Ir. Edy Ervianto, M.T.</option>
                    <option value="">Eddy Hamdani, S.T., M.T.</option>
                    <option value="">Budhi Anto, S.T., MT.</option>
                    <option value="">Anhar, S.T., M.T., Ph.D.</option>
                    <option value="">Amir Hamzah, ST., MT</option>
                    <option value="">Dr. Dewi Nasien., M.Sc</option>
                    <option value="">Dr. Esa Prakasa, MT</option>
                    <option value="">Assoc. Prof. Ping Jack Soh, PhD</option>
                    <option value="">Yudi Yulius Maulana, ST., MT</option>
                    <option value="">Yussi Perdana Saputra S.T., M.T., IPM., Asean-Eng</option>
                    <option value="">Teguh Praludi, M.T</option>
                    <option value="">Arbiansyah Ali</option>
                    <option value="">Prof. Dr. Ing. Mudrik Alaydrus</option>
                    <option value="">Dr Eng Teguh Firmansyah, ST., MT., IPM</option>
                    <option value="">Dr. HUANYU LARRY CHENG</option>
                    <option value="">Prof. Chia Hao Ku Ph.D</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="- Pilih Jenis Bimbingan -" class="form-label">Pilih Jenis Bimbingan<span style="color: red;">*</span></label>
                <select class="form-select" id="Pilih Jenis Bimbingan" required>
                    <option value="" selected disabled>- Pilih Jenis Bimbingan -</option>
                    <option value="high">Kartu Rencana Studi (KRS)</option>
                    <option value="medium">Kerja Praktek (KP)</option>
                    <option value="low">Merdeka Belajar Kampus Merdeka (MBKM)</option>
                    <option value="low">Skripsi</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="pilihTanggal" class="form-label">Pilih Tanggal<span style="color: red;">*</span></label>
                <select class="form-select" id="pilihTanggal" required>
                    <option value="" selected disabled>- Pilih Tanggal -</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="pilihJadwal" class="form-label">Pilih Jadwal<span style="color: red;">*</span></label>
                <select class="form-select" id="pilihJadwal" required>
                    <option value="" selected disabled>- Pilih Jadwal -</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="Deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="message" rows="5" placeholder="Deskripsi" required></textarea>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-kirim btn-success">Kirim</button>
            </div>
        </form>            
    </div>

    <!--Footer-->
    <footer class="footer mt-5">
        <div class="container text-center">
            <p class="mb-0">
                Dikembangkan oleh Mahasiswa Prodi Teknik Informatika UNRI 
                (<span class="green-text">Desi, Murni, dan Syahirah</span>)
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalSelect = document.getElementById('pilihTanggal');
            const jadwalSelect = document.getElementById('pilihJadwal');
            
            function addDays(date, days) {
                const result = new Date(date);
                result.setDate(result.getDate() + days);
                return result;
            }
            
            function formatDate(date) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }
            
            const today = new Date();
            for (let i = 0; i < 30; i++) {
                const date = addDays(today, i);
                const option = document.createElement('option');
                option.value = formatDate(date);
                option.textContent = formatDate(date);
                tanggalSelect.appendChild(option);
            }

            // Fungsi untuk mengisi jadwal berdasarkan tanggal yang dipilih
            function populateJadwal(selectedDate) {
                // Hapus semua opsi jadwal yang ada
                jadwalSelect.innerHTML = '<option value="" selected disabled>- Pilih Jadwal -</option>';

                // Contoh jadwal (bisa diganti dengan data sebenarnya dari backend)
                const jadwalContoh = [
                    { waktu: '09:00 - 10:00', tersedia: true },
                    { waktu: '10:00 - 11:00', tersedia: false },
                    { waktu: '11:00 - 12:00', tersedia: true },
                    { waktu: '13:00 - 14:00', tersedia: true },
                    { waktu: '14:00 - 15:00', tersedia: false }
                ];

                jadwalContoh.forEach(jadwal => {
                    const option = document.createElement('option');
                    option.value = jadwal.waktu;
                    option.textContent = jadwal.waktu;
                    option.disabled = !jadwal.tersedia;
                    jadwalSelect.appendChild(option);
                });

                if (jadwalSelect.options.length === 1) {
                    const option = document.createElement('option');
                    option.value = "";
                    option.textContent = "Belum Ada Jadwal";
                    option.disabled = true;
                    jadwalSelect.appendChild(option);
                }
            }

            // Event listener untuk perubahan tanggal
            tanggalSelect.addEventListener('change', function() {
                populateJadwal(this.value);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>


       
    