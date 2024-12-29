<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    //
    public function getSheetsByStudentID(Request $request)
    {
        try {
            $studentID = $request->studentID;

            // Retrieve sheets for the specific student, limit to 30, and order by date
            $sheets = Sheet::where('studentID', '=', $studentID)
                ->limit(30)
                ->orderBy('date', 'desc')
                ->get();

            if ($sheets->isNotEmpty()) {
                return response()->json([
                    "status" => "success",
                    "message" => "Sheets retrieved successfully for the student.",
                    "sheets" => $sheets
                ]);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "No sheets found for the given student."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while retrieving the sheets.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function addSheet(Request $request)
    {
        try {
            $date = now()->format("Y-m-d");
            $studentID = $request->input("studentID");
            $prayerOnTime = $request->input("prayerOnTime");
            $voluntaryPrayers = $request->input("voluntaryPrayers");
            $morningSupplications = $request->input("morningSupplications");
            $eveningSupplications = $request->input("eveningSupplications");
            $quranDailyPortion = $request->input("quranDailyPortion");
            $listeningToParents = $request->input("listeningToParents");
            $organizingPersonalBelongings = $request->input("organizingPersonalBelongings");
            $siwak = $request->input("siwak");
            $helpingInHouse = $request->input("helpingInHouse");
            $sleepingEarly = $request->input("sleepingEarly");
            $lessonsReviewing = $request->input("lessonsReviewing");
            $readingSurahAlKahaf = $request->input("readingSurahAlKahaf");
            $attendingFridayEarly = $request->input("attendingFridayEarly");
            $connectingWithRelatives = $request->input("connectingWithRelatives");
            $dailyExercise = $request->input("dailyExercise");
            $healthyFood = $request->input("healthyFood");
            $insertedBy = $request->input("insertedBy");

            $sheet = Sheet::create([
                'studentID' => $studentID,
                'prayerOnTime' => $prayerOnTime,
                'voluntaryPrayers' => $voluntaryPrayers,
                'morningSupplications' => $morningSupplications,
                'eveningSupplications' => $eveningSupplications,
                'quranDailyPortion' => $quranDailyPortion,
                'listeningToParents' => $listeningToParents,
                'organizingPersonalBelongings' => $organizingPersonalBelongings,
                'siwak' => $siwak,
                'helpingInHouse' => $helpingInHouse,
                'sleepingEarly' => $sleepingEarly,
                'lessonsReviewing' => $lessonsReviewing,
                'readingSurahAlKahaf' => $readingSurahAlKahaf,
                'attendingFridayEarly' => $attendingFridayEarly,
                'connectingWithRelatives' => $connectingWithRelatives,
                'dailyExercise' => $dailyExercise,
                'healthyFood' => $healthyFood,
                'insertedBy' => $insertedBy,
                'date' => $date
            ]);

            if ($sheet) {
                return response()->json([
                    "status" => "success",
                    "message" => "Sheet added successfully."
                ]);
            } else {
                return response()->json([
                    "status" => "failed",
                    "message" => "Failed to add the sheet."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while adding the sheet.",
                "error" => $e->getMessage()
            ], 500);
        }
    }


    public function checkStudentEligibility(Request $request)
    {
        try {
            $studentID = $request->studentID;

            // Fetch the latest sheet for the given student
            $sheet = Sheet::where("studentID", $studentID)->latest("sheetID")->first();

            if ($sheet) {
                $date = now()->format("Y-m-d");

                // Check if the latest sheet was submitted today
                if ($sheet->date == $date) {
                    return response()->json([
                        "status" => "failed",
                        "message" => "You are not allowed to submit two forms on the same day."
                    ]);
                } else {
                    return response()->json([
                        "status" => "success",
                        "message" => "You are eligible to submit a form."
                    ]);
                }
            } else {
                // No previous sheet found, student is eligible
                return response()->json([
                    "status" => "success",
                    "message" => "You are eligible to submit a form."
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while checking eligibility.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

}
