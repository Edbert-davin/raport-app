<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubIndicator extends Model
{
    protected $guarded = [];

    public function aspect()
    {
        return $this->belongsTo(Aspect::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}