<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class InformasiDesa extends Model
{
    use SoftDeletes;

    protected $table = 'informasi_desa';

    protected $fillable = [
        'kategori',
        'judul',
        'slug',
        'konten',
        'tags',
        'thumbnail',
        'gallery',
        'is_published',
        'is_pinned',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_pinned'    => 'boolean',
        'published_at' => 'datetime',
        'gallery'      => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->judul) . '-' . Str::random(5);
            }
        });
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'pengumuman' => 'Pengumuman',
            'berita'     => 'Berita',
            'profil'     => 'Profil',
            'layanan'    => 'Layanan',
            'agenda'     => 'Agenda',
            default      => ucfirst($this->kategori),
        };
    }

    public function getKategoriBadgeColorAttribute(): string
    {
        return match ($this->kategori) {
            'pengumuman' => 'blue',
            'berita'     => 'green',
            'profil'     => 'purple',
            'layanan'    => 'yellow',
            'agenda'     => 'red',
            default      => 'gray',
        };
    }
}
