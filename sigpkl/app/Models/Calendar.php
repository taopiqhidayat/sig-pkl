<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    public function industries()
    {
        return $this->belongsTo(Industrie::class);
    }

    public function presences()
    {
        return $this->hasOne(Presence::class);
    }
}
