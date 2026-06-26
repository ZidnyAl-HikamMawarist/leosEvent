<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    protected $fillable = ['nama', 'sekolah', 'lomba_id', 'source', 'vote_count', 'import_batch', 'created_at', 'updated_at'];

    public function lomba(): BelongsTo
    {
        return $this->belongsTo(Lomba::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function pendaftarans(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'lomba_id', 'lomba_id')
            ->whereColumn('pendaftarans.nama', 'participants.nama')
            ->whereColumn('pendaftarans.sekolah', 'participants.sekolah');
    }
}
