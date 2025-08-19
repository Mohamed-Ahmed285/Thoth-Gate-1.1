<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::view('/' , 'home');


//login
Route::get('/login' , [LoginController::class , 'index']);
Route::post('/login' , [LoginController::class , 'store']);

//register
Route::get('/register', [RegisterController::class , 'index']);
Route::post('/register', [RegisterController::class , 'store']);
