<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\Lecture;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($course_id, $lecture_id)
    {
        $lecture = Lecture::find($lecture_id);
        $course = $lecture->course;
        $exam = $lecture->exam->first();
        return view('exam.index', ['course' => $course, 'lecture' => $lecture, 'exam' => $exam]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($courseId, $lectureId, $examId)
    {
        $exam = Exam::findOrFail($examId);
        $questions = Question::where('exam_id', $examId)->get();

        $student = Auth::user();

        $session = ExamSession::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->whereNull('submitted_at')
            ->first();

        if (!$session) {
            return redirect()->route('exam.index', [$courseId, $lectureId])
                ->with('error', 'You must start the exam first.');
        }

        return view('exam.show', [
            'exam'      => $exam,
            'questions' => $questions,
            'session'   => $session,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        //
    }

    public function submit(Course $course, Lecture $lecture, Exam $exam)
    {
        ExamSession::create([
            'student_id' => Auth::user()->student->id,
            'exam_id' => $exam->id,
            'started_at' => now(),
            'duration' => $exam->duration,
            'submitted_at' => null,
            'score' => null
        ]);
        return redirect()->route('exam.show' , [$course , $lecture , $exam]);
    }
}
