<div class="bg-gradient-bar" style="height: 3px; background: linear-gradient(to right, #4ade80, #3b82f6, #8b5cf6);"></div>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top" style="box-shadow: 0px 0px 10px 1px #afafaf">
    <div class="container">
        <a class="navbar-brand me-4" href="{{ url('/') }}" style="font-family: 'Viga', sans-serif; font-weight: 600; font-size: 25px;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/LOGO-UNRI.png" alt="SITEI Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
            SITEI
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') || 
                                            Request::is('/pilihjadwal') || 
                                            Request::is('/detaildaftar') || 
                                            Request::is('/riwayatmahasiswa') ? 'active' : '' }}" style="font-weight: bold;" href="{{ url('/') }}">BIMBINGAN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboardpesan') ? 'active' : '' }}" style="font-weight: bold;" href="{{ url('/dashboardpesan') }}">PESAN</a>
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
                        <li><a class="dropdown-item" href="{{ url('/login') }}">Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>