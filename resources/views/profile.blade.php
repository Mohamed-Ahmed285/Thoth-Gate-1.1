<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thoth Gate - Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="profile-page">
<header class="main-header">
    <div class="header-content">
        <div class="logo-container">
            <img src="imgs/logo.png" alt="Thoth Gate Logo" class="logo-image">
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
                <li><a href="/">Courses</a></li>
                <li><a href="/">Chat</a></li>
                <li><a href="/">Contact</a></li>
                <li><a href="/" class="active">Profile</a></li>
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
            <li><a href="/">Courses</a></li>
            <li><a href="/">Chat</a></li>
            <li><a href="/">Contact</a></li>
            <li><a href="/prfile" class="active">Profile</a></li>
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

<main class="profile-main">
    <div class="container">
        <div class="profile-header">
            <h2 class="section-title">Student Profile</h2>
        </div>

        <div class="profile-content">
            <div class="profile-info-section">
                <div class="profile-card">
                    <div class="profile-image-container">
                        <img src="imgs/profile.png" alt="Student Profile" id="profileImage" class="profile-image">
                        <div class="image-upload" id="imageUpload" style="display: none;">
                            <input type="file" id="imageInput" accept="image/*">
                            <label for="imageInput" class="upload-label">Change Photo</label>
                        </div>
                    </div>

                    <div class="profile-details">
                        <div class="detail-group">
                            <label>Full Name:</label>
                            <span id="studentName">{{Auth::user()->name}}</span>
                            <input type="text" id="nameInput" value="{{Auth::user()->name}}" class="edit-input" style="display: none;">
                        </div>

                        <div class="detail-group">
                            <label>Email:</label>
                            <span id="studentEmail">{{Auth::user()->email}}</span>
                            <input type="email" id="emailInput" value="{{Auth::user()->email}}" class="edit-input" style="display: none;">
                        </div>

                        <div class="detail-group">
                            <label>Grade Level:</label>
                            <span>{{Auth::user()->student->grade}}</span>
                        </div>

                        <div class="detail-group">
                            <label>Student ID:</label>
                            <span>{{Auth::user()->student->id}}</span>
                        </div>
                    </div>

                    <div class="profile-actions" id="profileActions" style="display: none;">
                        <button class="save-btn" onclick="saveProfile()">Save Changes</button>
                        <button class="cancel-btn" onclick="cancelEdit()">Cancel</button>
                    </div>
                </div>
            </div>

            <div class="enrolled-courses-section">
                <h3 class="subsection-title">Enrolled Courses</h3>
                <div class="enrolled-courses-grid">
                    @foreach($finished as $course)
                        <div class="enrolled-course-card">
                            <div class="course-progress">
                                <div class="progress-bar">
                                    @php
                                        $percentage = $course['total'] > 0 ? ($course['finished'] / $course['total']) * 100 : 0;
                                    @endphp
                                    <div class="progress-fill" style="width: {{ $percentage }}%;"></div>
                                </div>
                                <span class="progress-text">{{ round($percentage) }}% Complete</span>
                            </div>

                            <h4>{{ $course['subject'] }}</h4>
                            <p>Instructor: {{ $course['instructor'] }}</p>

                            @if($course['finished'] == $course['total'])
                                <p class="course-status completed">Completed</p>
                            @else
                                <p class="course-status">In Progress</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="academic-stats-section">
                <h3 class="subsection-title">Academic Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">4</div>
                        <div class="stat-label">Level</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{Auth::user()->student->points}}</div>
                        <div class="stat-label">Points</div>
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

<script src="script.js"></script>
</body>
</html>
