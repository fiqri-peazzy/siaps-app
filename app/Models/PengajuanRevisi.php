<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanRevisi extends Model
{
    protected $table = 'pengajuan_revisi';

    protected $fillable = [
        'pengajuan_id',
        'diminta_oleh',
        'catatan_revisi',
        'jawaban_revisi',
        'status',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'diminta_oleh');
    }
}
