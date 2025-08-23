<!-- resources/views/exam/details.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Details - {{ $lecture->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container" style="max-width: 700px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h1>Exam for Lecture: {{ $lecture->title }}</h1>
    <h2>Course: {{ $course->name }}</h2>

    <p><strong>Duration:</strong> {{ $exam->duration }} minutes</p>


    <form method="POST" action="/courses/{{$course->id}}/{{$lecture->id}}/exams/{{$exam->id}}/submit">
        @csrf
        <button type="submit">
            Start Exam
        </button>
    </form>

</div>
</body>
</html>
