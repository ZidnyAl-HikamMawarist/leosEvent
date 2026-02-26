<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lomba',
        'slug',
        'kategori',
        'tanggal_pelaksanaan',
        'tingkat',
        'deskripsi',
        'poster',
        'status',
        'event_year',
        'event_start',
        'event_end',
        'is_save_the_date_active',
        'harga_tiket',
        'lokasi',
        'juklak_juknis_link',
        'juara_1',
        'juara_2',
        'juara_3',
        'tipe_lomba',
        'whatsapp_panitia',
        'link_grup_wa'
    ];



    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
