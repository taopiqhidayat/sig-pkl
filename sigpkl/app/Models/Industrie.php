<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industrie extends Model
{
    use HasFactory;

    public function placement()
    {
        return $this->hasMany(Placement::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }
}
