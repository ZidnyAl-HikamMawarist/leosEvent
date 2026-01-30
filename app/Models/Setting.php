<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_pendaftaran',
        'kontak',
        'status_pendaftaran',
        'nama_event',
        'deskripsi_event',
        'footer_text'
    ];
}
