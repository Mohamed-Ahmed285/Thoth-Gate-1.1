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
        $instructores = Instructor::with('user')->paginate(10);
        return view('admin.instructors' , ['instructors' => $instructores]);
    }
    
    public function createInstructor(Request $request)
    {
        $request->validate([
            'instructorName' => 'required|string|max:255',
            'instructorEmail' => 'required|string|email|max:255|unique:users,email',
            'instructorPassword' => 'required|string|min:8',
            'instructorCourse' => 'required|string|max:255',
            'instructorPhone' => 'required|numeric',
            'dateOfBirth' => 'required|date|before:2006-01-01',
        ]);

        $user = User::create([
            'name' => $request->input('instructorName'),
            'email' => $request->input('instructorEmail'),
            'password' => bcrypt($request->input('instructorPassword')),
            'type' => 1,
            'email_verified_at' => now(),
            'phone_number' => $request->input('instructorPhone'),
            'date_of_birth' => $request->input('dateOfBirth'),
        ]);

        Instructor::create([
            'user_id' => $user->id,
            'subject' => $request->input('instructorCourse'),
        ]);

        return redirect()->route('admin.instructors')->with('success', 'Instructor Created Successfully');
    }

    public function createInstructorIndex(){
        return view('admin.create-instructor');
    }
    
    public function destroyInstructor(Instructor $instructor)
    {
        $user = User::find($instructor->user_id);
        $instructor->delete();
        if ($user) {
            $user->delete();
        }
        return redirect()->route('admin.instructors')->with('success', 'Instructor Deleted Successfully');
    }

}
