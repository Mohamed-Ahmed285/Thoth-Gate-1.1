<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture Access Restricted</title>
    <link rel="stylesheet" href="/styles.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body class="courses-page">
    <header class="main-header">
        <div class="header-content">
            <div class="logo-container">
                <img src="/imgs/logo.png" alt="Thoth Gate Logo" class="logo-image">
                <h1 class="site-logo">Thoth Gate</h1>
            </div>
            <button class="hamburger-menu" id="hamburgerMenu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="main-nav">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/courses">Courses</a></li>
                    <li><a href="/community">Chat</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/profile">Profile</a></li>
                    <form method="POST" action="/logout" id = "logoutForm">
                        @csrf
                        @method('DELETE')
                        <a href="#" class="logout-btn"
                            onclick="document.getElementById('logoutForm').submit(); return false;">Logout</a>
                    </form>
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
                <li><a href="/courses">Courses</a></li>
                <li><a href="/community">Chat</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/profile">Profile</a></li>
                <form method="POST" action="/logout" id = "logoutForm">
                    @csrf
                    @method('DELETE')
                    <a href="#" class="logout-btn"
                        onclick="document.getElementById('logoutForm').submit(); return false;">Logout</a>
                </form>
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
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <main>
        <section class="courses-section">
            <div class="container">
                <h2 class="section-title">Buy Lecture</h2>
                <div class="restricted-access-container">
                    <!-- <img src="imgs/buy.png" alt="Logo" class="wrong-image" style="width: 185px;"> -->
                    <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision"
                        style="
    /* color: cornflowerblue; */
    width: 138px;
    fill: #d4af37;
    margin: 10px;
"
                        text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd"
                        clip-rule="evenodd" viewBox="0 0 512 477.221">
                        <path
                            d="M512 131.972v332.827l-25.275-29.088-6.586-7.576-48.31 48.31-49.421-48.048-48.46 46.515-50.713-46.827-47.724 49.136-49.099-49.105-50.178 47.766-47.721-48.199-32.245 37.137V108.133a13.8 13.8 0 01-.817.024h-41.04C6.453 108.157 0 101.704 0 93.746l.054-1.234-.012-3.829c-.109-22.461-.247-51.267 15.004-70.369 4.391-5.502 9.95-10.053 16.958-13.272C36.932 2.777 43.522 1.045 49.618.43c2.744-.275 5.698-.296 8.416-.296h289.315c21.142 0 26.285-.026 30.671-.049 63.224-.345 95.08-.519 114.317 18.236 10.207 9.95 15.238 23.689 17.565 43.684 2.041 17.541 2.098 40.02 2.098 69.967zM169.714 330.378v-17.29c-4.181-.581-8.009-1.351-11.469-2.303l-.081-.023c-21.624-5.989-32.341-23.087-33.915-44.734a1.72 1.72 0 011.414-1.81l18.76-3.626a1.716 1.716 0 012.005 1.362l.015.103c2.021 14.019 7.543 28.839 23.271 31.76v-55.671a90.811 90.811 0 01-10.632-3.673l-.078-.034c-3.981-1.652-7.999-3.623-12.037-5.893l-.093-.057c-13.124-7.311-19.43-20.713-19.43-35.417 0-6.897 1.235-13.168 3.689-18.796 7.262-16.639 21.434-23.398 38.581-25.398v-7.433c0-.947.77-1.717 1.717-1.717h11.101c.947 0 1.717.77 1.717 1.717v7.428c22.643 2.646 37.316 16.133 40.54 39.092a1.713 1.713 0 01-1.463 1.93l-19.183 2.98a1.711 1.711 0 01-1.951-1.426c-1.724-11.506-6.331-19.85-17.943-23.066v50.587c4.197 1.087 7.677 2.049 10.437 2.879 14.056 4.218 25.289 11.623 30.891 25.963l.029.084c4.23 10.984 3.989 24.596-.163 35.484-2.138 5.618-5.359 10.689-9.649 15.222-4.282 4.511-9.208 7.973-14.753 10.385-5.079 2.21-10.679 3.541-16.792 3.997v17.394c0 .947-.77 1.717-1.717 1.717h-11.101c-.947 0-1.717-.77-1.717-1.717zM137.907 57.126c7.758 0 14.045 6.287 14.045 14.045s-6.287 14.045-14.045 14.045c-7.755 0-14.045-6.287-14.045-14.045s6.29-14.045 14.045-14.045zm292.451 0c7.758 0 14.045 6.287 14.045 14.045s-6.287 14.045-14.045 14.045c-7.755 0-14.042-6.287-14.042-14.045s6.287-14.045 14.042-14.045zm-73.111 0c7.755 0 14.045 6.287 14.045 14.045s-6.29 14.045-14.045 14.045c-7.758 0-14.045-6.287-14.045-14.045s6.287-14.045 14.045-14.045zm-73.111 0c7.754 0 14.042 6.287 14.042 14.045s-6.288 14.045-14.042 14.045c-7.758 0-14.046-6.287-14.046-14.045s6.288-14.045 14.046-14.045zm-73.112 0c7.755 0 14.045 6.287 14.045 14.045s-6.29 14.045-14.045 14.045c-7.758 0-14.045-6.287-14.045-14.045s6.287-14.045 14.045-14.045zm231.655 142.301a7.721 7.721 0 010 15.443H271.815a7.721 7.721 0 010-15.443h170.864zm-49.416 115.059a7.722 7.722 0 010 15.443H271.815a7.721 7.721 0 010-15.443h121.448zm49.416-172.593a7.722 7.722 0 010 15.443H271.815a7.721 7.721 0 010-15.443h170.864zm-.457 115.062a7.722 7.722 0 010 15.443H271.815a7.721 7.721 0 010-15.443h170.407zm-272.508-88.909c-8.409 1.75-15.505 6.855-18.589 15.077-.973 2.591-1.46 5.411-1.46 8.455 0 5.997 1.649 11.006 4.941 14.99l.062.077c1.623 1.948 3.844 3.683 6.642 5.193 2.389 1.286 5.19 2.409 8.404 3.359v-47.151zm14.535 125.75c2.695-.506 5.187-1.359 7.47-2.56 2.825-1.486 5.361-3.512 7.599-6.069 7.556-8.637 9.579-25.047 2.026-34.33-1.535-1.87-3.877-3.593-7.013-5.159-2.778-1.385-6.14-2.638-10.082-3.758v51.876zM55.451 14.573v79.173h-41.04c0-20.775-1.29-49.967 11.895-66.482 6.097-7.638 15.295-12.566 29.145-12.691zM480.85 407.048l16.74 19.263V131.972c0-59.118-.21-88.663-15.272-103.348-17.453-17.015-54.849-14.079-134.969-14.079H70.678v411.766l17.147-19.746 48.705 49.19 50.155-47.742 48.704 48.707 47.307-48.707 51.07 47.153 48.707-46.749 49.187 47.821 49.19-49.19z" />
                    </svg>
                    <div class="restricted-access-title">Buy now</div>
                    <div class="restricted-access-message">You have not purchased this lecture</div>
                    <div class="restricted-access-message">
                        Price
                        @if ($lecture->course->grade === '3prep')
                            50
                        @else
                            70
                        @endif
                        EGP.
                    </div>
                    <!-- <div class="restricted-access-message">Contact Us.</div> -->
                    <div class="restricted-btn-group">
                        <button class="restricted-btn" onclick="history.back();">Go Back</button>
                        <a href="https://web.whatsapp.com/" target="_blank" class="restricted-btn"
                            style="display: flex;flex-wrap: nowrap;width: -webkit-fill-available;flex-direction: row;align-items: center;justify-content: space-evenly;">Contact
                            Us to Buy
                            <i class="fa fa-whatsapp" aria-hidden="true"></i>
                        </a>
                    </div>
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
