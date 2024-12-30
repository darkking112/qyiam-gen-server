<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function assignToClass(Request $request)
    {
        try {
            $userID = $request->input("userID");
            $classID = $request->input("classID");

            $student = Student::where("userID", "=", $userID)->first();

            if ($student) {
                $student->classID = $classID;
                $student->save();

                if ($student->classID == $classID) {
                    return response()->json([
                        "status" => "success",
                        "message" => "Student Assigned To Class Successfully"
                    ]);
                } else {
                    return response()->json([
                        "status" => "failed",
                        "message" => "Failed to assign student to class."
                    ]);
                }
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Student not found."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while assigning the student to class.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function getStudentsByTeacherID(Request $request)
    {
        try {
            $teacherID = $request->teacherID;

            $teacher = Teacher::find($teacherID);
            $classID = $teacher->classID;

            if ($classID) {
                // Get students associated with the class
                $students = Student::where("classID", "=", $classID)->get();

                if ($students->isNotEmpty()) {
                    return response()->json([
                        "status" => "success",
                        "message" => "Students retrieved successfully.",
                        "students" => $students
                    ]);
                } else {
                    return response()->json([
                        "status" => "failed",
                        "message" => "No students found for the given teacher."
                    ]);
                }
            } else {
                return response()->json([
                    "status" => "failed",
                    "message" => "No class found for the given teacher."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while retrieving students.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

}
