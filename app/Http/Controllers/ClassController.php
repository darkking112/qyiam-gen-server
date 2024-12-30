<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    //
    public function getClasses(Request $request)
    {
        try {
            $classes = Classe::all();
            return response()->json([
                "status" => "success",
                "classes" => $classes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while retrieving classes.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function addClass(Request $request)
    {
        try {
            $className = $request->input("className");
            $class = Classe::create(["className" => $className]);

            if ($class) {
                return response()->json([
                    "status" => "success",
                    "message" => "Class added successfully.",
                    "class" => $class
                ]);
            } else {
                return response()->json([
                    "status" => "failed",
                    "message" => "Failed to add the class."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while adding the class.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function setClassName(Request $request)
    {
        try {
            $className = $request->input("className");
            $classID = $request->input("classID");

            $class = Classe::find($classID);

            if ($class) {
                $class->className = $className;
                $class->save();

                return response()->json([
                    "status" => "success",
                    "message" => "Class name updated successfully."
                ]);
            } else {
                return response()->json([
                    "status" => "failed",
                    "message" => "Class not found."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while updating the class name.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function removeClass(Request $request)
    {
        try {
            $classID = $request->classID;
            $class = Classe::find($classID);

            if ($class) {
                $status = $class->delete();

                if ($status) {
                    return response()->json([
                        "status" => "success",
                        "message" => "Class deleted successfully."
                    ]);
                } else {
                    return response()->json([
                        "status" => "faild",
                        "message" => "Failed to delete the class."
                    ]);
                }
            } else {
                return response()->json([
                    "status" => "faild",
                    "message" => "Class not found."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while deleting the class.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function assignTeacherToClass(Request $request)
    {
        try {
            $classID = $request->input("classID");
            $userID = $request->input("userID");

            $status = TeacherController::setTeacherClass($userID, $classID);

            if ($status) {
                return response()->json([
                    "status" => "success",
                    "message" => "Teacher assigned to class successfully."
                ]);
            } else {
                return response()->json([
                    "status" => "failed",
                    "message" => "Failed to assign teacher to class."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while assigning the teacher to the class.",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
