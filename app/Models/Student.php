<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $primaryKey = "studentID";
    protected $fillable = ["studentID","userID","classID"];

    public function user()
    {
        return $this->belongsTo(User::class, "userID", "userID");
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class,"classID","classID");
    }

    public function comment()
    {
        return $this->hasMany(Comment::class,"studentID","studentID");
    }

    public function sheet()
    {
        return $this->hasMany(Sheet::class,"studentID","studentID");
    }
}
