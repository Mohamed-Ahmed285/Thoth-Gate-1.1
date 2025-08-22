<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Lectures - Thoth Gate</title>
    <link rel="stylesheet" href="/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="courses-page">
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
                <li><a href="/chat">Chat</a></li>
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
            <img src="imgs/logo.png" alt="Thoth Gate Logo" class="logo-image">
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
            <li><a href="/chat">Chat</a></li>
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
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<main class="container">
    <h2 class="section-title" style="margin:revert;">Course Lectures</h2>
    <section class="egyptian-wisdom-section-lectures" style="padding: 3rem 0;">
        <div class="container">
            <div class="lectures-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
                <!-- Example lectures, replace with dynamic content as needed -->
                @foreach($lectures as $lecture)
                    <div class="course-card lecture-card" style="cursor:pointer;">
                        <div class="course-image">
                            <img src="/{{$course->image}}" alt="{{$course->subject}}">
                        </div>
                        <div class="course-content">
                            <div style="display: flex;">
                                <h3 class="lecture-title">Lecture</h3>
                                <h3 class = "lecture-title">&nbsp;{{$lecture->index}} :</h3>
                            </div>
                            <h3 class = "lecture-title">{{$lecture->title}}</h3>
                            <p class="lecture-description">{{$lecture->description}}.</p>
                            <div>
                                @if($lecture->purchased_lectures->isNotEmpty())
                                    <a href="/courses/{{$course->id}}/{{$lecture->id}}" class="course-btn">View Lecture</a>
                                @else
                                    <a href="/courses/buy/{{$lecture->id}}" class="course-btn">Buy Lecture</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Add more lectures as needed -->
            </div>
        </div>
    </section>
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
                    <li><a href="/chat">Chat</a></li>
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
