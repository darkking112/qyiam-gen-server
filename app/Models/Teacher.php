<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    protected $primaryKey = "teacherID";
    protected $fillable = ["teacherID", "userID", "classID", "name"];

    public function user()
    {
        return $this->belongsTo(User::class, "userID", "userID");
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, "classID", "classID");
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, "studentID", "studentID");
    }
}
