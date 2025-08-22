<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\PurchasedLectures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function main(){
        $courses = Course::where('grade' , Auth::user()->student->grade)->get();
        return view('Courses.courses' , ['courses' => $courses]);
    }

    public function index(string $id)
    {
        if ($id > 5){
            return redirect()->route( 'courses' )->with('error' , 'You are not allowed to access this course');
        }
        $course = Course::where('id' , $id)->first();
        if (Auth::user()->student->grade != $course->grade){
            return redirect()->route( 'courses' )->with('error' , 'You are not allowed to access this course');
        }

        $lectures = Lecture::where('course_id', $id)
            ->with(['purchased_lectures' => function ($query) {
                $query->where('student_id', Auth::user()->student->id);
            }])
            ->get();

        return view('Courses.lectures' , ['lectures' => $lectures , 'course' => $course]);
    }

    public function show(string $subject, string $lecture)
    {
        $valid = PurchasedLectures::where('lecture_id', $lecture)
            ->where('student_id' , Auth::user()->student->id)
            ->first();
        if(!$valid){
            return redirect()->route('lectures' , $subject)->with('error' , 'You are not allowed to access this lecture');
        }
        $lec = Lecture::findOrFail($lecture);
        return view('Courses.lecture' , ['lecture' => $lec]);
    }

    public function buy(string $id)
    {
        $lec = Lecture::where('id' , $id)->first();
        dd('this for buying lecture ' . $lec->title);
    }
}
