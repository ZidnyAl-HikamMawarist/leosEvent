<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'nama',
        'sekolah',
        'lomba_id',
        'status',
    ];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}
