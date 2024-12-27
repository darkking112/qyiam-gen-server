<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $primaryKey = "commentID";
    protected $fillable = ["commentID", "studentID", "teacherID", "comment", "commentType", "date"];

    public function student()
    {
        return $this->belongsTo(Student::class, "studentID", "studentID");
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, "teacherID", "teacherID");
    }
}
