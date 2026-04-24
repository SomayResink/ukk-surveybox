<x-guest-layout>
    <div class="mb-4 text-center">
        <h4>Selamat Datang!</h4>
        <p class="text-muted">Silakan login untuk melanjutkan</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- NIS atau Email -->
        <div class="mb-3">
            <label for="login" class="form-label">NIS atau Email</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
                <input id="login" type="text" class="form-control" name="login"
                       value="{{ old('login') }}" required autofocus
                       placeholder="Masukkan NIS atau Email">
            </div>
            <small class="text-muted">Masukkan NIS atau Email yang terdaftar</small>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input id="password" type="password" class="form-control"
                       name="password" required placeholder="Masukkan password">
            </div>
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">
                Ingat saya
            </label>
        </div>

        <div class="gap-2 d-grid">
            <button type="submit" class="btn-auth">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </div>

        <div class="mt-4 text-center">
            <span class="text-muted">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="btn-link-custom ms-1">
                Daftar sebagai Siswa
            </a>
        </div>

        @if (Route::has('password.request'))
            <div class="mt-2 text-center">
                <a href="{{ route('password.request') }}" class="btn-link-custom small">
                    Lupa password?
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
