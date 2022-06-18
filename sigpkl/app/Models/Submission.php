<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    public function students()
    {
        return $this->belongsTo(Student::class);
    }

    public function industries()
    {
        return $this->belongsTo(Industrie::class);
    }
}
