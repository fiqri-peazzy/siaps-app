<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJabatan extends Model
{
    protected $table = 'master_jabatan';

    protected $fillable = [
        'nama_jabatan',
        'singkatan',
        'is_penandatangan',
        'urutan',
    ];

    protected $casts = [
        'is_penandatangan' => 'boolean',
    ];
}
