<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendaftaran extends Model
{
    use SoftDeletes;
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
        'import_batch',
        'created_at',
        'updated_at',
    ];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}
