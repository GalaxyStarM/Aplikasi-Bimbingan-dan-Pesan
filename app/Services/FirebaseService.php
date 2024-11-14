<?php

namespace App\Services;

use App\Models\Pesan;
use App\Models\PesanBalasan;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $this->messaging = Firebase::messaging();
    }

    /**
     * Kirim notifikasi untuk pesan konsultasi baru
     */
    public function sendNewConsultationNotification(Pesan $pesan)
    {
        // Menggunakan relasi yang sudah didefinisikan
        $dosen = $pesan->dosen;
        $mahasiswa = $pesan->mahasiswa;
        
        if ($dosen && $dosen->fcm_token) {
            $notification = Notification::create()
                ->withTitle('Konsultasi Baru')
                ->withBody("Pesan baru dari {$mahasiswa->nama}: {$pesan->subjek}")
                ->withData([
                    'type' => 'new_consultation',
                    'pesan_id' => $pesan->id,
                    'prioritas' => $pesan->prioritas,
                    'status' => $pesan->status,
                    'mahasiswa' => [
                        'nim' => $mahasiswa->nim,
                        'nama' => $mahasiswa->nama,
                        'prodi' => $mahasiswa->prodi->nama ?? null
                    ],
                    'subjek' => $pesan->subjek,
                    'attachment' => $pesan->attachment,
                    'created_at' => $pesan->created_at->format('H:i, d F Y'),
                    'click_action' => 'OPEN_CONSULTATION_DETAIL'
                ]);

            return $this->sendNotification($dosen->fcm_token, $notification);
        }
        
        Log::info('Notification not sent: Dosen has no FCM token', [
            'dosen_nip' => $pesan->dosen_nip,
            'pesan_id' => $pesan->id
        ]);
        
        return false;
    }

    /**
     * Kirim notifikasi untuk balasan pesan
     */
    public function sendReplyNotification(PesanBalasan $balasan)
    {
        $pesan = $balasan->pesan;
        $sender = $balasan->pengirim(); // Menggunakan method yang sudah ada
        
        // Tentukan penerima berdasarkan role pengirim
        $recipient = ($balasan->role->role_akses === 'mahasiswa') 
            ? $pesan->dosen 
            : $pesan->mahasiswa;

        if ($recipient && $recipient->fcm_token) {
            $messagePreview = substr(strip_tags($balasan->pesan), 0, 100);
            if (strlen($balasan->pesan) > 100) {
                $messagePreview .= '...';
            }

            $notification = Notification::create()
                ->withTitle("Balasan untuk: {$pesan->subjek}")
                ->withBody("{$sender->nama}: {$messagePreview}")
                ->withData([
                    'type' => 'consultation_reply',
                    'pesan_id' => $pesan->id,
                    'balasan_id' => $balasan->id,
                    'sender' => [
                        'id' => $sender->getKey(),
                        'nama' => $sender->nama,
                        'role' => $balasan->role->role_akses
                    ],
                    'pesan' => [
                        'subjek' => $pesan->subjek,
                        'prioritas' => $pesan->prioritas,
                        'status' => $pesan->status
                    ],
                    'attachment' => $balasan->attachment,
                    'is_read' => $balasan->is_read,
                    'created_at' => $balasan->created_at->format('H:i, d F Y'),
                    'click_action' => 'OPEN_CONSULTATION_DETAIL'
                ]);

            return $this->sendNotification($recipient->fcm_token, $notification);
        }

        Log::info('Reply notification not sent: Recipient has no FCM token', [
            'pesan_id' => $pesan->id,
            'balasan_id' => $balasan->id,
            'recipient_type' => get_class($recipient),
            'recipient_id' => $recipient ? $recipient->getKey() : null
        ]);

        return false;
    }

    /**
     * Kirim notifikasi untuk perubahan status konsultasi
     */
    public function sendStatusChangeNotification(Pesan $pesan, string $oldStatus)
    {
        $statusMessage = $pesan->status === 'selesai' ? 'telah diselesaikan' : 'kembali aktif';
        
        $recipients = [
            [
                'user' => $pesan->mahasiswa,
                'role' => 'mahasiswa'
            ],
            [
                'user' => $pesan->dosen,
                'role' => 'dosen'
            ]
        ];

        $successCount = 0;

        foreach ($recipients as $recipient) {
            if ($recipient['user'] && $recipient['user']->fcm_token) {
                $notification = Notification::create()
                    ->withTitle('Status Konsultasi Berubah')
                    ->withBody("Konsultasi '{$pesan->subjek}' {$statusMessage}")
                    ->withData([
                        'type' => 'status_change',
                        'pesan_id' => $pesan->id,
                        'old_status' => $oldStatus,
                        'new_status' => $pesan->status,
                        'pesan' => [
                            'subjek' => $pesan->subjek,
                            'prioritas' => $pesan->prioritas,
                            'last_reply_by' => $pesan->last_reply_by,
                            'last_reply_at' => $pesan->last_reply_at ? $pesan->last_reply_at->format('H:i, d F Y') : null
                        ],
                        'recipient_role' => $recipient['role'],
                        'updated_at' => now()->format('H:i, d F Y'),
                        'click_action' => 'OPEN_CONSULTATION_DETAIL'
                    ]);

                if ($this->sendNotification($recipient['user']->fcm_token, $notification)) {
                    $successCount++;
                }
            }
        }

        return $successCount > 0;
    }

    /**
     * Kirim notifikasi pengingat untuk pesan yang belum dibalas
     */
    public function sendReminderNotification(Pesan $pesan)
    {
        if ($pesan->status !== 'aktif') {
            return false;
        }

        $lastReply = $pesan->balasan()->latest()->first();
        
        // Tentukan penerima berdasarkan balasan terakhir
        $recipient = (!$lastReply || $lastReply->role->role_akses === 'mahasiswa')
            ? $pesan->dosen
            : $pesan->mahasiswa;

        if ($recipient && $recipient->fcm_token) {
            $notification = Notification::create()
                ->withTitle('Pengingat Konsultasi')
                ->withBody("Anda memiliki pesan yang belum dibalas: {$pesan->subjek}")
                ->withData([
                    'type' => 'reminder',
                    'pesan_id' => $pesan->id,
                    'pesan' => [
                        'subjek' => $pesan->subjek,
                        'prioritas' => $pesan->prioritas,
                        'status' => $pesan->status,
                        'last_reply_at' => $pesan->last_reply_at ? $pesan->last_reply_at->format('H:i, d F Y') : null,
                        'last_reply_by' => $pesan->last_reply_by
                    ],
                    'recipient_role' => $recipient instanceof Mahasiswa ? 'mahasiswa' : 'dosen',
                    'created_at' => now()->format('H:i, d F Y'),
                    'click_action' => 'OPEN_CONSULTATION_DETAIL'
                ]);

            return $this->sendNotification($recipient->fcm_token, $notification);
        }

        Log::info('Reminder notification not sent: Recipient has no FCM token', [
            'pesan_id' => $pesan->id,
            'recipient_type' => get_class($recipient),
            'recipient_id' => $recipient ? $recipient->getKey() : null
        ]);

        return false;
    }

    /**
     * Helper method untuk mengirim notifikasi
     */
    protected function sendNotification(string $token, Notification $notification)
    {
        try {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification);

            $this->messaging->send($message);
            
            Log::info('Notification sent successfully', [
                'token' => $token,
                'notification_title' => $notification->toArray()['title'] ?? null,
                'notification_body' => $notification->toArray()['body'] ?? null
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Firebase Notification Error', [
                'error' => $e->getMessage(),
                'token' => $token,
                'notification_title' => $notification->toArray()['title'] ?? null,
                'notification_body' => $notification->toArray()['body'] ?? null
            ]);
            
            return false;
        }
    }
}