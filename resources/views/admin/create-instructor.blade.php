<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Instructor</title>
    <link rel="icon" href="/imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/admin-styles.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
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
                    <li><a href="/admin/home">Dashboard</a></li>
                    <li><a href="/admin/instructors" class="active">Instructors</a></li>
                    <li><a href="/admin/students">Students</a></li>
                    <li><a href="/admin/messages">Messages</a></li>
                    <li><a href="/admin/notifications" id="notifLink">
                            @if (App\Models\AdminNotification::where('is_read', false)->count() > 0)
                                <span class="notif-dot" id = "notif-dot">🔴</span>
                            @endif
                            Notifications
                        </a></li>
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
                <li><a href="/admin/home">Home</a></li>
                <li><a href="/admin/instructors">Instructors</a></li>
                <li><a href="/admin/students">Students</a></li>
                <li><a href="/admin/messages" class="active">Messages</a></li>
                <li><a href="/admin/notifications" id="notifLink">
                        @if (App\Models\AdminNotification::where('is_read', false)->count() > 0)
                            <span class="notif-dot" id = "  ">🔴</span>
                        @endif
                        Notifications
                    </a></li>
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
    <div class="admin-layout">
        <main class="admin-main-content">
            <section class="admin-section" style="max-width:500px;margin:auto;">
                <div class="admin-section-header-add">
                    <h2 class="section-title">Add Instructor</h2>
                    <a href="/admin/instructors" class="btn add-btn">Back to Instructors</a>
                </div>
                <form class="add-instructor-form" method="POST" action="/admin/instructors/create"
                    onsubmit="return confirm('Are you sure you want to add this instructor?');">
                    @csrf
                    <div class="form-group">
                        <label for="instructorName">Name</label>
                        <input type="text" id="instructorName" name="instructorName"
                            value="{{ old('instructorName') }}" required>
                    </div>
                    @error('instructorName')
                        <div class="message error">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="instructorPhone">Phone number</label>
                        <input type="text" id="instructorPhone" name="instructorPhone"
                            value="{{ old('instructorPhone') }}" required>
                    </div>

                    @error('instructorPhone')
                        <div class="message error">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="instructorEmail">Email</label>
                        <input type="email" id="instructorEmail" name="instructorEmail"
                            value="{{ old('instructorEmail') }}" required>
                    </div>

                    @error('instructorEmail')
                        <div class="message error">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="instructorPassword">Password</label>
                        <input type="password" id="instructorPassword" name="instructorPassword" required>
                    </div>

                    @error('instructorPassword')
                        <div class="message error">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="dateOfBirth">Date of Birth</label>
                        <input type="date" id="dateOfBirth" name="dateOfBirth" required
                            value="{{ old('dateOfBirth') }}">
                        @error('dateOfBirth')
                            <span class="error message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="instructorCourse"><strong>First Course</strong></label>
                        <select id="instructorCourse" name="instructorCourse" required>
                            <option value="">-- Select Course --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->subject }} , {{ $course->grade }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="instructorCourse2"><strong>Second Course</strong> (not required)</label>
                        <select id="instructorCourse2" name="instructorCourse2">
                            <option value="">-- Select Course --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->subject }} , {{ $course->grade }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    @error('instructorCourse')
                        <div class="message error">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-edit">Add Instructor</button>
                </form>
            </section>
        </main>
    </div>
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Th𝕆th Gate Admin</h3>
                    <p>Gateway to Ancient Wisdom, Modern Learning</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="/admin/home">Dashboard</a></li>
                        <li><a href="/admin/instructors">Instructors</a></li>
                        <li><a href="/admin/students">Students</a></li>
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
                <p>&copy; 2025 Th𝕆th Gate Admin. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        const firstSelect = document.getElementById('instructorCourse');
        const secondSelect = document.getElementById('instructorCourse2');

        const secondOptions = Array.from(secondSelect.options);

        firstSelect.addEventListener('change', function() {
            const selectedValue = this.value;

            secondSelect.innerHTML = '';

            const defaultOption = secondOptions.find(option => option.value === "");
            if (defaultOption) {
                secondSelect.appendChild(defaultOption.cloneNode(true));
            }

            if (selectedValue === "") {
                secondOptions.forEach(option => {
                    if (option.value !== "") {
                        secondSelect.appendChild(option.cloneNode(true));
                    }
                });
                return;
            }

            secondOptions.forEach(option => {
                if (option.value !== "" && option.value !== selectedValue) {
                    secondSelect.appendChild(option.cloneNode(true));
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.Echo.channel('admin.notifications')
                .listen('AdminNotificationEvent', (e) => {
                    let toast = document.getElementById("toast");
                    toast.textContent = "📢 New Notification Received!";
                    toast.classList.add("show");

                    let notifLink = document.getElementById("notifLink");
                    if (!document.getElementById("notif-dot")) {
                        let dot = document.createElement("span");
                        dot.id = "notif-dot";
                        dot.className = "notif-dot";
                        dot.textContent = "🔴";
                        notifLink.insertBefore(dot, notifLink.childNodes[0]);
                    }

                    setTimeout(() => {
                        toast.classList.remove("show");
                    }, 2000);
                });

        });
    </script>

    <script src="/admin.js"></script>
    <script src="/script.js"></script>
    <div id="toast" class="toast"></div>

</body>

</html>
