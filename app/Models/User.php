<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = "userID";
    protected $fillable = ["userID", "name", "email", "password", "role"];

    public function student()
    {
        return $this->hasOne(Student::class,"userID","userID");
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class,"userID","userID");
    }

    public function admin()
    {
        return $this->hasOne(Admin::class,"userID","userID");
    }
}
