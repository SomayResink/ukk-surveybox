<x-guest-layout>
    <div class="mb-4 text-center">
        <h4>Daftar Akun Siswa</h4>
        <p class="text-muted">Isi data berikut untuk mendaftar</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-user"></i>
                </span>
                <input id="name" type="text" class="form-control" name="name"
                       value="{{ old('name') }}" required autofocus
                       placeholder="Masukkan nama lengkap">
            </div>
        </div>

        <!-- NIS -->
        <div class="mb-3">
            <label for="nis" class="form-label">NIS</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-id-card"></i>
                </span>
                <input id="nis" type="text" class="form-control" name="nis"
                       value="{{ old('nis') }}" required
                       placeholder="Masukkan NIS">
            </div>
            <small class="text-muted">Nomor Induk Siswa dari sekolah</small>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
                <input id="email" type="email" class="form-control" name="email"
                       value="{{ old('email') }}" required
                       placeholder="contoh@email.com">
            </div>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input id="password" type="password" class="form-control"
                       name="password" required placeholder="Minimal 8 karakter">
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input id="password_confirmation" type="password" class="form-control"
                       name="password_confirmation" required placeholder="Ulangi password">
            </div>
        </div>

        <hr>

        <div class="gap-2 d-grid">
            <button type="submit" class="btn-auth">
                <i class="fas fa-user-plus"></i> Daftar
            </button>
        </div>

        <div class="mt-4 text-center">
            <span class="text-muted">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="btn-link-custom ms-1">
                Login di sini
            </a>
        </div>
    </form>
</x-guest-layout>
