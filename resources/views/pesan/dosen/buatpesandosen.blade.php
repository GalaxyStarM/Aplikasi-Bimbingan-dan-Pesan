<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesan Baru - Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

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
        .select2-container {
            width: 100% !important;
        }
        .batch-selection {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .batch-selection h5 {
            margin-bottom: 1rem;
            color: #495057;
        }
        .recipients-preview {
            margin-top: 1rem;
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            max-height: 150px;
            overflow-y: auto;
        }
        .select2-container--default .select2-selection--multiple {
            border-color: #ced4da !important;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 12px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 2rem;
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

    <!-- Navbar sama seperti sebelumnya -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand me-4" href="/dashboard">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="SITEI Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
                SITEI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
                        <button class="btn text-dark dropdown-toggle fw-bold" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                            AKUN
                        </button>
                        <ul class="dropdown-menu">
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
        <hr>
        <button class="btn btn-gradient mb-4 mt-2">
            <a href="/dashboardpesan" class="d-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </button>

        <form id="messageForm">
            <div class="mb-3">
                <label for="subject" class="form-label fw-bold">Subjek<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="subject" placeholder="Isi subjek" required>
            </div>

            <!-- Bagian Pemilihan Penerima -->
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Penerima<span class="text-danger">*</span></label>
                
                <!-- Tab untuk memilih mode pengiriman -->
                <ul class="nav nav-tabs mb-3" id="recipientTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="individual-tab" data-bs-toggle="tab" data-bs-target="#individual" type="button" role="tab">Mahasiswa Individual</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="batch-tab" data-bs-toggle="tab" data-bs-target="#batch" type="button" role="tab">Berdasarkan Angkatan</button>
                    </li>
                </ul>

                <!-- Konten Tab -->
                <div class="tab-content" id="recipientTabsContent">
                    <!-- Tab Mahasiswa Individual -->
                    <div class="tab-pane fade show active" id="individual" role="tabpanel">
                        <select class="form-control" id="individualStudents" multiple="multiple">
                            <!-- Options akan diisi melalui JavaScript -->
                        </select>
                    </div>

                    <!-- Tab Berdasarkan Angkatan -->
                    <div class="tab-pane fade" id="batch" role="tabpanel">
                        <div class="batch-selection">
                            <h5 class="mb-3">Pilih Angkatan:</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input batch-checkbox" type="checkbox" value="2021" id="batch2021">
                                        <label class="form-check-label" for="batch2021">
                                            Angkatan 2021
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input batch-checkbox" type="checkbox" value="2022" id="batch2022">
                                        <label class="form-check-label" for="batch2022">
                                            Angkatan 2022
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input batch-checkbox" type="checkbox" value="2023" id="batch2023">
                                        <label class="form-check-label" for="batch2023">
                                            Angkatan 2023
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input batch-checkbox" type="checkbox" value="2024" id="batch2024">
                                        <label class="form-check-label" for="batch2024">
                                            Angkatan 2024
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="recipients-preview" id="batchPreview">
                            <p class="text-muted mb-0">Mahasiswa yang dipilih akan muncul di sini...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label fw-bold">Prioritas<span class="text-danger">*</span></label>
                <select class="form-select" id="priority" required>
                    <option value="" selected disabled>Pilih Prioritas</option>
                    <option value="high">Mendesak</option>
                    <option value="medium">Umum</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="attachment" class="form-label fw-bold">Lampiran (Opsional)</label>
                <input type="text" class="form-control" id="attachment" placeholder="Isi lampiran berupa link Google Drive">
            </div>

            <div class="mb-3">
                <label for="message" class="form-label fw-bold">Pesan<span class="text-danger">*</span></label>
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
                (<span class="text-success">Desi, Murni, dan Syahirah</span>)
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Data mahasiswa (contoh)
            const studentsData = {
                '2021': [
                    { id: '1', name: ' Syahirah Tri Meilina - 2021', nim: ' 2107110255' },
                    { id: '2', name: 'Cut Muthia Ramadhani  - 2021', nim: '2107110257' },
                    { id: '3', name: 'Syazliana Nuro - 2021', nim: '2107110256' },
                    { id: '4', name: 'Desi Maya Sari - 2021', nim: '2107110665' },
                    { id: '5', name: 'Tri Murniati - 2021', nim: '2107112735' },
                    { id: '6', name: 'Sherly Ratna Musva - 2021', nim: '2107110670' }
                ],
                '2022': [
                    { id: '7', name: 'Reza Ramadhani Putra - 2022', nim: '2207111389' },
                    { id: '8', name: 'Edi Putra Yuni - 2022', nim: '2207111395' },
                    { id: '9', name: 'Fatimah Azzahra - 2022', nim: '2207125072' },
                    { id: '10', name: 'Dinda Wulandari  - 2022', nim: ' 2207125080' }
                ],
                '2023': [
                    { id: '11', name: 'Indah Permata - 2023', nim: '23000111' },
                    { id: '12', name: 'Joko Widodo - 2023', nim: '23000112' },
                    { id: '13', name: 'Kartika Sari - 2023', nim: '23000113' },
                    { id: '14', name: 'Reza Puta - 2023', nim: '23000114' }
                ],
                '2024': [
                    { id: '15', name: 'Maya Angelina - 2024', nim: '24000111' },
                    { id: '16', name: 'Naufal Ahmad - 2024', nim: '24000112' },
                    { id: '17', name: 'Olivia Putri - 2024', nim: '24000113' },
                    { id: '18', name: 'Pandu Wijaya - 2024', nim: '24000114' }
                ]
            };

            // Inisialisasi Select2 untuk pemilihan mahasiswa individual
            $('#individualStudents').select2({
                placeholder: 'Ketik nama atau NIM mahasiswa',
                allowClear: true,
                data: Object.values(studentsData).flat().map(student => ({
                    id: student.id,
                    text: `${student.name} (${student.nim})`
                })),
                matcher: function(params, data) {
                    // Jika tidak ada pencarian, tampilkan semua opsi
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Jika ada pencarian, lakukan pencocokan
                    if (typeof data.text === 'undefined') {
                        return null;
                    }

                    // Ubah ke lowercase untuk pencarian yang tidak case sensitive
                    const searchTerm = params.term.toLowerCase();
                    const text = data.text.toLowerCase();

                    // Cek apakah teks mengandung kata pencarian
                    if (text.indexOf(searchTerm) > -1) {
                        return data;
                    }

                    return null;
                }
            });

            // Fungsi untuk memperbarui preview mahasiswa berdasarkan angkatan
            function updateBatchPreview() {
                const selectedBatches = [];
                $('.batch-checkbox:checked').each(function() {
                    selectedBatches.push($(this).val());
                });

                const previewElement = $('#batchPreview');
                if (selectedBatches.length === 0) {
                    previewElement.html('<p class="text-muted mb-0">Mahasiswa yang dipilih akan muncul di sini...</p>');
                    return;
                }

                let previewHtml = '<div class="selected-students">';
                let totalStudents = 0;

                selectedBatches.forEach(batch => {
                    const students = studentsData[batch];
                    totalStudents += students.length;
                    previewHtml += `<h6 class="mt-2">Angkatan ${batch}:</h6><ul class="list-unstyled ms-3">`;
                    students.forEach(student => {
                        previewHtml += `<li>${student.name} (${student.nim})</li>`;
                    });
                    previewHtml += '</ul>';
                });

                previewHtml += `<p class="mt-3 fw-bold">Total: ${totalStudents} mahasiswa</p></div>`;
                previewElement.html(previewHtml);
            }

            // Event listener untuk checkbox angkatan
            $('.batch-checkbox').change(function() {
                updateBatchPreview();
            });

            // Event listener untuk pengiriman form
            $('#messageForm').submit(function(e) {
                e.preventDefault();

                // Mengumpulkan data penerima
                let recipients = [];
                const activeTab = $('#recipientTabs .nav-link.active').attr('id');

                if (activeTab === 'individual-tab') {
                    recipients = $('#individualStudents').select2('data').map(item => ({
                        id: item.id,
                        name: item.text
                    }));
                } else {
                    $('.batch-checkbox:checked').each(function() {
                        const batch = $(this).val();
                        recipients = recipients.concat(studentsData[batch]);
                    });
                }

                // Validasi penerima
                if (recipients.length === 0) {
                    alert('Silakan pilih minimal satu penerima pesan');
                    return;
                }

                // Mengumpulkan data form
                const formData = {
                    subject: $('#subject').val(),
                    recipients: recipients,
                    priority: $('#priority').val(),
                    attachment: $('#attachment').val(),
                    message: $('#message').val()
                };

                // Log data form (untuk keperluan development)
                console.log('Form Data:', formData);

                // Di sini Anda bisa menambahkan kode untuk mengirim data ke server
                alert('Pesan berhasil dikirim ke ' + recipients.length + ' mahasiswa');
                
                // Reset form
                this.reset();
                $('#individualStudents').val(null).trigger('change');
                $('.batch-checkbox').prop('checked', false);
                updateBatchPreview();
            });

            // Mengatur warna teks untuk select priority
            const prioritySelect = document.getElementById('priority');
            prioritySelect.addEventListener('change', function() {
                this.style.color = this.value === "" ? "#6c757d" : "black";
            });

            // Mengatur warna awal
            if (prioritySelect.value === "") {
                prioritySelect.style.color = "#6c757d";
            }
        });
    </script>
</body>
</html>