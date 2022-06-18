<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Myjob extends Model
{
    use HasFactory;

    public function students()
    {
        return $this->belongsTo(Student::class);
    }
}
