<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — BPS Kutai Timur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,400;0,700;0,800;1,800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>

    {{-- BPS Logo watermark backdrop --}}
    <div class="logo-backdrop">
        <img src="{{ asset('images/bpslogo.svg') }}" alt="">
    </div>

    <div class="page-wrapper">
        <div class="content-row">

            {{-- ── BRAND SIDE (left) ── --}}
            <div class="brand-side">
                <div class="brand-logo-row">
                    <img src="{{ asset('images/bpslogo.svg') }}" alt="BPS Kutai Timur">
                    <div class="brand-name-block">
                        <div class="nav-logo-title">BADAN PUSAT STATISTIK</div>
                        <div class="nav-logo-title">KABUPATEN KUTAI TIMUR</div>
                    </div>
                </div>

                <p class="brand-tagline">
                    Platform Badan Pusat Statistik Kabupaten Kutai Timur yang menyediakan data statistik, interpretasi data, serta pilihan layanan konsultasi secara online maupun offline.

                </p>

                <div class="brand-chips">
                    <span class="chip">Data Statistik</span>
                    <span class="chip">Interpretasi Data</span>
                    <span class="chip">Konsultasi Online</span>
                    <span class="chip">Konsultasi Offline</span>
                </div>
            </div>

            {{-- ── GLASS CARD (right) ── --}}
            <div class="register-card">

                <div class="card-logo">
                    <img src="{{ asset('images/bpslogo.svg') }}" alt="BPS">
                    <div>
                        <div class="nav-logo-title">BADAN PUSAT STATISTIK</div>
                        <div class="nav-logo-title">KABUPATEN KUTAI TIMUR</div>
                    </div>
                </div>

                <h1 class="reg-title">Daftar</h1>
                <p class="reg-sub">Buat akun baru Anda.</p>

                @if($errors->any())
                <div class="flash-errors">
                    @foreach($errors->all() as $error)
                    <p><i class="ti ti-alert-circle" style="font-size:13px"></i> {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="Nama Lengkap Anda" autocomplete="name"
                            class="form-input @error('name') has-error @enderror">
                    </div>

                    {{-- No WhatsApp --}}
                    <div class="form-group">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp') }}"
                            placeholder="08XX-XXXX-XXXX"
                            class="form-input @error('no_whatsapp') has-error @enderror">
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="username@gmail.com" autocomplete="email"
                            class="form-input @error('email') has-error @enderror">
                    </div>

                    {{-- Kata Sandi --}}
                    <div class="form-group">
                        <label class="form-label">Kata Sandi</label>
                        <div class="input-wrap">
                            <input type="password" name="password" id="reg-password"
                                placeholder="Kata Sandi" autocomplete="new-password"
                                class="form-input @error('password') has-error @enderror">
                            <button type="button" class="toggle-pwd" onclick="togglePwd('reg-password', this)">
                                <i class="ti ti-eye-off"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Konfirmasi Kata Sandi --}}
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Kata Sandi</label>
                        <div class="input-wrap">
                            <input type="password" name="password_confirmation" id="reg-password-confirm"
                                placeholder="Ulangi Kata Sandi" autocomplete="new-password"
                                class="form-input">
                            <button type="button" class="toggle-pwd" onclick="togglePwd('reg-password-confirm', this)">
                                <i class="ti ti-eye-off"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Daftar</button>
                </form>

                <div class="divider">
                    <hr><span>Atau lanjutkan dengan</span><hr>
                </div>

                <a href="{{ route('auth.google') ?? '#' }}" class="btn-google">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Masuk dengan Google
                </a>

                <p class="login-text">
                    Sudah mempunyai akun?
                    <a href="{{ route('login') }}">Masuk disini</a>
                </p>
            </div>

        </div>
    </div>

    <script>
    function togglePwd(id, btn) {
        const input = document.getElementById(id);
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'ti ti-eye';
        } else {
            input.type = 'password';
            icon.className = 'ti ti-eye-off';
        }
    }
    </script>
</body>
</html>