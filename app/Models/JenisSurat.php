<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'base_priority',
        'sla_hari',
        'template_path',
        'nomor_format',
        'counter_nomor',
        'requires_verification',
        'is_active',
    ];

    protected $casts = [
        'requires_verification' => 'boolean',
        'is_active' => 'boolean',
    ];
}
