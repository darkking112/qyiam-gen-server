<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/', UserController::class . '@login');

Route::prefix('admin')->group(function () {
    Route::get('get-users', UserController::class . '@getAllUsers');
    Route::put('reset-user-password', UserController::class . '@resetUserPassword');
    Route::delete('remove-user/{userID}', UserController::class . '@removeUser');
    Route::post('add-new-user', UserController::class . '@addNewUser');
    Route::put('assign-student-to-class', StudentController::class . '@assignToClass');

    Route::get('get-student-sheets/{userID}', SheetController::class . '@getSheetsByUserID');
    Route::get('get-student-sheet/${sheetID}', SheetController::class . '@getSheetByID');

    Route::get('get-classes', ClassController::class . '@getClasses');
    Route::put('set-class-name', ClassController::class . '@setClassName');
    Route::delete('remove-class/{classID}', ClassController::class . '@removeClass');
    Route::post('add-class', ClassController::class . '@addClass');
    Route::put('assign-teacher-to-class', ClassController::class . '@assignTeacherToClass');
})->name('admin');

Route::prefix('teacher')->group(function () {
    Route::get('get-students-list/{teacherID}', StudentController::class . '@getStudentsByTeacherID');
    Route::get('get-student-sheets/{studentID}', SheetController::class . '@getSheetsByStudentID');
    Route::get('check-eligibility/{studentID}', SheetController::class . '@checkStudentEligibility');
    Route::post('add-sheet', SheetController::class . '@addSheet');
    Route::get('get-student-sheet/${sheetID}', SheetController::class . '@getSheetByID');
    Route::post('add-comment', CommentController::class . '@addComment');
})->name('teacher');

Route::prefix('student')->group(function () {
    Route::get('check-eligibility/{studentID}', SheetController::class . '@checkStudentEligibility');
    Route::post('add-sheet', SheetController::class . '@addSheet');
})->name('student');
