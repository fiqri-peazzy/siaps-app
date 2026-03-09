<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSuratField extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'jenis_surat_id',
        'field_key',
        'field_label',
        'field_type',
        'field_options',
        'is_required',
        'urutan',
        'placeholder',
        'validation_rules',
    ];

    protected $casts = [
        'field_options' => 'json',
        'is_required' => 'boolean',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}
