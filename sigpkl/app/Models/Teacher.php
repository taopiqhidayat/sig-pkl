<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function placement()
    {
        return $this->hasMany(Placement::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
