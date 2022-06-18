<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function placement()
    {
        return $this->hasOne(Placement::class);
    }

    public function myjobs()
    {
        return $this->hasMany(Myjob::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function scores()
    {
        return $this->hasOne(Student::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function presentations()
    {
        return $this->hasOne(Presentation::class);
    }

    public function reports()
    {
        return $this->hasOne(Report::class);
    }
}
