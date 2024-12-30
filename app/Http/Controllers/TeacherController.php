<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //
    public static function setTeacherClass($userID, $classID)
    {
        try {
            $teacher = Teacher::where("userID", "=", $userID)->first();

            if ($teacher) {
                $teacher->classID = $classID;
                $teacher->save();
                return true;
            } else {
                return false; // Teacher not found
            }
        } catch (\Exception $e) {
            // Log the exception or handle it as required
            return false; // Return false to indicate failure
        }
    }

}
