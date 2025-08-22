<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// home page
Route::view('/' , 'home')->middleware('auth');

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
Route::get('courses' , [CourseController::class , 'main'])->middleware(['auth' , 'verified'])->name('courses');
Route::get('courses/buy/{lecture}' , [CourseController::class , 'buy'])->middleware(['auth' , 'verified'])->name('buy');
Route::get('courses/{subject}' , [CourseController::class , 'index'])->middleware(['auth' , 'verified'])->name('lectures');
Route::get('courses/{subject}/{lecture}' , [CourseController::class , 'show'])->middleware(['auth' , 'verified'])->name('lecture');

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
