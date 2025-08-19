<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/' , 'home')->middleware('auth');

// just for test
Route::get('/user' , function (){
    dd(Auth::user());
});

//login
Route::get('/login' , [LoginController::class , 'index'])->name('login')->middleware('guest');
Route::post('/login' , [LoginController::class , 'store'])->middleware('guest');
Route::delete('/logout' , [LoginController::class , 'destroy'])->middleware('auth');

//register
Route::get('/register', [RegisterController::class , 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class , 'store'])->middleware('guest');;


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
