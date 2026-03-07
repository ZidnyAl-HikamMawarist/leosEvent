<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login — Leo's Competition</title>
    <meta name="description" content="Masuk ke panel Leo's Competition untuk mengelola event dan kompetisi.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Prevent flash: apply theme before render -->
    <script>
        (function () {
            const saved = localStorage.getItem('login-theme');
            if (saved) {
                document.documentElement.setAttribute('data-theme', saved);
            } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

    <style>
        /* ===== CSS VARIABLES — LIGHT (DEFAULT) ===== */
        :root,
        [data-theme="light"] {
            --bg-page: #f4f6f9;
            --bg-card: #ffffff;
            --bg-input: #f8f9fb;
            --border-color: #e2e6ed;
            --border-focus: #4f6ef7;
            --focus-ring: rgba(79, 110, 247, 0.18);
            --text-primary: #1a1d26;
            --text-secondary: #6b7280;
            --text-placeholder: #9ca3af;
            --accent: #4f6ef7;
            --accent-hover: #3b5de7;
            --accent-subtle: rgba(79, 110, 247, 0.08);
            --btn-text: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.04);
            --shadow-card: 0 4px 24px rgba(0, 0, 0, 0.06);
            --shadow-card-hover: 0 8px 32px rgba(0, 0, 0, 0.08);
            --shadow-btn: 0 4px 14px rgba(79, 110, 247, 0.3);
            --shadow-btn-hover: 0 6px 22px rgba(79, 110, 247, 0.4);
            --dot-color: rgba(0, 0, 0, 0.04);
            --toggle-bg: #e8eaef;
            --toggle-hover: #d5d8e0;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        /* ===== DARK MODE ===== */
        [data-theme="dark"] {
            --bg-page: #111218;
            --bg-card: #1a1b23;
            --bg-input: #22232e;
            --border-color: #2e3040;
            --border-focus: #6384ff;
            --focus-ring: rgba(99, 132, 255, 0.2);
            --text-primary: #f0f1f5;
            --text-secondary: #8b8fa4;
            --text-placeholder: #555869;
            --accent: #6384ff;
            --accent-hover: #7a97ff;
            --accent-subtle: rgba(99, 132, 255, 0.1);
            --btn-text: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.2);
            --shadow-card: 0 4px 24px rgba(0, 0, 0, 0.3);
            --shadow-card-hover: 0 8px 32px rgba(0, 0, 0, 0.4);
            --shadow-btn: 0 4px 14px rgba(99, 132, 255, 0.25);
            --shadow-btn-hover: 0 6px 22px rgba(99, 132, 255, 0.35);
            --dot-color: rgba(255, 255, 255, 0.03);
            --toggle-bg: #2a2c38;
            --toggle-hover: #363849;
        }

        /* ===== RESET & BASE ===== */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            background: var(--bg-page);
            color: var(--text-primary);
            font-family: var(--font);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            transition: background 0.35s ease, color 0.35s ease;
        }

        /* ===== SUBTLE DOT PATTERN ===== */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(var(--dot-color) 1px, transparent 1px);
            background-size: 24px 24px;
            z-index: 0;
            pointer-events: none;
            transition: background-image 0.35s ease;
        }

        /* ===== THEME TOGGLE ===== */
        .theme-toggle {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 10;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: var(--toggle-bg);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            transition: all 0.3s ease;
            animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0.15s;
            opacity: 0;
        }

        .theme-toggle:hover {
            background: var(--toggle-hover);
            transform: scale(1.08);
            border-color: var(--accent);
            color: var(--accent);
        }

        .theme-toggle:active {
            transform: scale(0.95);
        }

        .theme-toggle .icon-sun,
        .theme-toggle .icon-moon {
            position: absolute;
            transition: opacity 0.25s ease, transform 0.35s ease;
        }

        /* Light mode: show moon icon (click to go dark) */
        [data-theme="light"] .theme-toggle .icon-moon {
            opacity: 1;
            transform: rotate(0deg);
        }

        [data-theme="light"] .theme-toggle .icon-sun {
            opacity: 0;
            transform: rotate(-90deg);
        }

        /* Dark mode: show sun icon (click to go light) */
        [data-theme="dark"] .theme-toggle .icon-sun {
            opacity: 1;
            transform: rotate(0deg);
        }

        [data-theme="dark"] .theme-toggle .icon-moon {
            opacity: 0;
            transform: rotate(90deg);
        }

        /* ===== MAIN CONTAINER ===== */
        .auth-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 1.5rem;
            animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== BRANDING ===== */
        .auth-brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-brand h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.04em;
            margin: 0;
            line-height: 1.2;
            transition: color 0.35s ease;
        }

        .auth-brand p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-top: 0.4rem;
            font-weight: 400;
            transition: color 0.35s ease;
        }

        /* ===== CARD ===== */
        .auth-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem 1.75rem;
            box-shadow: var(--shadow-card);
            transition: box-shadow 0.4s ease, border-color 0.4s ease, background 0.35s ease;
        }

        .auth-card:hover {
            box-shadow: var(--shadow-card-hover);
        }

        /* ===== SESSION STATUS / ERRORS ===== */
        .auth-status {
            background: var(--accent-subtle);
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 0.7rem 1rem;
            border-radius: 10px;
            font-size: 0.84rem;
            margin-bottom: 1.25rem;
            font-weight: 500;
        }

        .auth-error {
            color: #ef4444;
            font-size: 0.78rem;
            margin-top: 0.4rem;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }

        .auth-error i {
            font-size: 0.72rem;
        }

        /* ===== FORM GROUPS (FLOATING LABEL) ===== */
        .form-floating-group {
            position: relative;
            margin-bottom: 1.15rem;
        }

        .form-floating-group input {
            width: 100%;
            padding: 0.95rem 1rem 0.55rem 1rem;
            background: var(--bg-input);
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            font-family: var(--font);
            font-size: 0.92rem;
            outline: none;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease, color 0.25s ease;
            -webkit-appearance: none;
        }

        .form-floating-group input::placeholder {
            color: transparent;
        }

        .form-floating-group label {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-placeholder);
            font-size: 0.88rem;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            background: transparent;
            padding: 0 3px;
        }

        /* Float up on focus or filled */
        .form-floating-group input:focus~label,
        .form-floating-group input:not(:placeholder-shown)~label {
            top: 0;
            transform: translateY(-50%);
            font-size: 0.7rem;
            color: var(--accent);
            letter-spacing: 0.3px;
            font-weight: 600;
            background: var(--bg-card);
        }

        .form-floating-group input:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3.5px var(--focus-ring);
            background: var(--bg-card);
        }

        /* Password wrapper */
        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-placeholder);
            cursor: pointer;
            font-size: 1.05rem;
            padding: 4px;
            transition: color 0.2s ease;
            z-index: 2;
            line-height: 1;
        }

        .password-toggle:hover {
            color: var(--accent);
        }

        .password-wrapper input {
            padding-right: 2.8rem;
        }

        /* ===== REMEMBER & FORGOT ===== */
        .auth-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            margin-top: 0.25rem;
        }

        .remember-check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1.5px solid var(--border-color);
            background: var(--bg-input);
            cursor: pointer;
            accent-color: var(--accent);
            transition: all 0.2s ease;
        }

        .remember-check span {
            color: var(--text-secondary);
            font-size: 0.84rem;
            user-select: none;
            transition: color 0.35s ease;
        }

        .forgot-link {
            color: var(--accent);
            font-size: 0.84rem;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--accent-hover);
            text-decoration: underline;
        }

        /* ===== SUBMIT BUTTON ===== */
        .btn-auth {
            width: 100%;
            padding: 0.85rem;
            background: var(--accent);
            border: none;
            border-radius: 10px;
            color: var(--btn-text);
            font-family: var(--font);
            font-size: 0.92rem;
            font-weight: 700;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: var(--shadow-btn);
        }

        .btn-auth:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-btn-hover);
        }

        .btn-auth:active {
            transform: translateY(0) scale(0.99);
        }

        .btn-auth .btn-text {
            transition: opacity 0.2s ease;
        }

        .btn-auth .btn-loader {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .btn-auth.loading .btn-text {
            opacity: 0;
        }

        .btn-auth.loading .btn-loader {
            opacity: 1;
        }

        .btn-auth.loading {
            pointer-events: none;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2.5px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.65s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ===== FOOTER ===== */
        .auth-footer {
            text-align: center;
            margin-top: 1.75rem;
        }

        .auth-footer a {
            color: var(--text-secondary);
            font-size: 0.82rem;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .auth-footer a:hover {
            color: var(--accent);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .auth-wrapper {
                padding: 1rem;
            }

            .auth-card {
                padding: 1.5rem 1.25rem;
                border-radius: 14px;
            }

            .auth-brand h1 {
                font-size: 1.3rem;
            }

            .theme-toggle {
                top: 0.85rem;
                right: 0.85rem;
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode" title="Ganti mode terang/gelap">
        <i class="bi bi-sun-fill icon-sun"></i>
        <i class="bi bi-moon-fill icon-moon"></i>
    </button>

    <div class="auth-wrapper">
        {{ $slot }}
    </div>

    <!-- Theme Toggle Script -->
    <script>
        (function () {
            const toggle = document.getElementById('themeToggle');
            const html = document.documentElement;

            function getTheme() {
                return html.getAttribute('data-theme') || 'light';
            }

            toggle.addEventListener('click', function () {
                const next = getTheme() === 'light' ? 'dark' : 'light';
                html.setAttribute('data-theme', next);
                localStorage.setItem('login-theme', next);
            });
        })();
    </script>

</body>

</html>