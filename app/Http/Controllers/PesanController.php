<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesan;
use App\Services\FirebaseService;

class PesanController extends Controller
{
    protected $notificationService;

    public function __construct(ConsultationNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function store(Request $request)
    {
        $pesan = Pesan::create([
            'mahasiswa_nim' => auth()->user()->nim,
            'dosen_nip' => $request->dosen_nip,
            'subjek' => $request->subjek,
            'pesan' => $request->pesan,
            'prioritas' => $request->prioritas,
            'attachment' => $request->attachment,
            'status' => 'aktif'
        ]);
        
        $this->notificationService->sendNewConsultationNotification($pesan);
        
        return redirect()->route('pesan.show', $pesan->id)
            ->with('success', 'Pesan berhasil dikirim');
    }

    public function reply(Request $request, Pesan $pesan)
    {
        $balasan = PesanBalasan::create([
            'pesan_id' => $pesan->id,
            'role_id' => auth()->user()->role_id,
            'pengirim_id' => auth()->user()->getKey(), // nim atau nip
            'pesan' => $request->pesan,
            'attachment' => $request->attachment,
            'is_read' => false
        ]);
        
        // Update last reply info
        $pesan->update([
            'last_reply_by' => auth()->user()->getKey(),
            'last_reply_at' => now()
        ]);
        
        $this->notificationService->sendReplyNotification($balasan);
        
        return response()->json($balasan->load('pengirim', 'role'));
    }
}
