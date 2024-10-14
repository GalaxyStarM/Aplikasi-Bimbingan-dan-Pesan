<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="SITEI JTE UNRI">
    <meta name="generator" content="Hugo 0.98.0">
    <title>APLIKASI BIMBINGAN DAN PERPESANAN</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/signin.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


    <style>
        body {
            background: radial-gradient(circle at top left, #f1faee, #ffffff);
        }

        .green-background {
            background-color: #28a745;
            height: 100vh;
            flex-direction: column;
            justify-content: center;
            display: flex;
        }

        .btn-success {
            background-color: #00923F !important;
            border-color: #00923F !important;
        }

        .btn-success:hover {
            background-color: #007F36 !important;
            border-color: #007F36 !important;
        }

        .carousel-inner img {
            width: 100%;
            height: auto;
        }

        .pengembang {
            color: #212529;
            text-decoration: none;
        }

        .pengembang:hover {
            color: #28a745;
        }

        @media only screen and (max-width: 425px) {
            .green-background {
                display: none !important;
            }

            .row {
                margin-top: -60px;
            }

            .bungkus {
                justify-content: center;
                align-items: center;
            }

            .vl {
                border-left: 2px solid green;
                height: 100px;
                margin-top: 20px;
                padding-left: 10px;
            }

            .caption h4 {
                font-size: 18px;
            }

            .gambar img {
                margin-top: -30px;
            }

            .container {
                margin-top: 100px;
            }

            .footer {
                margin-bottom: 20px;
            }

            .pengembang {
                color: #212529;
            }

            .pengembang:hover {
                color: #28a745;
            }
        }

        @media only screen and (max-width: 768px) {
            .green-background {
                display: none !important;
            }

            .gambar img {
                margin-top: 5px;
            }

            .bungkus {
                justify-content: center;
                align-items: center;
            }

            .vl {
                border-left: 2px solid green;
                height: 70px;
                margin-top: 20px;
                padding-left: 10px;
            }

            .pengembang {
                color: #212529;
            }

            .pengembang:hover {
                color: #28a745;
            }
        }

        @media only screen and (max-width: 992px) {
            .green-background {
                display: none !important;
            }

            .bungkus {
                justify-content: center;
                align-items: center;
            }

            .vl {
                border-left: 2px solid green;
                height: 70px;
                margin-top: 20px;
                padding-left: 10px;
            }

            .pengembang {
                color: #212529;
            }

            .pengembang:hover {
                color: #28a745;
            }
        }

        @media only screen and (min-width: 1024px) {
            .green-background {
                background-color: #28a745;
                height: 100vh;
                flex-direction: column;
                justify-content: center;
                display: flex;
            }

            .vl {
                border-left: 2px solid green;
                height: 70px;
                margin-top: 20px;
                padding-left: 10px;
            }

            .caption h4 {
                font-size: 20px;
            }

            .footer {
                margin-bottom: 20px;
            }

            .pengembang {
                color: #212529;
            }

            .pengembang:hover {
                color: #28a745;
            }

            .kotak-masuk {
                border-radius: 10px;
            }

        }

        .dashed-line {
            border: none;
            border-top: 1px dashed #000000;
            margin: 10px 0;
        }

        .container {

            max-width: 1200px;
            margin: 0 auto;
        }

        .row {
            margin: 0 auto;
        }

        .carousel,
        .carousel-inner,
        .carousel-item,
        .carousel-item img {
            max-height: 98vh;
            object-fit: cover;
        }

        .btn-login {
            font-size: 16px;
        }

        .position-absolute.end-0.top-50.translate-middle-y {
            top: 50%;
            transform: translateY(-50%);
            right: 10px;
            cursor: pointer;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .custom-input {
                max-width: 100%;
                height: 45px;
            }
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center " style="min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center align-items-center rounded col-md-12 bg-white shadow-lg">
                <!-- Slideshow -->
                <div class="col-xl-8 col-lg-8 col-md-12 ">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/slidejte.jpg') }}" class="d-block" alt="">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/slidejte.jpg') }}" class="d-block" alt="">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/slidejte.jpg') }}" class="d-block" alt="">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Login Form -->
                <div class="col-xl-4 col-lg-5 rounded bg-white">
                    <div class="px-4">
                        <main class="w-100">
                            <form class="form-login" action="{{ route('login') }}" method="POST">
                                @csrf
                                <input type="hidden" name="_token" value="">
                                <div class="d-flex bungkus justify-content-center">
                                    <div class="gambar p-3 mt-3">
                                        <img src="{{ asset('images/logounri.png') }}" alt="logo_unri" width="60"
                                            height="60">
                                    </div>
                                    <div class="vl mt-4 p-2"></div>
                                    <div class="mt-4 caption">
                                        <h4 class="text-left">Sistem Informasi<br>Teknik Elektro &<br>Informatika</h4>
                                    </div>
                                </div>
                                <div
                                    class="text-center alert alert-danger p-1 @if (session('error')) d-block @else d-none @endif">
                                    <span class="text-danger">{{ session('error') ?? 'Login gagal!' }}</span>
                                </div>

                                <div class="form-floating mt-5">
                                    <input type="text" class="form-control rounded-1 custom-input" name="username"
                                        id="username" placeholder="NIP/NIM" autofocus required>
                                    <label for="username">NIP/NIM <span class="text-danger">*</span></label>
                                </div>

                                <div class="form-floating mt-3 position-relative">
                                    <input type="password" class="form-control rounded-1 custom-input" name="password"
                                        id="password" placeholder="Password" required>
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <div class="position-absolute end-0 top-50 translate-middle-y">
                                        <span class="px-3">
                                            <i class="fas fa-eye-slash pointer" id="togglePassword"></i>
                                        </span>
                                    </div>
                                </div>
                                <button class="w-100 btn btn-lg btn-success btn-login mt-4 rounded-1"
                                    type="submit">Masuk</button>
                            </form>
                            <small class="d-block text-center mt-3" style="font-size: 13px ">
                                Belum Punya Akun atau Lupa Password? <br> (Hubungi Admin Prodi)
                            </small>
                            <hr class="dashed-line">
                            <div class="footer text-center mt-1" style="font-size: 13px ">
                                <small>Dikembangkan oleh:</small>
                                <br>
                                <a class="pengembang" href="/developer" target="_blank"
                                    style="text-decoration: underline;">
                                    <b>DESI, MURNI, SYAHIRAH</b>
                                </a>
                                <div class="mt-2">
                                    <small class="text-center" style="color: #98A2B3;">2024 © SITEI JTE UNRI</small>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and custom scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            var passwordInput = document.getElementById("password");
            var type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>

</html>
