<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Students</title>
        <link rel="icon" href="../imgs/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/admin-styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <div class="logo-container">
                <img src="../imgs/logo.png" alt="Th𝕆th Gate Logo" class="logo-image">
                <h1 class="site-logo">Th𝕆th Gate</h1>
            </div>
             <button class="hamburger-menu" id="hamburgerMenu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="main-nav">
                <ul>
                    <!-- <li><a href="../home.html">Main Site</a></li> -->
                    <li><a href="/admin/home">Dashboard</a></li>
                    <li><a href="/admin/instructors">Instructors</a></li>
                    <li><a href="/admin/students" class="active">Students</a></li>
                    <li><a href="/admin/messages">Messages</a></li>
                    <li><a href="/admin/notifications" id="notifLink">
                        @if (App\Models\AdminNotification::where('is_read' , false)->count() > 0)
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
                <img src="../imgs/logo.png" alt="Th𝕆th Gate Logo" class="logo-image">
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
                <li><a href="/admin/students" class="active">Students</a></li>
                <li><a href="/admin/messages">Messages</a></li>
                <li><a href="/admin/notifications" id="notifLink">
                    @if (App\Models\AdminNotification::where('is_read' , false)->count() > 0)
                        <span class="notif-dot" id = "notif-dot">🔴</span>
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
            @if (session('success'))
                <div class="message success">
                    {{ session('success') }}
                </div>
            @endif
            <section class="admin-section">
                <div class="admin-section-header">
                    <h2 class="section-title">Students</h2>
                    <input type="text" id="studentSearch" class="search-bar" placeholder="Search students...">
                </div>
                <div class="admin-table-responsive">
                       <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTableBody">

                        @foreach ($students as $std)
                            <tr>
                                <td>{{$std->id}}</td>
                                <td>{{$std->user->name}}</td>
                                <td>{{$std->user->email}}</td>
                                <td>{{$std->grade}}</td>
                                <td class="btns-td">
                                    <div style="display: flex; gap: 1rem; justify-content: center; align-items: center;">
                                        <button class="btn btn-view" onclick="  window.location.href = '/admin/students/{{$std->id}}';">View</button>
                                        <form action="/admin/students/{{$std->id}}" method="POST" onsubmit="return confirm('Are you sure you want to remove this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-remove">Remove</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <!-- More rows as needed -->
                    </tbody>
                </table>
                </div>
                <div>
                    {{ $students->links('vendor.pagination.custom') }}
                </div>
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
    window.allStudents = @json($allStudents);

    document.getElementById("studentSearch").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase().trim();
        let tbody = document.getElementById("studentsTableBody");

        tbody.innerHTML = ""; 

        let filtered = window.allStudents.filter(std => {
            return (
                std.id.toString().includes(filter) ||
                std.user.name.toLowerCase().includes(filter) ||
                std.user.email.toLowerCase().includes(filter) ||
                std.grade.toLowerCase().includes(filter)
            );
        });

        filtered.forEach(std => {
            let row = `
                <tr>
                    <td>${std.id}</td>
                    <td>${std.user.name}</td>
                    <td>${std.user.email}</td>
                    <td>${std.grade}</td>
                    <td class="btns-td">
                        <div style="display: flex; gap: 1rem; justify-content: center; align-items: center;">
                            <button class="btn btn-view" onclick="window.location.href = '/admin/students/${std.id}';">View</button>
                            <form action="/admin/students/${std.id}" method="POST" onsubmit="return confirm('Are you sure you want to remove this student?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-remove">Remove</button>
                            </form>
                        </div>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML("beforeend", row);
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