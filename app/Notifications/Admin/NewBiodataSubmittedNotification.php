<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBiodataSubmittedNotification extends Notification
{
    use Queueable;

    protected $biodata;

    public function __construct($biodata)
    {
        $this->biodata = $biodata;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_biodata',
            'title' => 'Biodata Baru Masuk',
            'message' => 'Biodata baru dari ' . $this->biodata->nama_lengkap . ' (NIK: ' . $this->biodata->nik . ') memerlukan validasi.',
            'biodata_id' => $this->biodata->id,
            'user_id' => $this->biodata->user_id,
            'action_url' => route('admin.biodata-validation.show', $this->biodata->id),
        ];
    }
}
