<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Notifications</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/imgs/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="/styles.css" />
    <link rel="stylesheet" href="/admin-styles.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    @vite(['resources/js/app.js'])
</head>

<body class="notifications">
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
                    <li><a href="/admin/instructors">Instructors</a></li>
                    <li><a href="/admin/students">Students</a></li>
                    <li><a href="/admin/messages">Messages</a></li>
                    <li>
                        <a href="/admin/notifications" id="notifLink" class="active">
                            @if (App\Models\AdminNotification::where('is_read', false)->count() > 0)
                                <span class="notif-dot" id = "notif-dot">🔴</span>
                            @endif
                            Notifications
                        </a>
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
                <li><a href="/admin/home">Home</a></li>
                <li><a href="/admin/instructors">Instructors</a></li>
                <li><a href="/admin/students">Students</a></li>
                <li><a href="/admin/messages">Messages</a></li>
                <li>
                    <a href="/admin/notifications" id="notifLink" class="active">
                        @if (App\Models\AdminNotification::where('is_read', false)->count() > 0)
                            <span class="notif-dot" id = "notif-dot">🔴</span>
                        @endif
                        Notifications
                    </a>
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
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="admin-layout">
        <main class="admin-main-content">
            <h2 class="section-title">Notifications</h2>
            <section class="admin-section" style="    height: auto;">
                <div class="admin-section-header" id = "admin-section"
                    style="justify-content: space-between; align-items: center; display: flex;">
                    <h3>Recent Notifications</h3>
                    @if (!$unseen->isEmpty())
                        <form action="/read-all" method="POST">
                            @csrf
                            <button type="submit" class="btn" style="width: fit-content;" title="Read All">
                                Read All
                            </button>
                        </form>
                    @endif
                </div>
                <div class="widgets-not">
                    <ul class="widget new-notifications" id="newNoitifiactionList">
                        @if ($unseen->isEmpty())
                            <li class="no-notifications">There are no Notifications at this moment</li>
                        @endif
                        @foreach ($unseen as $u)
                            <li>
                                <div class="notification-list">
                                    <p>📢 <strong>{{ $u->title }}</strong></p>
                                    <div class="notification-actions">
                                        <form action="/read/{{ $u->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn read-btn" title="Read">Read</button>
                                        </form>
                                        <form action="/delete/{{ $u->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete" title="Delete"
                                                style="padding: 9px">
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @if (!$seen->isEmpty())
                        <ul class="widget read-notifications">
                            @foreach ($seen as $s)
                                <li>
                                    <div class="notification-list">
                                        <p>📢 <strong>{{ $s->title }}</strong></p>
                                        <div class="notification-actions">
                                            <form action="/delete/{{ $s->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type= "submit" class="btn btn-delete" title="Delete">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
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
                        <li><a href="/admin/messages">Messages</a></li>
                        <li><a href="/admin/notifications" class="active">Notifications</a></li>
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
                <p>© 2025 Th𝕆th Gate Admin. All rights reserved.</p>
            </div>
        </div>
    </footer>
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

                    let unseenList = document.getElementById('newNoitifiactionList');
                    if (unseenList) {
                        let noNotif = unseenList.querySelector('.no-notifications');
                        if (noNotif) {
                            noNotif.remove();
                        }
                        let main = document.getElementById('admin-section');
                        let button = main.querySelector('form');

                        if (!button) {
                            let csrf = document.querySelector('meta[name="csrf-token"]').content;

                            let form = document.createElement("form");
                            form.action = "/read-all";
                            form.method = "POST";
                            form.innerHTML = `
                                <input type="hidden" name="_token" value="${csrf}">
                                <button type="submit" class="btn" style="width: fit-content;" title="Read All">
                                    Read All
                                </button>
                            `;
                            main.appendChild(form);
                        }

                        let csrf = document.querySelector('meta[name="csrf-token"]').content;

                        let li = document.createElement("li");
                        li.innerHTML = `
                            <div class="notification-list">
                                <p>📢 <strong>${e.notification.title}</strong></p>
                                <div class="notification-actions">
                                    <form action="/read/${e.notification.id}" method="POST">
                                        <input type="hidden" name="_token" value="${csrf}">
                                        <button type="submit" class="btn read-btn" title="Read">Read</button>
                                    </form>
                                    <form action="/delete/${e.notification.id}" method="POST">
                                        <input type="hidden" name="_token" value="${csrf}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-delete" title="Delete" style="padding: 9px">Delete</button>
                                    </form>
                                </div>
                            </div>
                        `;
                        unseenList.prepend(li);
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
