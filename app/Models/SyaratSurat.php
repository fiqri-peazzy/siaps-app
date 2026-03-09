<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyaratSurat extends Model
{
    public $timestamps = false;
    protected $table = 'syarat_surat';

    protected $fillable = [
        'jenis_surat_id',
        'nama_syarat',
        'deskripsi',
        'is_required',
        'max_size_kb',
        'allowed_types',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}
