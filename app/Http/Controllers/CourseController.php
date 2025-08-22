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
        $course = Course::findOrFail($id);
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

    public function show(string $course_id, string $lecture)
    {
        $lec = Lecture::find($lecture);
        if(!$lec){
            return redirect()
                ->route('lectures' , $course_id)
                ->with('error' , 'Lecture not found');
        }
        if ($lec->course->id != $course_id){
            return redirect()
                ->route('lectures' , $course_id)
                ->with('error' , 'this lecture is not for this course');
        }
        if ($lec->course->grade != Auth::user()->student->grade){
            return redirect()
                ->route('courses' , $course_id)
                ->with('error' , 'This Lecture is not for you');
        }
        $valid = PurchasedLectures::where('lecture_id', $lecture)
            ->where('student_id' , Auth::user()->student->id)
            ->first();

        if(!$valid){
            return redirect()->route('buy' , $lec->id);
        }
        $course = Course::findOrFail($lec->course_id);
        $lecs = Lecture::where('course_id' , $lec->course_id)->get();
        return view('Courses.lecture' , ['lecture' => $lec , 'course' => $course , 'lecs' => $lecs]);
    }

    public function buy(string $id)
    {
        $lec = Lecture::where('id' , $id)->first();
        dd('this for buying lecture ' . $lec->title);
    }
}
