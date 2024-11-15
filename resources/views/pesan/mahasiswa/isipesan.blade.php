@extends('layouts.app')

@section('title', 'Isi Pesan')

@push('styles')
    <style>
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
            border: 4px solid #007bff;
        }
        .student-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .student-name {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 5px;
            color: #007bff;
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
@endpush

@section('content')
<div class="container mt-5">
    <h1 class="mb-2 gradient-text fw-bold">Isi Konsultasi</h1>
    <hr>
    <button class="btn btn-gradient mb-4 mt-2 d-flex align-items-center justify-content-center">
        <a href="{{ route('pesan.dashboardkonsultasi') }}">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </button>
    
    <div class="row">
        <!-- Kolom Informasi -->
        <div class="col-md-4">
            <div class="student-card">
                @if($pesan->dosen->foto)
                    <img src="{{ asset('storage/' . $pesan->dosen->foto) }}" alt="Foto {{ $pesan->dosen->nama }}" class="student-photo mx-auto d-block">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="student-photo mx-auto d-block">
                @endif
                
                <div class="student-info">
                    <h3 class="student-name">{{ $pesan->dosen->nama }}</h3>
                    <p class="student-id">NIP. {{ $pesan->dosen->nip }}</p>
                    <p><i class="fas fa-chalkboard-teacher"></i> Dosen {{ $pesan->dosen->prodi }}</p>
                </div>

                <table class="info-table">
                    <tr>
                        <th>Subjek</th>
                        <td>{{ $pesan->subjek }}</td>
                    </tr>
                    <tr>
                        <th>Penerima</th>
                        <td>{{ $pesan->dosen->nama }}</td>
                    </tr>
                    <tr>
                    <th>Prioritas</th>
                        <td>
                            <span class="priority-badge {{ $pesan->prioritas == 'mendesak' ? 'priority-high' : 'priority-normal' }}">
                                {{ ucfirst($pesan->prioritas) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Dikirim</th>
                        <td>{{ $pesan->created_at->format('H:i, d F Y') }}</td>
                    </tr>
                    <tr id="statusRow" style="{{ $pesan->status === 'selesai' ? '' : 'display: none;' }}">
                        <th>Status</th>
                        <td class="status-ended">Pesan telah berakhir</td>
                    </tr>
                </table>

                @if($pesan->status === 'aktif')
                    <button class="btn btn-danger btn-action" id="endChatBtn" 
                            data-pesan-id="{{ $pesan->id }}">
                        <i class="fas fa-times-circle"></i> Akhiri Pesan
                    </button>
                @else
                    <button class="btn btn-secondary btn-action" disabled>
                        <i class="fas fa-check-circle"></i> Pesan Diakhiri
                    </button>
                @endif
            </div>
        </div>

        <!-- Kolom Chat -->
        <div class="col-md-8">
            <div class="chat-wrapper">
                <div class="chat-container">
                    <!-- Pesan Utama -->
                    <div class="message-card {{ $pesan->mahasiswa_nim == auth()->id() ? 'student' : 'teacher' }}">
                        <div class="message-header">
                            <span class="name {{ $pesan->mahasiswa_nim == auth()->id() ? 'student' : 'teacher' }}">
                                <i class="fas {{ $pesan->mahasiswa_nim == auth()->id() ? 'fa-user-circle' : 'fa-user-tie' }}"></i>
                                {{ $pesan->mahasiswa->nama }}
                            </span>
                            <div>
                                <small class="text-muted">
                                    <i class="far fa-clock"></i> {{ $pesan->created_at->format('H:i, d F Y') }}
                                </small>
                            </div>
                        </div>
                        <div class="message-body">
                            {!! nl2br(e($pesan->pesan)) !!}
                        </div>
                        @if($pesan->attachment)
                            <div class="attachment">
                                <p><i class="fas fa-paperclip"></i> Lampiran:</p>
                                <a href="{{ route('pesan.attachment', $pesan->id) }}" target="_blank">
                                    <i class="fas fa-file-pdf"></i> {{ basename($pesan->attachment) }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Balasan Pesan -->
                    @foreach($pesan->balasan as $balasan)
                        <div class="message-card {{ $balasan->role->role_akses == 'mahasiswa' ? 'student' : 'teacher' }}">
                            <div class="message-header">
                                <span class="name {{ $balasan->role->role_akses == 'mahasiswa' ? 'student' : 'teacher' }}">
                                    <i class="fas {{ $balasan->role->role_akses == 'mahasiswa' ? 'fa-user-circle' : 'fa-user-tie' }}"></i>
                                    {{ $balasan->pengirim->nama }}
                                </span>
                                <div>
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i> {{ $balasan->created_at->format('H:i, d F Y') }}
                                    </small>
                                </div>
                            </div>
                            <div class="message-body">
                                {!! nl2br(e($balasan->pesan)) !!}
                            </div>
                            @if($balasan->attachment)
                                <div class="attachment">
                                    <p><i class="fas fa-paperclip"></i> Lampiran:</p>
                                    <a href="{{ route('pesan.attachment', $balasan->id) }}" target="_blank">
                                        <i class="fas fa-file-pdf"></i> {{ basename($balasan->attachment) }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Form Balas Pesan -->
                @if($pesan->status === 'aktif')
                    <div class="reply-form" id="replyForm">
                        <h4><i class="fas fa-reply"></i> Balas Pesan</h4>
                        <form action="{{ route('pesan.reply', $pesan->id) }}" method="POST" id="replyMessageForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control @error('pesan') is-invalid @enderror" 
                                    name="pesan" 
                                    rows="4" 
                                    placeholder="Tulis pesan Anda di sini..." 
                                    required>{{ old('pesan') }}</textarea>
                                @error('pesan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="attachment" class="form-label">
                                    <i class="fas fa-paperclip"></i> Lampiran (Optional)
                                </label>
                                <input type="file" 
                                    class="form-control @error('attachment') is-invalid @enderror" 
                                    name="attachment" 
                                    accept=".pdf,.doc,.docx">
                                @error('attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-gradient">
                                <i class="fas fa-paper-plane"></i> Kirim Pesan
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Akhiri Pesan</h5>
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
@endsection

@push('scripts')
<script>
// Script JavaScript tetap sama persis seperti yang Anda berikan
document.addEventListener('DOMContentLoaded', function() {
    const endChatBtn = document.getElementById('endChatBtn');
    const confirmEndChatBtn = document.getElementById('confirmEndChat');
    const replyForm = document.getElementById('replyForm');
    const statusRow = document.getElementById('statusRow');
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    
    if(document.getElementById('replyMessageForm')) {
        document.getElementById('replyMessageForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const pesanId = '{{ $pesan->id }}';
            
            try {
                const response = await fetch(`/pesan/reply/${pesanId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                
                if(data.success) {
                    window.location.reload();
                } else {
                    alert('Gagal mengirim pesan: ' + data.message);
                }
            } catch(error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim pesan');
            }
        });
    }

    // Handle End Chat
    if(endChatBtn) {
        endChatBtn.addEventListener('click', function() {
            modal.show();
        });

        confirmEndChatBtn.addEventListener('click', async function() {
            const pesanId = endChatBtn.dataset.pesanId;
            
            try {
                const response = await fetch(`/pesan/end/${pesanId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                
                if(data.success) {
                    // Sembunyikan form balas pesan
                    if(replyForm) replyForm.style.display = 'none';
                    
                    // Ubah tombol
                    endChatBtn.innerHTML = '<i class="fas fa-check-circle"></i> Pesan Diakhiri';
                    endChatBtn.classList.remove('btn-danger');
                    endChatBtn.classList.add('btn-secondary');
                    endChatBtn.disabled = true;

                    // Tampilkan status
                    statusRow.style.display = 'table-row';

                    modal.hide();
                } else {
                    alert('Gagal mengakhiri pesan: ' + data.message);
                }
            } catch(error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengakhiri pesan');
            }
        });
    }

    if(replyForm) {
            replyForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Disable submit button
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                
                try {
                    const formData = new FormData(this);
                    
                    const response = await fetch(this.getAttribute('action'), {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if(result.success) {
                        // Reset form
                        this.reset();
                        // Refresh halaman untuk menampilkan pesan baru
                        window.location.reload();
                    } else {
                        alert('Gagal mengirim pesan: ' + result.message);
                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Pesan';
                    }
                } catch(error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim pesan');
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Pesan';
                }
            });
        }
});
</script>
@endpush