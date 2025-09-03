<?php

use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

//login
Route::get('/login' , [LoginController::class , 'index'])->name('login')->middleware('guest');
Route::post('/login' , [LoginController::class , 'store'])->middleware('guest');
Route::delete('/logout' , [LoginController::class , 'destroy'])->middleware('auth');

//register
Route::get('/register', [RegisterController::class , 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class , 'store'])->middleware('guest');

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

Route::middleware(['auth' , 'student' , 'prevent.multiple.logins'])->group(function () {
    // home page
    Route::view('/' , 'home')
        ->name('home');

    //profile
    Route::get('/profile' , [ProfileController::class , 'index'])
        ->name('profile');

    // courses
    Route::middleware(['verified' , 'check.exam'])->group(function () {
        Route::get('courses', [CourseController::class, 'main'])->name('courses');
        Route::get('courses/{course}', [CourseController::class, 'index'])->name('lectures');
        Route::get('lectures/{lecture}/buy', [CourseController::class, 'buy'])->name('buy');
        Route::get('lectures/{course}/{lecture}', [CourseController::class, 'show'])->name('lectures.show');
    });
    // contact
    Route::get('/contact' , [ContactController::class , 'index'])
        ->middleware(['verified' , 'check.exam'])
        ->name('contact.index');

    Route::post('/contact' , [ContactController::class , 'store'])
        ->middleware(['verified' , 'check.exam']);

    // community
    Route::get('/community' , [CommunityController::class , 'index'])
        ->middleware(['verified' , 'check.exam'])
        ->name('community');

    Route::post('/community' , [CommunityController::class , 'store'])
        ->middleware(['verified' , 'check.exam'])
        ->name('community.store');

    // exams
    Route::prefix('courses/{course}/{lecture}/exams')->middleware('verified')->group(function () {
        Route::get('/', [ExamController::class, 'prepareExam'])->name('exam.prepareExam');
        Route::get('{exam}', [ExamController::class, 'show'])->name('exam.show');
        Route::post('{exam}/submit', [ExamController::class, 'submit']);
    });
    Route::post('/submit/{exam}/{session}/{student}', [ExamController::class, 'store'])
        ->middleware('verified')
        ->name('exam.store');

    Route::get('info/{session}', [ExamController::class, 'info'])
        ->middleware('verified')
        ->name('exam.info');

    Route::get('info/model/{session}', [ExamController::class, 'model'])
        ->middleware('verified')
        ->name('exam.model');
});

// Admin routes
Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/admin/home' , [AdminController::class , 'home'])
        ->name('admin.home');

    Route::get('/students/export' , [AdminController::class , 'exportStudents'])
        ->name('students.export');

    Route::get('/instructors/export' , [AdminController::class , 'exportInstructors'])
        ->name('instructors.export');

    Route::get('/admin/instructors' , [AdminController::class , 'instructors'])
        ->name('admin.instructors');

    Route::get('/admin/instructors/create' , [AdminController::class , 'createInstructorIndex'])
        ->name('instructors.create');

    Route::post('/admin/instructors/create' , [AdminController::class , 'createInstructor']);

    Route::delete('admin/instructors/{instructor}' , [AdminController::class , 'destroyInstructor'])
        ->name('instructors.destroy');

    Route::get('/admin/students' , [AdminController::class , 'students'])
        ->name('admin.students');
    
    Route::get('/admin/students/{student}' , [AdminController::class , 'showStudent'])
        ->name('students.show');

    Route::delete('/admin/students/{student}' , [AdminController::class , 'destroyStudent'])
        ->name('students.destroy');

    Route::post('/open/lecture/{student}' , [AdminController::class , 'grantAccess']);

    Route::delete('/remove/lecture/{student}' , [AdminController::class , 'removeAccess']);

    Route::post('/edit-end-date/{student}' , [AdminController::class , 'editEndDate']);

    Route::get('/admin/exams/{student}' , [AdminController::class , 'StudentExams']);

    Route::get('/admin/model/{session}' , [AdminController::class , 'StudentModel']);

    Route::get('/export/exmas/{student}', [AdminController::class, 'exportStudentsExams'])
        ->name('students.exams.export');

});