<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $fillable = ['participant_id', 'ip_address', 'fingerprint'];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }
}
