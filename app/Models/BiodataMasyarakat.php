<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiodataMasyarakat extends Model
{
    protected $table = 'biodata_masyarakat';

    protected $fillable = [
        'user_id',
        'penduduk_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama_id',
        'pekerjaan_id',
        'status_perkawinan',
        'golongan_darah',
        'rt_id',
        'alamat_lengkap',
        'foto_ktp',
        'foto_kk',
        'is_disabilitas',
        'jenis_disabilitas',
        'is_hamil',
        'catatan_khusus',
        'verification_status',
        'verified_by',
        'verified_at',
        'rejection_reason',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'verified_at' => 'datetime',
        'is_disabilitas' => 'boolean',
        'is_hamil' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function rt()
    {
        return $this->belongsTo(MasterWilayah::class, 'rt_id');
    }
}
