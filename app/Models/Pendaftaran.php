<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'no_wa',
        'sekolah',
        'lomba_id',
        'status',
        'nama_pembina',
        'no_hp_pembina',
        'nama_pemimpin_regu',
        'no_hp_pemimpin_regu',
        'formulir_pendaftaran',
        'metode_pembayaran',
    ];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}
