<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengajuanStatusUpdated extends Notification
{
    use Queueable;

    public $pengajuan;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\PengajuanSurat $pengajuan, $message = null)
    {
        $this->pengajuan = $pengajuan;

        if ($message) {
            $this->message = $message;
        } else {
            // Default messages based on status
            if ($pengajuan->status === 'completed') {
                $this->message = "Surat " . $pengajuan->jenisSurat->nama . " Anda telah selesai di proses dan siap diunduh.";
            } elseif ($pengajuan->status === 'need_revision') {
                $this->message = "Pengajuan " . $pengajuan->jenisSurat->nama . " Anda memerlukan revisi.";
            } else {
                $this->message = "Status pengajuan " . $pengajuan->jenisSurat->nama . " Anda telah diubah menjadi " . $pengajuan->status;
            }
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pengajuan_id' => $this->pengajuan->id,
            'kode_pengajuan' => $this->pengajuan->kode_pengajuan,
            'jenis_surat' => $this->pengajuan->jenisSurat->nama,
            'status' => $this->pengajuan->status,
            'message' => $this->message,
            'url' => route('masyarakat.pengajuan.show', $this->pengajuan),
        ];
    }
}
