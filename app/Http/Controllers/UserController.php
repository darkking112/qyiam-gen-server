<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function login(Request $request)
    {
        try {
            $email = $request->input("email");
            $password = $request->input("password");

            $user = User::where("email", "=", $email)->first();
            if ($user && Hash::check($password, $user->password)) {
                if ($user->role == "Student") {
                    $student = Student::where("userID", "=", $user->userID)->first();
                    return response()->json([
                        "status" => "success",
                        "message" => "Loggedin Successfully",
                        "userInfo" => $user,
                        "studentInfo" => $student
                    ]);
                } else if ($user->role == "Teacher") {
                    $teacher = Teacher::where("userID", "=", $user->userID)->first();
                    return response()->json([
                        "status" => "success",
                        "message" => "Loggedin Successfully",
                        "userInfo" => $user,
                        "teacherInfo" => $teacher
                    ]);
                } else if ($user->role == "Admin") {
                    return response()->json([
                        "status" => "success",
                        "message" => "Loggedin Successfully",
                        "userInfo" => $user
                    ]);
                }
            } else {
                return response()->json([
                    "status" => "failed",
                    "message" => "Email or Password is Wrong"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while processing your request.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function getAllUsers(Request $request)
    {
        try {
            $users = User::all()->sortBy('role');
            return response()->json(["status" => "success", "users" => $users]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while fetching users.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function resetUserPassword(Request $request)
    {
        try {
            $userID = $request->input("userID");
            $newPassword = $request->input("newPassword");
            $user = User::find($userID);

            if ($user) {
                $user->password = Hash::make($newPassword);
                $user->save();
                return response()->json([
                    "status" => "success",
                    "message" => "Password Updated Successfully"
                ]);
            } else {
                return response()->json([
                    "status" => "failed",
                    "message" => "User Not Found"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while resetting the password.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function removeUser(Request $request)
    {
        try {
            $userID = $request->userID;
            $user = User::find($userID);

            if ($user) {
                $status = $user->delete();
                if ($status) {
                    return response()->json([
                        "status" => "success",
                        "message" => "User Removed Successfully"
                    ]);
                } else {
                    return response()->json([
                        "status" => "failed",
                        "message" => "Failed to remove the user."
                    ]);
                }
            } else {
                return response()->json([
                    "status" => "failed",
                    "message" => "User Not Found"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while removing the user.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function addNewUser(Request $request)
    {
        $name = $request->input("name");
        $email = $request->input("email");
        $password = $request->input("password");
        $role = $request->input("role");

        try {
            $user = User::create([
                "name" => $name,
                "email" => $email,
                "password" => Hash::make($password),
                "role" => $role
            ]);

            if ($user && $role == "Student") {
                try {
                    $student = Student::create([
                        "name" => $name,
                        "userID" => $user->userID
                    ]);
                    return response()->json([
                        "status" => "success",
                        "message" => "Account Created Successfully",
                        "studentID" => $student->studentID,
                        "userInfo" => $user
                    ]);
                } catch (\Exception $e) {
                    $user->delete(); // Rollback user creation if student creation fails
                    return response()->json([
                        "status" => "error",
                        "message" => "Failed to create Student: " . $e->getMessage()
                    ], 500);
                }
            } elseif ($user && $role == "Teacher") {
                try {
                    $teacher = Teacher::create([
                        "name" => $name,
                        "userID" => $user->userID
                    ]);
                    return response()->json([
                        "status" => "success",
                        "message" => "Account Created Successfully",
                        "teacherID" => $teacher->teacherID,
                        "userInfo" => $user
                    ]);
                } catch (\Exception $e) {
                    $user->delete(); // Rollback user creation if teacher creation fails
                    return response()->json([
                        "status" => "error",
                        "message" => "Failed to create Teacher: " . $e->getMessage()
                    ], 500);
                }
            } else if ($user && $role == "Admin") {
                try {
                    $admin = Admin::create([
                        "userID" => $user->userID
                    ]);
                    return response()->json([
                        "status" => "success",
                        "message" => "Account Created Successfully",
                        "userInfo" => $user
                    ]);
                } catch (\Exception $e) {
                    $user->delete(); // Rollback user creation if teacher creation fails
                    return response()->json([
                        "status" => "error",
                        "message" => "Failed to create Teacher: " . $e->getMessage()
                    ], 500);
                }
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Invalid role specified."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to create User: " . $e->getMessage()
            ], 500);
        }
    }
}
