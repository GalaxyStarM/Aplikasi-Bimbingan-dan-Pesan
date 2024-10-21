<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Pesan Bimbingan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Viga&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
        .message-card {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .message-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,.15);
        }
        .message-card.student {
            border-left: 5px solid #28a745;
        }
        .message-card.teacher {
            border-left: 5px solid #007bff;
        }
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .message-header .name {
            font-weight: bold;
            font-size: 18px;
        }
        .message-header .name.student {
            color: #28a745;
        }
        .message-header .name.teacher {
            color: #007bff;
        }
        .message-body {
            font-size: 16px;
            color: #333;
        }

        .student-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
            padding: 20px;
            margin-bottom: 20px;
            position: sticky;
            top: 76px;
        }
        .student-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid #28a745;
        }
        .student-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .student-name {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 5px;
            color: #28a745;
        }
        .student-id {
            color: #6c757d;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }
        .info-table th, .info-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .info-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }
        .info-table tr:last-child td {
            border-bottom: none;
        }
        .btn-action {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 10px;
            border-radius: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
        }
        .chat-wrapper {
            display: flex;
            flex-direction: column;
        }
        .chat-container {
            padding-right: 10px;
            transition: all 0.3s ease;
        }
        .chat-container::-webkit-scrollbar {
            width: 5px;
        }
        .chat-container::-webkit-scrollbar-thumb {
            background-color: #28a745;
            border-radius: 10px;
        }
        .reply-form {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
            transition: all 0.3s ease;
        }
        .reply-form h4 {
            color: #28a745;
            margin-bottom: 15px;
        }
        .form-control {
            border-radius: 20px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
        }
        .priority {
            display: none;
        }
        .priority.high {
            background-color: #dc3545;
            color: white;
        }
        .priority.medium {
            background-color: #ffc107;
            color: black;
        }
        .priority.low {
            background-color: #28a745;
            color: white;
        }
        .attachment {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .attachment a {
            color: #007bff;
            text-decoration: none;
        }
        .attachment a:hover {
            text-decoration: underline;
        }
        .subject-info {
            margin: 20px 0; /* Menambahkan margin atas dan bawah */
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        .subject-title {
            font-weight: bold;
            color: #28a745;
            margin-bottom: 10px;
        }
        .priority-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }
        .priority-high {
            background-color: #dc3545;
            color: white;
        }
        .priority-medium {
            background-color: #ffc107;
            color: black;
        }
        .priority-low {
            background-color: #28a745;
            color: white;
        }
        .btn-action {
            width: 100%;
            margin-top: 10px; /* Menambahkan margin di atas tombol */
            margin-bottom: 10px;
            border-radius: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
        }
        .modal-content {
            border-radius: 15px;
        }
        .modal-header {
            background-color: #28a745;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .modal-title {
            font-weight: bold;
        }
        .modal-footer {
            border-top: none;
        }
        .status-ended {
            color: #dc3545;
            font-weight: bold;
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

    <div class="container mt-5">
        <h1 class="mb-2 gradient-text fw-bold">Pesan Bimbingan</h1>
        <hr></hr>
        <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
            <a href="/dashboardpesan">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </button>
        <div class="row">
            <div class="col-md-4">
                <div class="student-card">
                    <img src="{{ asset('images/fotodesi.jpeg') }}" alt="Foto Mahasiswa" class="student-photo mx-auto d-block">
                    <div class="student-info">
                        <h3 class="student-name">Desi Maya Sari</h3>
                        <p class="student-id">2107110665</p>
                        <p><i class="fas fa-graduation-cap"></i> Teknik Informatika</p>
                        <p><i class="fas fa-calendar-alt"></i> Semester 5</p>
                    </div>
                    <table class="info-table">
                        <tr>
                            <th>Subjek</th>
                            <td>Bimbingan KRS</td>
                        </tr>
                        <tr>
                            <th>Tujuan</th>
                            <td>Edi Susilo, S.Pd., M.Kom., M.Eng.</td>
                        </tr>
                        <tr>
                            <th>Prioritas</th>
                            <td><span class="priority-badge priority-high">Prioritas Tinggi</span></td>
                        </tr>
                        <tr>
                            <th>Dikirim</th>
                            <td>15:30, 26 September 2024</td>
                        </tr>
                        <tr id="statusRow" style="display: none;">
                            <th>Status</th>
                            <td class="status-ended">Pesan telah berakhir</td>
                        </tr>
                    </table>
                    <button class="btn btn-danger btn-action" id="endChatBtn"><i class="fas fa-times-circle"></i> Akhiri Pesan</button>
                </div>
            </div>
                
            <div class="col-md-8">
                <div class="chat-wrapper">
                    <div class="chat-container">
                        <div class="message-card student">
                            <div class="message-header">
                                <span class="name student"><i class="fas fa-user-circle"></i> Desi Maya Sari</span>
                                <div>
                                    <small class="text-muted"><i class="far fa-clock"></i> 15:30, 26 September 2024</small>
                                </div>
                            </div>
                            <div class="message-body">
                                <p>Assalamualaikum Pak,</p>
                                <p>Selamat sore.</p>
                                <p>Saya Desi Maya Sari dari Prodi Teknik Informatika ingin melakukan bimbingan KRS. Karena itu, apakah Bapak ada di kampus?</p>
                                <p>Terima kasih, Pak.</p>
                                <p>Wassalamualaikum.</p>
                            </div>
                            <div class="attachment">
                                <p><i class="fas fa-paperclip"></i> Lampiran:</p>
                                <a href="#" target="_blank"><i class="fas fa-file-pdf"></i> KHS_Desi_Maya_Sari.pdf</a>
                            </div>
                        </div>
                        <div class="message-card teacher">
                            <div class="message-header">
                                <span class="name teacher"><i class="fas fa-user-tie"></i> Edi Susilo, S.Pd., M.Kom., M.Eng.</span>
                                <div>
                                    <small class="text-muted"><i class="far fa-clock"></i> 16:45, 26 September 2024</small>
                                </div>
                            </div>
                            <div class="message-body">
                                <p>Waalaikumsalam</p>
                                <p>Saya ada di kampus besok dari pukul 10.00 sampai 15.00. Silakan datang ke ruangan saya untuk bimbingan KRS.</p>
                                <p>Jangan lupa untuk membawa dokumen yang diperlukan.</p>
                            </div>
                        </div>
                        <div class="message-card student">
                            <div class="message-header">
                                <span class="name student"><i class="fas fa-user-circle"></i> Desi Maya Sari</span>
                                <div>
                                    <small class="text-muted"><i class="far fa-clock"></i> 17:20, 26 September 2024</small>
                                </div>
                            </div>
                            <div class="message-body">
                                <p>Baik Pak, Terima kasih atas informasinya.</p>
                            </div>
                        </div>
                    </div>
                    <div class="reply-form" id="replyForm">
                        <h4><i class="fas fa-reply"></i> Balas Pesan</h4>
                        <form>
                            <div class="mb-3">
                                <textarea class="form-control" rows="4" placeholder="Tulis pesan Anda di sini..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Akhiri Pesan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin mengakhiri pesan ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger" id="confirmEndChat">Ya, Akhiri Pesan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-5">
        <div class="container text-center">
            <p class="mb-0">
                Dikembangkan oleh Mahasiswa Prodi Teknik Informatika UNRI 
                (<span style="color: #28a745;">Desi, Murni dan Syahirah</span>)
            </p>
        </div>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const endChatBtn = document.getElementById('endChatBtn');
            const confirmEndChatBtn = document.getElementById('confirmEndChat');
            const replyForm = document.getElementById('replyForm');
            const statusRow = document.getElementById('statusRow');
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            
            endChatBtn.addEventListener('click', function() {
                modal.show();
            });

            confirmEndChatBtn.addEventListener('click', function() {
                // Sembunyikan form balas pesan
                replyForm.style.display = 'none';
                
                // Ubah teks tombol "Akhiri Pesan" menjadi "Pesan Diakhiri"
                endChatBtn.innerHTML = '<i class="fas fa-check-circle"></i> Pesan Diakhiri';
                endChatBtn.classList.remove('btn-danger');
                endChatBtn.classList.add('btn-secondary');
                endChatBtn.disabled = true;

                // Tampilkan status pesan diakhiri dalam tabel
                statusRow.style.display = 'table-row';

                // Tutup modal
                modal.hide();
            });
        });
    </script>
</body>
</html>