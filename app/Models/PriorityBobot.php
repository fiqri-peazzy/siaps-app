<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriorityBobot extends Model
{
    protected $table = 'priority_bobot';

    protected $fillable = [
        'kategori',
        'kode',
        'label',
        'bobot',
    ];
}
