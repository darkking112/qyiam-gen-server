<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    //
    protected $primaryKey = "classID";
    protected $fillable = ["classID", "className"];

    public function student()
    {
        return $this->hasMany(Student::class, "classID","classID");
    }

    public function teacher()
    {
        return $this->hasMany(Teacher::class, "classID","classID");
    }
}
