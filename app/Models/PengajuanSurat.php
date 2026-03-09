<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanSurat extends Model
{
    use SoftDeletes;
    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'kode_pengajuan',
        'user_id',
        'biodata_id',
        'jenis_surat_id',
        'keperluan',
        'field_data',
        'catatan_pemohon',
        'priority_score',
        'priority_breakdown',
        'antrian_number',
        'antrian_date',
        'status',
        'submitted_at',
        'queued_at',
        'process_started_at',
        'validated_at',
        'approved_at',
        'ready_at',
        'completed_at',
        'nomor_surat',
        'surat_path',
        'surat_generated_at',
        'handled_by_admin',
        'approved_by',
        'is_priority_recalculated',
        'last_priority_update',
    ];

    protected $casts = [
        'field_data' => 'json',
        'priority_breakdown' => 'json',
        'antrian_date' => 'date',
        'submitted_at' => 'datetime',
        'queued_at' => 'datetime',
        'process_started_at' => 'datetime',
        'validated_at' => 'datetime',
        'approved_at' => 'datetime',
        'ready_at' => 'datetime',
        'completed_at' => 'datetime',
        'surat_generated_at' => 'datetime',
        'last_priority_update' => 'datetime',
        'is_priority_recalculated' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function biodata()
    {
        return $this->belongsTo(BiodataMasyarakat::class);
    }

    public function dokumen()
    {
        return $this->hasMany(PengajuanDokumen::class, 'pengajuan_id');
    }

    public function history()
    {
        return $this->hasMany(PengajuanHistory::class, 'pengajuan_id');
    }

    public function revisi()
    {
        return $this->hasMany(PengajuanRevisi::class, 'pengajuan_id');
    }
}
