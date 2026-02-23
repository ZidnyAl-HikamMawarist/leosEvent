<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'keterangan',
        'link_url',
        'gambar',
        'status'
    ];
}
