<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $setting = \App\Models\Setting::first();
        $namaEvent = $setting->nama_event ?? "Leo's Competition";
        $primaryColor = $setting->primary_color ?? '#18181b';
        $bgHex = $setting->background_color ?? '#090a0f';
    @endphp

    <title>Masuk — {{ $namaEvent }}</title>
    <meta name="description" content="Masuk ke panel {{ $namaEvent }}.">

    <!-- Fonts: Inter / Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: {{ $primaryColor }};
            --font: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            
            /* Minimalist Studio Dark Palette (Apple / Linear aesthetic) */
            --bg-page: #090a0f;
            --surface-card: rgba(18, 20, 29, 0.7);
            --surface-card-border: rgba(255, 255, 255, 0.08);
            --surface-input: rgba(255, 255, 255, 0.03);
            --surface-input-border: rgba(255, 255, 255, 0.1);
            --surface-input-focus: rgba(255, 255, 255, 0.06);
            --text-heading: #f8fafc;
            --text-body: #94a3b8;
            --text-muted: #64748b;
            --accent-btn: {{ $primaryColor }};
            --accent-btn-text: #ffffff;
            --focus-ring: color-mix(in srgb, var(--primary) 40%, transparent);
        }

        /* Light mode check if user explicitly uses light background */
        @media (prefers-color-scheme: light) {
            :root {
                --bg-page: #f8fafc;
                --surface-card: #ffffff;
                --surface-card-border: #e2e8f0;
                --surface-input: #f8fafc;
                --surface-input-border: #e2e8f0;
                --surface-input-focus: #ffffff;
                --text-heading: #0f172a;
                --text-body: #475569;
                --text-muted: #94a3b8;
            }
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-body);
            font-family: var(--font);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Single Quiet Studio Spotlight */
        .studio-spotlight {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 700px;
            height: 400px;
            background: radial-gradient(50% 50% at 50% 0%, color-mix(in srgb, var(--primary) 22%, transparent) 0%, transparent 100%);
            pointer-events: none;
            z-index: 0;
            opacity: 0.85;
        }

        /* Main Container */
        .auth-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Minimal Header */
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo {
            width: 48px;
            height: 48px;
            margin: 0 auto 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--surface-card);
            border: 1px solid var(--surface-card-border);
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 8px;
        }

        .auth-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .auth-logo i {
            font-size: 1.35rem;
            color: var(--text-heading);
        }

        .auth-title {
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--text-heading);
            letter-spacing: -0.03em;
            margin-bottom: 0.35rem;
        }

        .auth-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        /* Minimalist Card */
        .auth-card {
            background: var(--surface-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--surface-card-border);
            border-radius: 20px;
            padding: 2.25rem 2rem;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.3);
        }

        /* Clean Input Groups */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-heading);
            margin-bottom: 0.45rem;
            letter-spacing: 0.01em;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            height: 44px;
            padding: 0 1rem;
            background: var(--surface-input);
            border: 1px solid var(--surface-input-border);
            border-radius: 10px;
            color: var(--text-heading);
            font-family: var(--font);
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        }

        .form-input::placeholder {
            color: var(--text-muted);
            opacity: 0.6;
        }

        .form-input:focus {
            background: var(--surface-input-focus);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--focus-ring);
        }

        .pw-toggle {
            position: absolute;
            right: 0.75rem;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: color 0.15s ease;
        }

        .pw-toggle:hover {
            color: var(--text-heading);
        }

        /* Error Message */
        .form-error {
            color: #f87171;
            font-size: 0.75rem;
            margin-top: 0.35rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Status Banner */
        .status-msg {
            background: color-mix(in srgb, var(--primary) 12%, transparent);
            border: 1px solid color-mix(in srgb, var(--primary) 25%, transparent);
            color: var(--text-heading);
            padding: 0.65rem 0.9rem;
            border-radius: 8px;
            font-size: 0.8rem;
            margin-bottom: 1.25rem;
        }

        /* Options Row */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 0.8rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            color: var(--text-body);
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            width: 15px;
            height: 15px;
            border-radius: 4px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .forgot-link:hover {
            color: var(--text-heading);
        }

        /* Action Button */
        .btn-submit {
            width: 100%;
            height: 44px;
            background: var(--accent-btn);
            border: 1px solid color-mix(in srgb, var(--accent-btn) 85%, white 15%);
            border-radius: 10px;
            color: var(--accent-btn-text);
            font-family: var(--font);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: opacity 0.2s ease, transform 0.15s ease, filter 0.2s ease;
            box-shadow: 0 4px 14px color-mix(in srgb, var(--primary) 35%, transparent);
        }

        .btn-submit:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-submit .spinner-icon {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        .btn-submit.loading .btn-text {
            display: none;
        }

        .btn-submit.loading .spinner-icon {
            display: block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.15s ease, transform 0.15s ease;
        }

        .back-link:hover {
            color: var(--text-heading);
            transform: translateX(-2px);
        }
    </style>
</head>

<body>

    <div class="studio-spotlight"></div>

    <div class="auth-container">
        {{ $slot }}
    </div>

</body>

</html>