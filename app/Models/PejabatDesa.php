<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PejabatDesa extends Model
{
    protected $table = 'pejabat_desa';

    protected $fillable = [
        'user_id',
        'jabatan_id',
        'nip',
        'sk_nomor',
        'periode_mulai',
        'periode_selesai',
        'tanda_tangan',
        'stempel_path',
        'is_aktif',
    ];

    protected $casts = [
        'periode_mulai'   => 'date',
        'periode_selesai' => 'date',
        'is_aktif'        => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(MasterJabatan::class, 'jabatan_id');
    }
}
