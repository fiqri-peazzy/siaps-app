<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterWilayah extends Model
{
    protected $table = 'master_wilayah';

    protected $fillable = [
        'parent_id',
        'tipe',
        'kode',
        'nama',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MasterWilayah::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MasterWilayah::class, 'parent_id');
    }
}
