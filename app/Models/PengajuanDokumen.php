<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanDokumen extends Model
{
    public $timestamps = false;
    protected $table = 'pengajuan_dokumen';

    protected $fillable = [
        'pengajuan_id',
        'syarat_id',
        'nama_dokumen',
        'original_filename',
        'file_path',
        'file_size',
        'mime_type',
        'upload_status',
        'rejection_note',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class);
    }

    public function syarat()
    {
        return $this->belongsTo(SyaratSurat::class);
    }
}
