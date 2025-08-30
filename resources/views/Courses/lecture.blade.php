<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thoth Gate - Course Detail</title>
    <link rel="stylesheet" href="/styles.css">
    <link rel="icon" href="/imgs/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="course-detail-page">
<header class="main-header">
    <div class="header-content">
        <div class="logo-container">
            <img src="/imgs/logo.png" alt="Thoth Gate Logo" class="logo-image">
            <h1 class="site-logo">Thoth Gate</h1>
        </div>

        <!-- Hamburger Menu Button -->
        <button class="hamburger-menu" id="hamburgerMenu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="main-nav">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/courses" class="active">Courses</a></li>
                <li><a href="/community">Chat</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/profile">Profile</a></li>
                <li>
                <form method="POST" action="/logout" id = "logoutForm">
                    @csrf
                    @method('DELETE')
                    <a href="#" class="logout-btn" onclick="document.getElementById('logoutForm').submit(); return false;">Logout</a>
                </form>
            </li>
            </ul>
        </nav>

        <div class="switchers-container">
            <button class="theme-switcher" id="themeSwitcher" title="Toggle Dark Mode">
                <span class="theme-icon">🌙</span>
            </button>
            <button class="language-switcher" id="languageSwitcher" title="Switch Language">
                <span class="language-text">EN</span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Sidebar -->
<div class="mobile-sidebar" id="mobileSidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <img src="/imgs/logo.png" alt="Thoth Gate Logo" class="logo-image">
            <h1 class="site-logo">Thoth Gate</h1>
        </div>
        <button class="close-sidebar" id="closeSidebar">
            <span></span>
            <span></span>
        </button>
    </div>

    <nav class="sidebar-nav">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/courses" class="active">Courses</a></li>
            <li><a href="/community">Chat</a></li>
            <li><a href="/contact">Contact</a></li>
            <li><a href="/profile">Profile</a></li>
            <li>
                <form method="POST" action="/logout" id = "logoutForm">
                    @csrf
                    @method('DELETE')
                    <a href="#" class="logout-btn" onclick="document.getElementById('logoutForm').submit(); return false;">Logout</a>
                </form>
            </li>
        </ul>
    </nav>

    <div class="sidebar-switchers">
        <button class="theme-switcher" id="sidebarThemeSwitcher" title="Toggle Dark Mode">
            <span class="theme-icon">🌙</span>
        </button>
        <button class="language-switcher" id="sidebarLanguageSwitcher" title="Switch Language">
            <span class="language-text">EN</span>
        </button>
    </div>
</div>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay"></div>

<main class="course-main">
    <div class="course-container">
        <!-- Course Header -->
        <div class="course-header">
            <div class="course-info">
                <img src="/{{$course->image}}" alt="Course Image" class="course-banner">
                <div class="course-details">
                    <h1>{{$course->subject}}</h1>
                    <div class="course-meta">
                        <span class="course-span" style="display: flex;">
                            <p style="font-weight: 600; font-size: 1rem; margin-bottom: auto;">
                                Lecture
                            </p>
                            &nbsp;
                            {{$lecture->index}}
                        </span>
                        <span class="course-span" style="display: flex;">
                            <p style="font-weight: 600; font-size: 1rem; margin-bottom: auto; color:#f5deb3">
                                Teacher
                            </p>
                            &nbsp;
                            <p style="font-weight: 600; font-size: 1rem; margin-bottom: auto;">
                                {{$course->teacher}}
                            </p>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="course-content-wrapper">
            <!-- Lectures Sidebar -->
            <aside class="lectures-sidebar">
                <div class="sidebar-header">
                    <h3>Course Lectures</h3>
                    <button class="toggle-sidebar">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

                <div class="lectures-list">
                    @foreach($lecs as $lec)
                        <a href="/lectures/{{$course->id}}/{{$lec->id}}" style="text-decoration: none;">
                            <div class="lecture-item {{$lec->id == $lecture->id ? 'active' : ''}}">
                                <div class="lecture-thumbnail">
                                    <img src="/{{$course->image}}" alt="{{$lec->title}}">
                                </div>
                                <div class="lecture-info">
                                    <div style="display: flex;">
                                        <h3 class="lecture-title">Lecture</h3>
                                        <h3 class = "lecture-title">&nbsp;{{$lec->index}} :</h3>
                                    </div>
                                    <h4 class="lecture-title">{{$lec->title}}</h4>
                                    <p class="lecture-description">{{$lec->description}}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </aside>

            <!-- Main Video Area -->
            <div class="video-main-area">
                <div class="video-container">
                    <div class="video-player" id="videoPlayer">
                        <video controls class="video-element">
                            <source src="https://example.com/video1.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="video-info">
                        <h2>{{$lec->title}}</h2>
                        <p>{{$lec->description}}</p>
                        @if($session)
                            <button class="quiz-btn"
                                    onclick="window.location.href='{{ route('exam.info' , $session->id)}}'">
                                <span class="quiz-icon">📝</span>
                                Show Score
                            </button>
                        @else
                            <button class="quiz-btn"
                                    onclick="window.location.href='{{ route('exam.prepareExam' , [$course->id , $lecture->id])}}'">
                                <span class="quiz-icon">📝</span>
                                Take Quiz
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
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
            <p>&copy; 2024 Thoth Gate Learning Center. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="/script.js"></script>
</body>
</html>
