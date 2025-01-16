<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function addComment(Request $request)
    {
        try {
            $studentID = $request->input("studentID");
            $teacherID = $request->input("teacherID");
            $comment = $request->input("comment");
            $commentType = $request->input("commentType");
            $date = $request->input("date");

            $insertedComment = Comment::create([
                "studentID" => $studentID,
                "teacherID" => $teacherID,
                "commentType" => $commentType,
                "comment" => $comment,
                "date" => $date
            ]);

            if ($insertedComment) {
                return response()->json([
                    "status" => "success",
                    "message" => "Comment added successfully."
                ]);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Failed to add the comment."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while adding the comment.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public static function getReportCommentsByStudentID($studentID)
    {
        try {
            $commnets = Comment::where('studentID', '=', $studentID)
                ->limit(4)
                ->orderBy('date', 'desc')
                ->get();
            return $commnets;
        } catch (\Exception $e) {
            return $e;
        }
    }

}
