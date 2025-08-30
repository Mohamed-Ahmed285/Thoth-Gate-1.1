<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thoth Gate - Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="/imgs/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="login-page">

<div class="login-container">
    <div class="login-header">
        @if (session('error'))
            <div class="message error" style="margin-bottom: 15px">
                {{ session('error') }}
            </div>
        @endif
        <div class="logo-container">
            <img src="imgs/logo.png" alt="Thoth Gate Logo" class="logo-image">
            <h1 class="site-logo">Thoth Gate</h1>
        </div>
        <p class="tagline">Gateway to Ancient Wisdom, Modern Learning</p>

        <div class="switchers-container">
            <button class="theme-switcher" id="themeSwitcher" title="Toggle Dark Mode">
                <span class="theme-icon">🌙</span>
            </button>
            <button class="language-switcher" id="languageSwitcher" title="Switch Language">
                <span class="language-text">EN</span>
            </button>
        </div>
    </div>

    <div class="login-form-container">
        <form class="login-form" action="/login" method="post">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                @if($errors->any())
                    <span class="message error">{{ $errors->first() }}</span>
                @endif
            </div>

            <button type="submit" class="login-btn">Enter the Gate</button>
        </form>

        <div class="login-footer">
            <p>New to Thoth Gate? <a href="/register" class="register-link">Register Here</a></p>
        </div>
    </div>
</div>

<div class="hieroglyph-bg"></div>

<script src="script.js"></script>
</body>
</html>
