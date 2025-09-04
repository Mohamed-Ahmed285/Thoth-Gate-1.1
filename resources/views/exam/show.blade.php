<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thoth Gate - Quiz</title>
    <link rel="stylesheet" href="/styles.css">
    <link rel="icon" href="/imgs/logo.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="quiz-page">
    <header class="main-header">
        <div class="header-content">
            <div class="logo-container">
                <img src="/imgs/logo.png" alt="Thoth Gate Logo" class="logo-image">
                <h1 class="site-logo">Thoth Gate</h1>
            </div>
            <div class="switchers-container">
                <button class="theme-switcher" id="themeSwitcher" title="Toggle Dark Mode">
                    <span class="theme-icon">🌙</span>
                </button>
            </div>
        </div>
    </header>
    <main class="quiz-main">
        @if (session('warning'))
            <div class="message error" style="margin: 0px 10px;">
                {{ session('warning') }}
            </div>
        @endif
        <div class="container">
            <h2 class="section-title">Quiz</h2>

            <div class="quiz-timer" id="quizTimer">
                ⏳ Time Left: <span id="timer"
                    data-end="{{ $session->started_at->addMinutes($session->duration + 0.03)->toIso8601String() }}"></span>
            </div>

            <form class="quiz-form" method="POST"
                action="/submit/{{ $exam->id }}/{{ $session->id }}/{{ Auth::user()->student->id }}"
                id = "exam-Form">
                <!-- Multiple Choice Question Example -->
                @csrf
                @foreach ($questions as $question)
                    <div class="quiz-question-box">
                        <h3 class="quiz-question">
                            @if ($question->text)
                                {{ $loop->iteration }}. {{ $question->text }}
                            @else
                                {{ $loop->iteration }}.
                                <img src="{{ $question->image }}" alt="Question Image">
                            @endif
                        </h3>
                        <div class="quiz-choices">
                            @foreach ($question->choices as $choice)
                                <div class="quiz-answer">
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $choice->id }}" style="cursor: pointer;">
                                        {{ $choice->text }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <button type="submit" class="btn quiz-submit-btn" onclick="examSubmitted = true">Submit
                    Answers</button>
            </form>
        </div>
    </main>
    <script>
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                const examForm = document.getElementById('exam-Form');
                if (examForm) {
                    alert("You have left the exam page. Your attempt is being submitted automatically.");
                    examForm.submit();
                }
            }
        });
    </script>

    <script src="/script.js"></script>
</body>

</html>
