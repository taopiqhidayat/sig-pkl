<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    public function students()
    {
        return $this->belongsTo(Student::class);
    }

    public function calendars()
    {
        return $this->belongsTo(Calendar::class);
    }
}
