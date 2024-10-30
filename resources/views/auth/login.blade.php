<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Informasi Bimbingan dan Perpesanan Teknik Elektro UNRI">
    <meta name="author" content="SITEI JTE UNRI">
    <title>APLIKASI BIMBINGAN DAN PERPESANAN</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Viga&display=swap" rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle at top left, #f1faee, #ffffff);
            min-height: 100vh;
            font-family: 'Open Sans', sans-serif;
            display: flex;
            align-items: center;
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
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
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

        .form-control:focus {
            border-color: #00923F;
            box-shadow: 0 0 0 0.25rem rgba(0, 146, 63, 0.25);
        }

        .invalid-feedback {
            display: block;
            font-size: 80%;
        }

        .alert {
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .password-toggle-btn {
            background: none;
            border: none;
            padding: 0;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            cursor: pointer;
        }

        .password-toggle-btn:focus {
            outline: none;
            box-shadow: none;
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

        /* Animation for error messages */
        .alert-danger {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
</head>

<body>
    <div class="container login-container py-5">
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
                                            <img src="{{ asset('images/1.png') }}" class="d-block" alt="Slide 1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('images/2.png') }}" class="d-block" alt="Slide 2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('images/3.png') }}" class="d-block" alt="Slide 3">
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

                        <!-- Login Form -->
                        <div class="col-lg-4">
                            <div class="card-body p-4">
                                <form class="needs-validation" action="/login" method="POST" novalidate>
                                    @csrf
                                    
                                    <!-- Logo and Title -->
                                    <div class="d-flex justify-content-center align-items-center mb-4">
                                        <div class="p-3">
                                            <img src="{{ asset('images/logounri.png') }}" alt="logo_unri" width="60" height="60" class="img-fluid">
                                        </div>
                                        <div class="vl"></div>
                                        <div class="ps-2">
                                            <h5 class="fs-5 mb-0 fw-bold">Sistem Informasi<br>Teknik Elektro &<br>Informatika</h5>
                                        </div>
                                    </div>

                                    <!-- Error Messages -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger py-2">
                                            <small><i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}</small>
                                        </div>
                                    @endif

                                    @if (session('status'))
                                        <div class="alert alert-success py-2">
                                            <small><i class="fas fa-check-circle me-2"></i>{{ session('status') }}</small>
                                        </div>
                                    @endif

                                    <!-- Username Field -->
                                    <div class="form-floating mb-3">
                                        <input 
                                            type="text" 
                                            class="form-control form-control-lg @error('username') is-invalid @enderror" 
                                            name="username" 
                                            id="username" 
                                            placeholder="NIP/NIM"
                                            value="{{ old('username') }}" 
                                            required 
                                            autocomplete="username"
                                            autofocus
                                        >
                                        <label for="username">NIP/NIM <span class="text-danger">*</span></label>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password Field -->
                                    <div class="form-floating mb-3 position-relative">
                                        <input 
                                            type="password" 
                                            class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                            name="password" 
                                            id="password" 
                                            placeholder="Password"
                                            required
                                        >
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <button type="button" class="password-toggle-btn" id="togglePassword">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-success w-100 py-2 fs-6">
                                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                    </button>

                                    <!-- Help Text -->
                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            Belum Punya Akun atau Lupa Password?<br>
                                            <span class="fw-semibold">(Hubungi Admin Prodi)</span>
                                        </small>
                                    </div>

                                    <hr class="border-1 my-4" style="border-top: 1px dashed #000000;">

                                    <!-- Footer -->
                                    <div class="text-center">
                                        <small class="text-muted d-block">Dikembangkan oleh:</small>
                                        <a href="/developer" class="text-decoration-underline text-dark fs-8 fw-semibold">
                                            DESI, MURNI, SYAHIRAH
                                        </a>
                                        <div class="mt-2">
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
        // Password Toggle
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordInput = document.getElementById("password");
            const icon = this.querySelector('i');
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        });

        // Form Validation
        (function() {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>