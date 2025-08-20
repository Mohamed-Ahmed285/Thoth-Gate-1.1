<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PurchasedLectures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(){
        $courses = Course::where('grade' , Auth::user()->student->grade)->get();
        $finishedCounts = PurchasedLectures::select('course_id', DB::raw('count(*) as total'))
            ->where('student_id', Auth::user()->student->id)
            ->where('finished', 1)
            ->groupBy('course_id')
            ->pluck('total', 'course_id');
        $finished = [];
        foreach ($courses as $course) {
            $finished[] = [
                'subject' => $course->subject,
                'finished' => $finishedCounts[$course->id] ?? 0,
                'total' => $course->lectures->count(),
                'instructor' => $course->lectures->first()?->instructor->user->name ?? 'N/A',
            ];
        }
        return view('profile', ['finished' => $finished]);
    }
}
