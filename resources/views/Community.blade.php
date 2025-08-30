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
<section class="chat-column">
    <button class="scroll-button" id="scrollBtn" style="display: none;">
        ↓
    </button>
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
                @if($message->message)
                    <p>{{$message->message}}</p>
                @endif
                @if($message->image)
                    <img src="{{ asset($message->image) }}" alt="Community Image" style="max-width: 100%; height: auto; margin-top: 8px;">
                @endif
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="chat-input-container sticky-composer" style="margin-top: 16px;">
        <div id="imagePreview" class="preview-container" style="margin: 10px; display:flex; gap:10px; flex-wrap:wrap;"></div>
        <form id="chatForm" class="chat-form" enctype="multipart/form-data">
            <div class="input-group">
                <input type="hidden" name="community_id" value="{{$fullCommunity->id}}">
                <input type="text" name="message" id="messageInput" placeholder="Type your message." maxlength="500" autocomplete="off">
                <button type="submit" class="send-btn"><span class="send-icon" id = "send-span">📤</span></button>
                <input type="file" id="imageIn" name="image" accept="image/*" style="display: none;">
                <button type = "button" onclick="document.getElementById('imageIn').click()" class="image-btn"><span>🔗</span></button>
            </div>
        </form>
    </div>
</section>
<script>
    const imageInput = document.getElementById('imageIn');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', () => {
        imagePreview.innerHTML = "";

        const files = imageInput.files;
        if (!files.length) return;

        Array.from(files).forEach(file => {
            if (!file.type.startsWith("image/")) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.maxWidth = "200px";
                img.style.maxHeight = "150px";
                img.style.borderRadius = "8px";
                img.style.objectFit = "cover";
                imagePreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    const chatForm = document.getElementById('chatForm');
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const scrollBtn = document.getElementById('scrollBtn');
    let icon = document.getElementById('send-span');
    let sendbtn = document.querySelector('.send-btn');

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(chatForm);
        const message = messageInput.value.trim();
        const image = document.getElementById('imageIn').files[0];

        if (!message && !image) return;

        icon.textContent = '⏳';
        sendbtn.disabled = true;
        messageInput.value = '';
        imagePreview.innerHTML = '';
        document.getElementById('imageIn').value = ''; // reset file input

        try {
            await fetch('/community', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            });
        } catch (err) {
            console.error(err);
        }
        chatMessages.scrollTop = chatMessages.scrollHeight;
        icon.textContent = '📤';
        sendbtn.disabled = false;
    });


    window.addEventListener('DOMContentLoaded', () => {
    const chatMessages = document.getElementById('chatMessages');
    const scrollBtn = document.getElementById('scrollBtn');

    chatMessages.scrollTop = chatMessages.scrollHeight;

    window.Echo.channel('MessageChannel')
        .listen('.App\\Events\\MessageEvent', (e) => {
            const msg = e.message;
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
                    ${msg.message ? `<p>${msg.message}</p>` : ''}
                    ${msg.image ? `<img src="/${msg.image}" alt="Image" style="max-width:100%; margin-top:8px;">` : ''}
                </div>
            `;

            chatMessages.appendChild(div);

            if (chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight - 10) {
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