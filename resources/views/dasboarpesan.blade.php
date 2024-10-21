@extends('layouts.layout')

@section('content')
    <div class="container mt-4" style="margin-top: 60px;"> <!-- Tambahkan margin di sini -->
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs d-flex"> <!-- Menggunakan flex untuk penyelarasan -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">High (0)</a>
                    </li>
                    <li class="nav-divider"></li> <!-- Garis vertikal -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">Medium (0)</a>
                    </li>
                    <li class="nav-divider"></li> <!-- Garis vertikal -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">Low (0)</a>
                    </li>
                    <li class="nav-divider"></li> <!-- Garis vertikal -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">Semua (0)</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <p class="no-message">Tidak Ada Pesan</p> <!-- Menggunakan kelas no-message di sini -->

    </div>

    <!-- Modal Buat Pesan -->
    <div class="modal fade" id="buatPesanModal" tabindex="-1" role="dialog" aria-labelledby="buatPesanModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="buatPesanModalLabel">Buat Pesan Baru</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="judulPesan">Judul</label>
                <input type="text" class="form-control" id="judulPesan" placeholder="Masukkan Judul">
              </div>
              <div class="form-group">
                <label for="isiPesan">Pesan</label>
                <textarea class="form-control" id="isiPesan" rows="3" placeholder="Masukkan Pesan"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary">Kirim Pesan</button>
          </div>
        </div>
      </div>
    </div>

    <style>
        .nav-tabs {
            padding-left: 0; /* Menghilangkan padding default */
        }

        .nav-divider {
            border-left: 2px solid #dee2e6; /* Menambahkan garis vertikal yang lebih tebal */
            height: 20px; /* Tinggi garis vertikal */
            margin: 0 10px; /* Margin kiri dan kanan */
            align-self: center; /* Menyelaraskan garis secara vertikal */
        }
    </style>
@endsection
