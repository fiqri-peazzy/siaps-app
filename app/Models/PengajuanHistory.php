<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanHistory extends Model
{
    public $timestamps = false;
    protected $table = 'pengajuan_history';

    protected $fillable = [
        'pengajuan_id',
        'from_status',
        'to_status',
        'priority_score_saat_itu',
        'actor_id',
        'actor_role',
        'catatan',
        'metadata',
        'created_at',
    ];

    protected $casts = [
        'metadata' => 'json',
        'created_at' => 'datetime',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
