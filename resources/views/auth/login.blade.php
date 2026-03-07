<x-guest-layout>

    <!-- Branding -->
    <div class="auth-brand">
        <h1>Leo's Competition</h1>
        <p>Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <!-- Card -->
    <div class="auth-card">

        <!-- Session Status -->
        @if (session('status'))
            <div class="auth-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email -->
            <div class="form-floating-group">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username" placeholder="Email">
                <label for="email">Email</label>
                @error('email')
                    <div class="auth-error">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-floating-group">
                <div class="password-wrapper">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="Password">
                    <button type="button" class="password-toggle" onclick="togglePassword()"
                        aria-label="Toggle password visibility">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
                <label for="password">Password</label>
                @error('password')
                    <div class="auth-error">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Remember & Forgot -->
            <div class="auth-options">
                <label class="remember-check">
                    <input type="checkbox" name="remember" id="remember_me">
                    <span>Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-auth" id="btnLogin">
                <span class="btn-text">Masuk</span>
                <span class="btn-loader">
                    <span class="spinner"></span>
                </span>
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div class="auth-footer">
        <a href="{{ route('home') }}">
            <i class="bi bi-arrow-left"></i> Kembali ke halaman utama
        </a>
    </div>

    <script>
        // Password visibility toggle
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }

        // Loading state on form submit
        document.getElementById('loginForm').addEventListener('submit', function () {
            document.getElementById('btnLogin').classList.add('loading');
        });

        // Floating label fix for password field (nested inside password-wrapper)
        (function () {
            const pw = document.getElementById('password');
            const label = pw.closest('.form-floating-group').querySelector('label');

            function sync() {
                const active = pw === document.activeElement || pw.value.length > 0;
                label.style.top = active ? '0' : '50%';
                label.style.transform = 'translateY(-50%)';
                label.style.fontSize = active ? '0.7rem' : '0.88rem';
                label.style.color = active ? 'var(--accent)' : 'var(--text-placeholder)';
                label.style.letterSpacing = active ? '0.3px' : '0';
                label.style.fontWeight = active ? '600' : '500';
                label.style.background = active ? 'var(--bg-card)' : 'transparent';
            }

            pw.addEventListener('focus', sync);
            pw.addEventListener('blur', sync);
            pw.addEventListener('input', sync);
        })();
    </script>

</x-guest-layout>