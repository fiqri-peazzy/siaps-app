<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    protected $table = 'profil_desa';

    protected $fillable = [
        'nama_desa',
        'kode_desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'alamat_kantor',
        'telepon',
        'email',
        'website',
        'logo_path',
        'kop_surat_path',
        'visi',
        'misi',
        'luas_wilayah',
        'jumlah_penduduk',
    ];

    /**
     * Get the singleton instance (first record or default).
     */
    public static function getSingleton(): self
    {
        return self::firstOrCreate([], [
            'nama_desa'   => 'Desa Kami',
            'kecamatan'   => '-',
            'kabupaten'   => '-',
            'provinsi'    => '-',
        ]);
    }
}
