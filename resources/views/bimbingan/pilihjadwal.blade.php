<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITEI | Pilih Jadwal</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">\
    <!-- Google Fonts (Open Sans dan Viga) -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">

    <style>
        /* Yang diambil */
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
            font-weight: bold;
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
            background-color: #218838;
            color: white; 
        }
        .content-header h2 {
            font-size: 24px;
            font-weight: bold;
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
        .mb-4 {
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
    
    <!--Content-->
    <div class="main-content">
        <div class="container">
            <div class="content-header">
                <h4 class="mb-4">Pilih Jadwal Bimbingan</h4>
            </div>
            <hr>

            <a href="/" class="btn btn-kembali mb-4">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

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


       
    