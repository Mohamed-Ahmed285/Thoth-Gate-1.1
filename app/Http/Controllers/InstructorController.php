<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageEvent;
use App\Models\Exam;
use App\Models\InstructorCourse;
use App\Models\Lecture;

class InstructorController extends Controller
{
    public function home(){
        return view('instructor.home');
    }
    
    public function addLecture(){
        $ins = Auth::user()->instructor;

        $exams = Exam::where('instructor_id' , $ins->id)
            ->whereNull('lecture_id')
            ->get();

        $courses = InstructorCourse::where('instructor_id', $ins->id)
            ->join('courses', 'instructor_courses.course_id', '=', 'courses.id')
            ->get(['course_id' , 'grade', 'subject']);

        return view('instructor.add-lecture' , [
            'exams' => $exams,
            'courses' => $courses,
        ]);
    }
    
    public function saveLecture(Request $request){
        $validated = $request->validate([
            'lecture-video'      => 'required|mimes:mp4,mov,avi,wmv|max:512000', 
            'lecture-title'       => 'required|string|max:255',
            'lecture-description' => 'required|string',
            'quiz-name'           => 'required|exists:exams,id',
            'grade'               => 'required|exists:courses,id',
        ]);
        $videoPath = $request->file('lecture-video')->store('lectures', 'public');

        $index = Lecture::where('course_id' , $validated['grade'])->count() + 1;

        $lec = Lecture::create([
            'index' => $index,
            'course_id'     => $validated['grade'],
            'instructor_id' => Auth::user()->instructor->id,
            'title'         => $validated['lecture-title'],
            'video'          => '/storage/' . $videoPath,
            'image'         => '/',
            'description'   => $validated['lecture-description'],
        ]);

        $exam = Exam::findOrFail($validated['quiz-name']);
        $exam->lecture_id = $lec->id;
        $exam->save();

        return redirect()->route('instructor.addLecture')->with('success', 'Lecture added successfully!');
    }


    public function createExam(){
        $ins = Auth::user()->instructor;

        $grades = InstructorCourse::where('instructor_id', $ins->id)
            ->join('courses', 'instructor_courses.course_id', '=', 'courses.id')
            ->distinct()
            ->pluck('courses.grade');

        return view('instructor.create-exam' , ['grades' => $grades]);
    }

    public function saveExam(Request $request){
        $validated = $request->validate([
            'exam-title' => 'required|string|max:255',
            'exam-duration' => 'required|integer|max:60',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.choices' => 'required|array|min:2',
            'questions.*.choices.*' => 'required|string',
            'questions.*.correct_choice' => 'required|numeric',
        ]);

        $exam = Exam::create([
            'instructor_id' => Auth::user()->instructor->id,
            'title'      => $validated['exam-title'],
            'duration'   => $validated['exam-duration'],
        ]);

        foreach ($validated['questions'] as $q) {
            $question = $exam->questions()->create([
                'text' => $q['text'],
            ]);

            foreach ($q['choices'] as $index => $choice) {
                $question->choices()->create([
                    'text' => $choice,
                    'is_correct' => ($index == $q['correct_choice']),
                ]);
            }
        }
        return redirect()->route('instructor.addExam')->with('success' , 'Exam created successfully, Now you can add lecture!');
    }


    public function chatsIndex(){
        $communities = Community::all();
        return view('instructor.chats' , ['communities' => $communities]);
    }
    public function chatShow($community_id){
        $messages = CommunityMessage::where('community_id' , $community_id)->get();
        $community = Community::findOrFail($community_id);
        return view('instructor.chat' , ['messages' => $messages , 'fullCommunity' => $community]);
    }
    public function MessageStore(Request $request)
    {

        $request->validate([
            'message' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('community_images'), $imageName);
            $imagePath = 'community_images/' . $imageName;
        }

        if (!$request->message && !$imagePath) {
            return response()->json(['status' => 'Message or image is required!'], 422);
        }

        $message = CommunityMessage::create([
            'user_id' => Auth::user()->id,
            'message' => $request->message,
            'community_id' => $request->community_id,
            'image' => $imagePath,
            'time' => now('Africa/Cairo')->format('h:i A'),
        ]);

        $message->load('user');

        broadcast(new MessageEvent($message))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }
}
