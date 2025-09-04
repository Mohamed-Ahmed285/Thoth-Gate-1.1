<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Community;
use App\Models\Contact;
use App\Models\Course;
use App\Models\ExamSession;
use App\Models\Instructor;
use App\Models\Lecture;
use App\Models\PurchasedCommunity;
use App\Models\PurchasedLectures;
use App\Models\Question;
use App\Models\SessionChoice;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('admin.home', [
            'totalCourses' => $totalCorses,
            'totalStudents' => $totalStudents,
            'totalInstructors' => $totalInstructors,
            'totalPurchased' => $totalPurchased,
            'notifications' => $notifications,
            'topCourses' => $topCourses,
        ]);
    }

    public function exportStudents()
    {
        $students = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->select('users.name', 'users.email', 'students.grade', 'students.points')
            ->get();

        $filename = 'students.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Name', 'Email', 'Grade', 'Points']);
        foreach ($students as $student) {
            fputcsv($handle, [(string) $student->name, (string) $student->email, (string) $student->grade, (string) $student->points]);
        }
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function exportInstructors()
    {
        $instructors = DB::table('instructors')
            ->join('users', 'instructors.user_id', '=', 'users.id')
            ->select('users.name', 'users.email' , 'instructors.subject')
            ->get();

        $filename = 'instructors.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Name', 'Email' , 'Subject']);
        foreach ($instructors as $instructor) {
            fputcsv($handle, [(string) $instructor->name, (string) $instructor->email , (string) $instructor->subject]);
        }
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function instructors()
    {
        $instructores = Instructor::with('user')->paginate(3);

        return view('admin.instructors', ['instructors' => $instructores]);
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

    public function createInstructorIndex()
    {
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

    public function students()
    {
        $students = Student::with('user')->paginate(10);
        $allStudents = Student::with('user')->get();

        return view('admin.students', ['students' => $students, 'allStudents' => $allStudents]);
    }

    public function showStudent(Student $student)
    {
        $purchasedLectures = $student->lectures()
            ->with('course')
            ->get()
            ->groupBy('course_id');

        $availableCourses = Course::where('grade', $student->grade)->get();

        $allPurchased = $student->lectures()->pluck('lecture_id')->toArray();

        $availableLectures = Lecture::whereIn('course_id', $availableCourses->pluck('id'))
            ->whereNotIn('id', $allPurchased)
            ->get(['id', 'name', 'course_id', 'index']);

        $purchased = $student->lectures->map(function ($pl) {
            return $pl->lecture->only(['id' , 'index' , 'course_id']);
        });

        // dd($purchased);
        return view('admin.show-student', [
            'student' => $student,
            'purchasedLectures' => $purchasedLectures,
            'availableCourses' => $availableCourses,
            'availableLectures' => $availableLectures,
            'purchased' => $purchased,
        ]);
    }

    public function destroyStudent(Student $student)
    {
        $user = User::find($student->user_id);
        $student->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.students')->with('success', 'Student Deleted Successfully');
    }

    public function grantAccess($student_id, Request $request)
    {
        $request->validate([
            'lecture_id' => 'required|exists:lectures,id',
        ]);
        $student = Student::findOrFail($student_id);
        $lecture = Lecture::with('course')->findOrFail($request->lecture_id);

        PurchasedLectures::create([
            'student_id' => $student->id,
            'lecture_id' => $lecture->id,
            'course_id' => $lecture->course->id,
        ]);

        $community = PurchasedCommunity::where('student_id' , $student_id)->first();

        if($community){
            $community->end_date = Carbon::now()->addMonth();
            $community->save();
        }
        else{
            PurchasedCommunity::create([
                'student_id' => $student->id,
                'community_id' => Community::where('grade' , $student->grade)->first()->id,
                'end_date' => Carbon::now()->addMonth(),
            ]);
        }

        return redirect()->route('students.show', [$student_id])->with('success', 'Lecture granted successfully!');
    }
    public function removeAccess(Request $request , $std){
        $validated = $request->validate([
            'lecture_id' => 'required|exists:lectures,id'
        ]);
        $lecture = PurchasedLectures::where('student_id' , $std)
            ->where('lecture_id' , $validated['lecture_id'])
            ->first();
        if ($lecture){
            $lecture->delete();
            return redirect()->route('students.show' , ['student' => $std])->with('success' , "Lecture removed successfully!");
        }
        return redirect()->route('students.show', ['student' =>$std])->with('error', "something went wrong!");
    }
    public function editEndDate(Request $request , $std){
        $validated = $request->validate([
            'chatAccessCheckbox' => 'required',
            'chatEndDate' => 'required|date|after:today'
        ]);

        $student = Student::findOrFail($std);
        $community = PurchasedCommunity::where('student_id', $std)->first();

        if ($community) {
            $community->end_date = $validated['chatEndDate'];
            $community->save();
        } 
        else {
            PurchasedCommunity::create([
                'student_id' => $std,
                'community_id' => Community::where('grade', $student->grade)->first()->id,
                'end_date' => $validated['chatEndDate'],
            ]);
        }
        return redirect()->route('students.show' , $std)->with('success' , 'community granted successfully'); 
    }
    public function StudentExams($student){
        $ExamSessions = ExamSession::with('exam.lecture')
            ->where('student_id' , $student)
            ->whereNotNull('submitted_at')
            ->get();
            
        return view('admin.student-exams', ['ExamSessions'=> $ExamSessions , 'student'=>$student]);
    }
    public function StudentModel($session_id){

        $session = ExamSession::findOrFail($session_id);
        $last_choice = SessionChoice::with('choice.question')
            ->where('exam_session_id', $session->id)
            ->get();

        $student = $session->student;
        $exam = $session->exam;
        $questions = Question::with('choices')->where('exam_id', $exam->id)->get();


        return view('admin.student-model' , [
            'session' => $session,
            'questions' => $questions,
            'last_choice' => $last_choice
        ]);
    }

    public function exportStudentsExams($student_id){
        $student = Student::findOrFail($student_id);
        $studentsExams = DB::table('students')
            // ->join('users', 'students.user_id', '=', 'users.id')
            ->join('exam_sessions', 'exam_sessions.student_id', '=', 'students.id')
            ->join('exams', 'exam_sessions.exam_id', '=', 'exams.id')
            ->join('lectures', 'exams.lecture_id', '=', 'lectures.id')
            ->join('courses', 'lectures.course_id', '=', 'courses.id')
            ->where('students.id', $student_id)
            ->select(
                'courses.subject as course_subject',
                'lectures.title as lecture_title',
                'exam_sessions.score',
                DB::raw('(SELECT COUNT(*) FROM questions WHERE questions.exam_id = exams.id) as total_questions')
            )
            ->get();

        $filename = $student->user->name . '_exams.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Subject', 'Lecture', 'Score', 'Questions']);
        foreach ($studentsExams as $studentExam) {
            fputcsv($handle, [
                (string) $studentExam->course_subject,
                (string) $studentExam->lecture_title,
                (string) $studentExam->score,
                (string) $studentExam->total_questions
            ]);
        }
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    
    }

    public function notifications(){
        $unseen = AdminNotification::where('is_read' , false)
            ->orderBy('created_at', 'desc')
            ->get();

        $seen = AdminNotification::where('is_read' , true)
            ->orderBy('created_at' , 'desc')
            ->get();

        return view('admin.notifications',[
            'unseen' => $unseen,
            'seen' => $seen,
        ]);
    }

    public function readAll(){
        $notifi = AdminNotification::where('is_read' , false)->get();
        foreach($notifi as $n){
            $n->is_read = true;
            $n->save();
        } 
        return redirect()->route('admin.notifications');
    }

    public function readNotification($notification_id){
        $notification = AdminNotification::findOrFail($notification_id);

        $notification->is_read = true;

        $notification->save();

        return redirect()->route('admin.notifications');
    }

    public function deleteNotification($notification_id){
        $notification = AdminNotification::findOrFail($notification_id);
        $notification->delete();
        return redirect()->route('admin.notifications');
    }

    public function messagesView(){
        $messages = Contact::orderBy('created_at' , 'desc')
            ->paginate(4);
        return view('admin.messages' , ['messages' => $messages]);
    }

    public function deleteMessage($message_id){
        $message = Contact::findOrFail($message_id);
        $message->delete();

        return redirect()->route('admin.messages')->with('success' , 'Message deleted successfully!');
    }
}
