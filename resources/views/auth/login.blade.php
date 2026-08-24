<x-guest-layout>
    @php
        $setting = \App\Models\Setting::first();
        $namaEvent = $setting->nama_event ?? "Leo's Competition";
    @endphp

    <!-- Header -->
    <div class="auth-header">
        <div class="auth-logo">
            @if($setting && $setting->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ $namaEvent }}">
            @else
                <i class="bi bi-layers-fill"></i>
            @endif
        </div>
        <h1 class="auth-title">{{ $namaEvent }}</h1>
        <p class="auth-subtitle">Masuk untuk mengakses dashboard admin</p>
    </div>

    <!-- Minimal Card -->
    <div class="auth-card">

        @if (session('status'))
            <div class="status-msg">
                <i class="bi bi-info-circle me-1"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-wrap">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username" placeholder="name@example.com" class="form-input">
                </div>
                @error('email')
                    <div class="form-error">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrap">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="••••••••" class="form-input" style="padding-right: 2.75rem;">
                    <button type="button" class="pw-toggle" onclick="togglePassword()"
                        aria-label="Toggle password visibility">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="form-error">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Remember & Forgot -->
            <div class="form-options">
                <label class="remember-label">
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
            <button type="submit" class="btn-submit" id="btnLogin">
                <span class="btn-text">Masuk</span>
                <span class="spinner-icon"></span>
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div class="auth-footer">
        <a href="{{ route('home') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <script>
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

        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn = document.getElementById('btnLogin');
            btn.classList.add('loading');
            btn.setAttribute('disabled', 'disabled');
        });
    </script>
</x-guest-layout>