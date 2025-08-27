@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thoth Gate - Grade Chat</title>
    <meta name="user-id" content="{{ Auth::id() }}">
    <link rel="icon" href="/imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/styles.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>
<body class="chat-page">
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
                <li><a href="/courses">Courses</a></li>
                <li><a href="/community" class="active">Chat</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/profile">Profile</a></li>
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
            <li><a href="/courses">Courses</a></li>
            <li><a href="/community" class="active">Chat</a></li>
            <li><a href="/contact">Contact</a></li>
            <li><a href="/profile">Profile</a></li>
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

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<main class="chat-main">
    <div class="container">
        <!-- Header -->
        <div class="chat-header">
            <h2 class="section-title">Grade Chat</h2>
            <div class="grade-info">
                <span class="grade-badge" id="gradeBadge">{{$fullCommunity->grade}}</span>
                <span class="online-count">Online: <span id="onlineCount">0</span></span>
            </div>
        </div>

        <!-- Layout: left = chat, right = sidebar -->
        <div class="chat-container">
            <!-- LEFT COLUMN: messages + input -->
            <section class="chat-column">
                <div class="chat-messages" id="chatMessages">
                    @foreach($messages as $message)
                        <div class="message {{($message->user_id === Auth::id() ? 'user-message' : (Auth::user()->type === 2 ? 'system-message' : 'other-message'))}}">
                            <div class="message-avatar">
                                <img src="/imgs/profile.png" alt="Student">
                            </div>
                            <div class="message-content">
                                <div class="message-header">
                                    <span class="message-author">{{($message->user->type == 1 ? 'Mr.' : '').$message->user->name}}</span>
                                    <span class="message-time">{{ $message->created_at->format('h:i A') }}</span>
                                </div>
                                <p>{{$message->message}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Composer (sticky at viewport bottom) -->
                <div class="chat-input-container sticky-composer" style="margin-top: 16px;">
                    <form id="chatForm" class="chat-form">
                        <div class="input-group">
                            <input type="hidden" name="community_id" value="{{$fullCommunity->id}}">
                            <input type="text" name="message" id="messageInput" placeholder="Type your message." maxlength="500" required autocomplete="off">
                            <button type="submit" class="send-btn"><span class="send-icon">📤</span></button>
                        </div>
                        <div class="message-actions">
                            <span class="char-count">0/500</span>
                            <button type="button" class="emoji-btn" id="emojiBtn">😊</button>
                        </div>
                    </form>
                </div>
                <button class="scroll-button" id="scrollBtn" style="display: none;">
                    ↓
                </button>
            </section>

            <!-- RIGHT COLUMN: sidebar (now inside the grid) -->
            <aside class="chat-sidebar">
                <div class="sidebar-section">
                    <h3>Chat Rules</h3>
                    <ul class="chat-rules">
                        <li>Be respectful to all members</li>
                        <li>No inappropriate content</li>
                        <li>Stay on topic - academic discussions</li>
                        <li>Use appropriate language</li>
                        <li>Report any violations</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</main>

<script>

    window.addEventListener('DOMContentLoaded', () => {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    const chatForm = document.getElementById('chatForm');
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const scrollBtn = document.getElementById('scrollBtn');

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        const community_id = chatForm.querySelector('input[name="community_id"]').value;
        messageInput.value = '';

        try {
            await fetch('/community', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ message, community_id })
            });
        } catch (err) {
            console.error(err);
        }
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    window.addEventListener('DOMContentLoaded', () => {
    const chatMessages = document.getElementById('chatMessages');
    const scrollBtn = document.getElementById('scrollBtn');

    chatMessages.scrollTop = chatMessages.scrollHeight;

        window.Echo.channel('MessageChannel')
            .listen('.App\\Events\\MessageEvent', (e) => {
                const msg = e.message;

                // Check if user is near the bottom BEFORE adding the new message
                const nearBottom = chatMessages.scrollHeight - chatMessages.scrollTop - chatMessages.clientHeight < 50;

                const div = document.createElement('div');
                div.className = msg.user.id === parseInt(document.querySelector('meta[name="user-id"]')?.content)
                    ? 'message user-message'
                    : 'message other-message';

                div.innerHTML = `
                    <div class="message-avatar">
                        <img src="/imgs/profile.png" alt="User">
                    </div>
                    <div class="message-content">
                        <div class="message-header">
                            <span class="message-author">${msg.user.type === 1 ? 'Mr.' : ''}${msg.user.name}</span>
                            <span class="message-time">${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                        </div>
                        <p>${msg.message}</p>
                    </div>
                `;

                chatMessages.appendChild(div);

                // Only scroll if user was near the bottom
                if (nearBottom) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            });


        chatMessages.addEventListener('scroll', () => {
        if (chatMessages.scrollTop + chatMessages.clientHeight < chatMessages.scrollHeight - 50) {
            scrollBtn.style.display = 'block';
        } else {
            scrollBtn.style.display = 'none';
        }
    });

    scrollBtn.addEventListener('click', () => {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });
});
</script>

<script src="/script.js"></script>
</body>
</html>
