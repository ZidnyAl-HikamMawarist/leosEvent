<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lomba',
        'kategori',
        'tanggal_pelaksanaan',
        'tingkat',
        'deskripsi',
        'poster',
        'status'
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
