<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $fillable = ['nama', 'pesan', 'lomba_id', 'status'];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}
