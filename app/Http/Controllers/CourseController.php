<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecture;
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

        $lectures = Lecture::where('course_id' , $id)->get();
        return view('Courses.lectures' , ['lectures' => $lectures]);
    }
}
