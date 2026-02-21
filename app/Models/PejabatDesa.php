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
        'sk_tgl_mulai',
        'sk_tgl_selesai',
        'is_active',
    ];

    protected $casts = [
        'sk_tgl_mulai' => 'date',
        'sk_tgl_selesai' => 'date',
        'is_active' => 'boolean',
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
