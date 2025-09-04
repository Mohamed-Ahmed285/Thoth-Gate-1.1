<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam</title>
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/instructor.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="/imgs/logo.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap"
        rel="stylesheet">

</head>

<body class="instructor-home">
    <header class="main-header">
        <div class="header-content">
            <div class="logo-container">
                <img src="/imgs/logo.png" alt="Th𝕆th Gate Logo" class="logo-image">
                <h1 class="site-logo">Th𝕆th Gate</h1>
            </div>
            <button class="hamburger-menu" id="hamburgerMenu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="main-nav">
                <ul>
                    <li><a href="/instructor/home">Home</a></li>
                    <li><a href="/instructor/create/exam" class="active">Create Exam</a></li>
                    <li><a href="/instructor/add/lecture">Add Lecture</a></li>
                    <li><a href="/instructor/chats">Chats</a></li>
                    <li>
                        <form method="POST" action="/logout" id="logoutForm">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="logout-btn"
                                onclick="document.getElementById('logoutForm').submit(); return false;">Logout</a>
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
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="/imgs/logo.png" alt="Th𝕆th Gate Logo" class="logo-image">
                <h1 class="site-logo">Th𝕆th Gate</h1>
            </div>
            <button class="close-sidebar" id="closeSidebar">
                <span></span>
                <span></span>
            </button>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li><a href="/instructor/home">Home</a></li>
                <li><a href="/instructor/create/exam" class="active">Create Exam</a></li>
                <li><a href="/instructor/add/lecture">Add Lecture</a></li>
                <li><a href="/instructor/chats">Chats</a></li>
                <li>
                    <form method="POST" action="/logout" id="logoutForm">
                        @csrf
                        @method('DELETE')
                        <a href="#" class="logout-btn"
                            onclick="document.getElementById('logoutForm').submit(); return false;">Logout</a>
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


    <main class="exam-main">
        @if (session('success'))
            <div class="message success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="message error">
                <ul style="margin:0; padding-left:1.2rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container">
            <div class="exam-header" style="margin-bottom:2rem;text-align:center;">
                <h1 class="section-title">Create Exam</h1>
                <p class="section-des">Build your exam by adding questions and choices for your students.</p>
            </div>
            <form id="createExamForm" class="createExamForm" style="max-width:700px;margin:0 auto;" method="POST"
                action="/instructor/create/exam">
                @csrf
                <div class="exam-form-row" style="display:flex;gap:2rem;flex-wrap:wrap;justify-content:center;">
                    <div class="form-group" style="flex:1;min-width:220px;">
                        <label for="exam-title">Exam Title</label>
                        <input type="text" id="exam-title" name="exam-title" required>
                    </div>

                    <div class="form-group" style="flex:1;min-width:220px;">
                        <label for="exam-duration">Exam Duration (in minutes)</label>
                        <input type="text" id="exam-duration" name="exam-duration" required>
                    </div>

                </div>
                <div class="exam-questions-area" style="margin-top:2.5rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                        <h2 class="questions-tag">Questions</h2>
                    </div>
                    <div id="questions-list"></div>
                </div>

                <div class="btns-questions">

                    <button type="submit" class="exam-btn">Create Exam</button>
                    <button type="button" id="add-question-btn" class="exam-btn">
                        <i class="fas fa-plus"></i>
                        Add Question</button>

                </div>
            </form>
        </div>
    </main>
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Th𝕆th Gate</h3>
                    <p>Gateway to Ancient Wisdom, Modern Learning</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="/instructor/home">Home</a></li>
                        <li><a href="/instructor/add/lecture">Add Lecture</a></li>
                        <li><a href="/instructor/create/exam">Create Exam</a></li>
                        <li><a href="/instructor/chats">Chats</a></li>

                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p>Email: info@thuthgate.edu.eg</p>
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
                <p>&copy; 2025 Th𝕆th Gate Learning Center. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="/script.js"></script>
    <script src="/instructor.js"></script>
</body>

</html>
