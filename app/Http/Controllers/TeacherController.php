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

    public function getReportData(Request $request)
    {
        $studentID = $request->studentID;
        $studentSheets = SheetController::getReportSheetsByStudentID($studentID);
        $studentComments = CommentController::getReportCommentsByStudentID($studentID);
        if ($studentSheets == null || $studentComments == null) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while retrieving the report data."
            ], 500);
        } else if ($studentSheets->isEmpty() && $studentComments->isEmpty()) {
            return response()->json([
                "status" => "failed",
                "message" => "No data found for the student."
            ]);
        } else {
            return response()->json([
                "status" => "success",
                "sheets" => $studentSheets,
                "comments" => $studentComments
            ]);
        }

    }

}
