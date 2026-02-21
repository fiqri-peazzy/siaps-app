<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';

    protected $fillable = [
        'nik',
        'no_kk',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama_id',
        'pekerjaan_id',
        'status_perkawinan',
        'golongan_darah',
        'kewarganegaraan',
        'status_dalam_kk',
        'rt_id',
        'alamat_lengkap',
        'is_aktif',
        'status_penduduk',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_aktif' => 'boolean',
    ];

    public function agama(): BelongsTo
    {
        return $this->belongsTo(MasterAgama::class, 'agama_id');
    }

    public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(MasterPekerjaan::class, 'pekerjaan_id');
    }

    public function rt(): BelongsTo
    {
        return $this->belongsTo(MasterWilayah::class, 'rt_id');
    }
}
