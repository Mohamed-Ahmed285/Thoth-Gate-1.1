<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thoth Gate - Quiz</title>
    <link rel="stylesheet" href="/styles.css">
    <link rel="icon" href="/imgs/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="quiz-page">
<header class="main-header">
    <div class="header-content">
        <div class="logo-container">
            <img src="/imgs/logo.png" alt="Thoth Gate Logo" class="logo-image">
            <h1 class="site-logo">Thoth Gate</h1>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/courses">Courses</a></li>
                <li><a href="/community">Chat</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/profile">Profile</a></li>
            </ul>
        </nav>
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
            ⏳ Time Left: <span id="timer" data-end="{{ $session->started_at->addMinutes($session->duration+0.03)->toIso8601String() }}"></span>
        </div>

        <form class="quiz-form" method="POST" action="/submit/{{$exam->id}}/{{ $session->id }}/{{Auth::user()->student->id}}" id = "exam-Form">
            <!-- Multiple Choice Question Example -->
            @csrf
            @foreach($questions as $question)
                <div class="quiz-question-box">
                    <h3 class="quiz-question">
                        @if($question->text)
                            {{ $loop->iteration }}. {{ $question->text }}
                        @else
                            {{ $loop->iteration }}.
                            <img src="{{ $question->image }}" alt="Question Image">
                        @endif
                    </h3>
                    <div class="quiz-choices">
                        @foreach($question->choices as $choice)
                            <div class="quiz-answer">
                                <label style="cursor: pointer;">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $choice->id }}" style="cursor: pointer;">
                                    {{ $choice->text }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <button type="submit" class="btn quiz-submit-btn" onclick="examSubmitted = true">Submit Answers</button>
        </form>
    </div>
</main>
<footer class="main-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Thoth Gate</h3>
                <p>Gateway to Ancient Wisdom, Modern Learning</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/courses">Courses</a></li>
                    <li><a href="/community">Chat</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/profile">Profile</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p>Email: info@thothgate.edu.eg</p>
                <p>Phone: +20 123 456 789</p>
            </div>
            <div class="footer-section">
                <h4>Follow Us</h4>
                <div class="social-icons">
                    <a href="#" class="social-icon">📘</a>
                    <a href="#" class="social-icon">📷</a>
                    <a href="#" class="social-icon">🐦</a>
                    <a href="#" class="social-icon">💼</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Thoth Gate Learning Center. All rights reserved.</p>
        </div>
    </div>
</footer>
<script>
    let examSubmitted = false;
    document.addEventListener("visibilitychange", function() {
        if (document.hidden && !examSubmitted){
            examSubmitted = true;

            alert("You switched tabs! Your exam will be submitted.");

            document.getElementById("exam-Form").submit();
        }
    });
</script>
<script src = "/script.js"></script>
</body>
</html>
