<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['nama', 'sekolah', 'lomba_id', 'source', 'vote_count', 'import_batch', 'created_at', 'updated_at'];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}
