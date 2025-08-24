<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Models\Lecture;
use Illuminate\Support\Facades\Route;

// home page
Route::view('/' , 'home')
    ->name('home')
    ->middleware('auth');

//login
Route::get('/login' , [LoginController::class , 'index'])->name('login')->middleware('guest');
Route::post('/login' , [LoginController::class , 'store'])->middleware('guest');
Route::delete('/logout' , [LoginController::class , 'destroy'])->middleware('auth');

//register
Route::get('/register', [RegisterController::class , 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class , 'store'])->middleware('guest');

//profile
Route::get('/profile' , [ProfileController::class , 'index'])->middleware('auth');

// courses
Route::middleware(['auth', 'verified', 'check.exam'])->group(function () {
    Route::get('courses', [CourseController::class, 'main'])->name('courses');
    Route::get('courses/{course}', [CourseController::class, 'index'])->name('lectures');
    Route::get('lectures/{lecture}/buy', [CourseController::class, 'buy'])->name('lectures.buy');
    Route::get('lectures/{course}/{lecture}', [CourseController::class, 'show'])->name('lectures.show');
});

// exam
Route::get('courses/{course}/{lecture}/exams', [ExamController::class, 'prepareExam'])
    ->middleware(['auth' , 'verified'])
    ->name('exam.prepareExam');

Route::post('/courses/{course}/{lecture}/exams/{exam}/submit', [ExamController::class, 'submit'])
    ->middleware(['auth' , 'verified']);

Route::post('/submit/{exam}/{session}/{student}', [ExamController::class, 'store'])
    ->middleware(['auth' , 'verified'])
    ->name('exam.store');

Route::get('courses/{course}/{lecture}/exams/{exam}', [ExamController::class, 'show'])
    ->middleware(['auth' , 'verified'])
    ->name('exam.show');

Route::get('info/{session}', [ExamController::class, 'info'])
    ->middleware(['auth' , 'verified' , 'check.exam'])
    ->name('exam.info');
Route::get('info/model/{session}', [ExamController::class, 'model'])
    ->middleware(['auth' , 'verified' , 'check.exam'])
    ->name('exam.model');

// Verifications
Route::get('email/verify', [EmailController::class, 'waiting'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailController::class , 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailController::class , 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');
