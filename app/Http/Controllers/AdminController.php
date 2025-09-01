<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\PurchasedLectures;
use App\Models\Lecture;


class AdminController extends Controller
{
    public function home()
    {
        $totalCorses = Course::count();
        $totalStudents = Student::count();
        $totalInstructors = Instructor::count();
        $totalPurchased = PurchasedLectures::count();

        $notifications = AdminNotification::orderBy('created_at', 'desc')->take(3)->get();

        $topCourses = Course::withCount('purchased_lectures')
            ->orderBy('purchased_lectures_count', 'desc')
            ->take(3)
            ->get()
            ->map(function ($course) {
                return $course->subject;
            });

        return view('admin.home' , [
            'totalCourses' => $totalCorses,
            'totalStudents' => $totalStudents,
            'totalInstructors' => $totalInstructors,
            'totalPurchased' => $totalPurchased,
            'notifications' => $notifications,
            'topCourses' => $topCourses
        ]);
    }
    public function exportStudents()
    {
         $students = DB::table('students')
            ->join('users' , 'students.user_id' , '=' , 'users.id')
            ->select('users.name' , 'users.email' , 'students.grade' , 'students.points')
            ->get();

        $filename = "students.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Name', 'Email', 'Grade', 'Points']);
        foreach($students as $student) {
            fputcsv($handle, [(string)$student->name, (string)$student->email, (string)$student->grade, (string)$student->points]);
        }
        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function exportInstructors()
    {
         $students = DB::table('instructors')
            ->join('users' , 'instructors.user_id' , '=' , 'users.id')
            ->select('users.name' , 'users.email')
            ->get();

        $filename = "instructors.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Name', 'Email']);
        foreach($students as $student) {
            fputcsv($handle, [(string)$student->name, (string)$student->email]);
        }
        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }
    public function instructors()
    {
        return view('admin.instructors');
    }
}
