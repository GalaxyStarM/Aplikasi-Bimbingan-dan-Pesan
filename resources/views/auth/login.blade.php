<!DOCTYPE html>
<html lang="en">
<!-- [Previous head section remains the same until style] -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="SITEI JTE UNRI">
    <title>APLIKASI BIMBINGAN DAN PERPESANAN</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: radial-gradient(circle at top left, #f1faee, #ffffff);
            min-height: 100vh;
        }

        .btn-success {
            background-color: #00923F !important;
            border-color: #00923F !important;
        }

        .btn-success:hover {
            background-color: #007F36 !important;
            border-color: #007F36 !important;
        }

        .vl {
            border-left: 2px solid green;
            height: 65px;
            margin-top: 5px;
            padding-left: 10px;
        }

        .login-container {
            max-width: 1200px;
        }

        .main-card {
            height: auto;
        }

        .carousel-container {
            height: 100%;
            background-color: #f8f9fa;
        }

        .carousel,
        .carousel-inner,
        .carousel-item {
            height: 100%;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background-color: #f8f9fa;
        }

        @media (max-width: 992px) {
            .main-card {
                height: auto;
            }

            .carousel-container {
                height: 400px;
            }
        }

        @media (max-width: 768px) {
            .carousel-container {
                height: 300px;
            }
        }
    </style>
</head>

<body class="d-flex align-items-center py-4">
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-lg border-0 main-card">
                    <div class="row g-0">
                        <!-- Slideshow -->
                        <div class="col-lg-8 px-3">
                            <div class="carousel-container">
                                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{ asset('images/1.png') }}" class="d-block" alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('images/2.png') }}" class="d-block" alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('images/3.png') }}" class="d-block" alt="">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card-body p-4">
                                <!-- [Previous form content remains exactly the same] -->
                                <form class="needs-validation" action="{{ route('login') }}" method="POST" novalidate>
                                    @csrf
                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                        <div class="p-3">
                                            <img src="{{ asset('images/logounri.png') }}" alt="logo_unri" width="60" height="60" class="img-fluid">
                                        </div>
                                        <div class="vl"></div>
                                        <div class="ps-2">
                                            <h5 class="fs-5 mb-0 fw">Sistem Informasi<br>Teknik Elektro &<br>Informatika</h5>
                                        </div>
                                    </div>

                                    <div class="alert alert-danger p-2 d-none" id="error-alert">
                                        <small>{{ session('error') ?? 'Login gagal!' }}</small>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="NIP/NIM" required>
                                        <label for="username">NIP/NIM <span class="text-danger">*</span></label>
                                    </div>

                                    <div class="form-floating mb-3 position-relative">
                                        <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Password" required>
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y border-0" id="togglePassword">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                    </div>

                                    <button class="btn btn-success w-100 py-2 fs-6" onclick="window.location.href='/dashboard'">Masuk</button>

                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            Belum Punya Akun atau Lupa Password?<br>(Hubungi Admin Prodi)
                                        </small>
                                    </div>

                                    <hr class="border-1 my-1" style="border-top: 1px dashed #000000;">


                                    <div class="text-center">
                                        <small class="text-muted d-block">Dikembangkan oleh:</small>
                                        <a href="/developer" class="text-decoration-underline text-dark fs-8 fw-semibold">
                                            DESI, MURNI, SYAHIRAH
                                        </a>
                                        <div class="my-2">
                                            <small class="text-muted">2024 © SITEI JTE UNRI</small>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            var passwordInput = document.getElementById("password");
            var type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.querySelector('i').classList.toggle("fa-eye");
            this.querySelector('i').classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>