<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — BPS Kutai Timur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,400;0,700;0,800;1,800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* ── BPS LOGO BACKDROP ── */
        .logo-backdrop {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 0;
        }
        .logo-backdrop img {
            width: min(70vw, 680px);
            height: auto;
            opacity: 0.08;
            user-select: none;
        }

        /* ── LAYOUT ── */
        .page-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            /* push whole content toward left edge */
            justify-content: center;
            padding: 32px 24px 32px 6vw;
        }

        .content-row {
            display: flex;
            align-items: center;
            gap: 56px;
            max-width: 980px;
            width: 100%;
        }

        /* ── GLASS CARD ── */
        .login-card {
            flex: 0 0 390px;
            background: rgba(255, 255, 255, 0.60);
            backdrop-filter: blur(20px) saturate(1.8);
            -webkit-backdrop-filter: blur(20px) saturate(1.8);
            border: 1px solid rgba(255, 255, 255, 0.88);
            border-radius: 24px;
            box-shadow:
                0 8px 36px rgba(0, 87, 183, 0.10),
                0 2px 6px rgba(0,0,0,0.04),
                inset 0 1px 0 rgba(255,255,255,0.95);
            padding: 38px 34px;
            animation: fadeUp .5s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 26px;
        }
        .card-logo img { height: 38px; width: auto; }

        .nav-logo-title {
            font-family: 'Nunito Sans', sans-serif;
            font-size: 13px;
            font-weight: 800;
            font-style: italic;
            color: #00A2E9;
            line-height: 1.2;
            transition: color 0.3s;
        }

        .login-title {
            font-size: 28px;
            font-weight: 800;
            color: #00A2E9;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }
        .login-sub {
            font-size: 13px;
            color: #8fa0b4;
            margin-bottom: 24px;
        }

        .flash-error {
            background: rgba(254,242,242,0.85);
            border: 1px solid #fecaca;
            border-radius: 11px;
            padding: 10px 13px;
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: #dc2626;
            margin-bottom: 16px;
        }

        .form-group { margin-bottom: 15px; }
        .form-label {
            display: block;
            font-size: 12.5px; font-weight: 700;
            color: #334155; margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            background: rgba(255,255,255,0.72);
            border: 1.5px solid #dce5ef;
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 13.5px; color: #1e293b;
            font-family: 'Plus Jakarta Sans', sans-serif;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .form-input::placeholder { color: #b8c6d4; }
        .form-input:focus {
            border-color: #00A2E9;
            background: rgba(255,255,255,0.96);
            box-shadow: 0 0 0 3px rgba(0,162,233,0.12);
        }
        .form-input.has-error { border-color: #f87171; background: rgba(255,245,245,0.8); }
        .form-error {
            font-size: 11.5px; color: #dc2626;
            margin-top: 4px; display: flex; align-items: center; gap: 3px;
        }

        .input-wrap { position: relative; }
        .input-wrap .form-input { padding-right: 42px; }
        .toggle-pwd {
            position: absolute; right: 13px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: #9daebf; cursor: pointer;
            font-size: 17px; line-height: 1; padding: 0;
            transition: color .2s;
        }
        .toggle-pwd:hover { color: #0057B7; }

        .forgot-link {
            display: block; text-align: right;
            font-size: 12px; font-weight: 700;
            color: #00A2E9; text-decoration: none;
            margin-top: 5px; transition: color .2s;
        }
        .forgot-link:hover { color: #0057B7; }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #0057B7 0%, #00A2E9 100%);
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 14px;
            letter-spacing: .025em;
            padding: 13px; border-radius: 12px; border: none;
            cursor: pointer; margin-top: 20px;
            box-shadow: 0 4px 18px rgba(0,87,183,.28);
            transition: opacity .18s, transform .12s, box-shadow .18s;
        }
        .btn-submit:hover { opacity: .91; box-shadow: 0 6px 22px rgba(0,87,183,.34); }
        .btn-submit:active { transform: scale(.98); }

        .divider {
            display: flex; align-items: center; gap: 10px;
            margin: 18px 0;
        }
        .divider hr { flex: 1; border: none; border-top: 1.5px solid rgba(210,220,235,0.8); }
        .divider span { font-size: 11.5px; color: #b0bec9; font-weight: 600; white-space: nowrap; }

        .btn-google {
            width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            background: rgba(255,255,255,0.78);
            border: 1.5px solid #dce5ef;
            border-radius: 12px; padding: 11px;
            font-size: 13px; font-weight: 700; color: #374151;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; text-decoration: none;
            transition: background .2s, border-color .2s, box-shadow .2s;
        }
        .btn-google:hover {
            background: rgba(255,255,255,0.97);
            border-color: #c2cfe0;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }

        .register-text {
            text-align: center; font-size: 12.5px;
            color: #8fa0b4; margin-top: 20px;
        }
        .register-text a { font-weight: 800; color: #0057B7; text-decoration: none; }
        .register-text a:hover { color: #00A2E9; }

        /* ── BRAND SIDE ── */
        .brand-side {
            flex: 1;
            display: flex; flex-direction: column;
            align-items: flex-start; gap: 22px;
            animation: fadeUp .65s .12s ease both;
        }

        .brand-logo-row {
            display: flex; align-items: center; gap: 18px;
        }
        .brand-logo-row img {
            height: 88px; width: auto;
            filter: drop-shadow(0 6px 20px rgba(0,87,183,.16));
        }
        .brand-name-block .nav-logo-title {
            font-size: 17px;
            color: #0057B7;
        }
        .brand-name-block .nav-logo-title:first-child {
            font-size: 19px;
            color: #00A2E9;
        }

        .brand-tagline {
            font-size: 13.5px; color: #7a90a8; line-height: 1.75;
            max-width: 310px;
            border-left: 3px solid #00A2E9;
            padding-left: 14px;
        }

        .brand-chips { display: flex; flex-wrap: wrap; gap: 8px; }
        .chip {
            background: rgba(0,162,233,0.08);
            border: 1px solid rgba(0,162,233,0.20);
            border-radius: 999px;
            padding: 5px 13px;
            font-size: 11.5px; font-weight: 700;
            color: #0068b7;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 760px) {
            .page-wrapper { justify-content: center; padding: 32px 20px; }
            .content-row { flex-direction: column; gap: 32px; align-items: center; }
            .login-card { flex: none; width: 100%; max-width: 420px; }
            .brand-side { align-items: center; }
            .brand-logo-row { justify-content: center; }
            .brand-name-block .nav-logo-title { text-align: center; }
            .brand-chips { justify-content: center; }
            .brand-tagline { max-width: 360px; }
        }
    </style>
</head>
<body>

    {{-- BPS Logo watermark backdrop --}}
    <div class="logo-backdrop">
        <img src="{{ asset('images/bpslogo.svg') }}" alt="">
    </div>

    <div class="page-wrapper">
        <div class="content-row">

            {{-- ── GLASS CARD ── --}}
            <div class="login-card">

                <div class="card-logo">
                    <img src="{{ asset('images/bpslogo.svg') }}" alt="BPS">
                    <div>
                        <div class="nav-logo-title">BADAN PUSAT STATISTIK</div>
                        <div class="nav-logo-title">KABUPATEN KUTAI TIMUR</div>
                    </div>
                </div>

                <h1 class="login-title">Masuk</h1>
                <p class="login-sub">Selamat datang! Masuk ke akun Anda.</p>

                @if(session('error'))
                <div class="flash-error">
                    <i class="ti ti-alert-circle" style="font-size:15px"></i>
                    {{ session('error') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="username@gmail.com" autocomplete="email"
                            class="form-input @error('email') has-error @enderror">
                        @error('email')
                        <p class="form-error"><i class="ti ti-alert-circle" style="font-size:13px"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrap">
                            <input type="password" name="password" id="login-password"
                                placeholder="Masukkan password" autocomplete="current-password"
                                class="form-input @error('password') has-error @enderror">
                            <button type="button" class="toggle-pwd" onclick="togglePwd('login-password', this)">
                                <i class="ti ti-eye-off"></i>
                            </button>
                        </div>
                        @error('password')
                        <p class="form-error"><i class="ti ti-alert-circle" style="font-size:13px"></i> {{ $message }}</p>
                        @enderror
                        <a href="#" class="forgot-link">Lupa Kata Sandi?</a>
                    </div>

                    <button type="submit" class="btn-submit">Masuk</button>
                </form>

                <div class="divider">
                    <hr><span>Atau masuk dengan</span><hr>
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

                <p class="register-text">
                    Belum mempunyai akun?
                    <a href="{{ route('register') }}">Daftar disini</a>
                </p>
            </div>

            {{-- ── BRAND SIDE ── --}}
            <div class="brand-side">
                <div class="brand-logo-row">
                    <img src="{{ asset('images/bpslogo.svg') }}" alt="BPS Kutai Timur">
                    <div class="brand-name-block">
                        <div class="nav-logo-title">BADAN PUSAT STATISTIK</div>
                        <div class="nav-logo-title">KABUPATEN KUTAI TIMUR</div>
                    </div>
                </div>

                <p class="brand-tagline">
                    Platform data statistik resmi Kabupaten Kutai Timur. Data terpercaya untuk pengambilan keputusan yang lebih baik.
                </p>

                <div class="brand-chips">
                    <span class="chip">Data Statistik</span>
                    <span class="chip">18 Kecamatan</span>
                    <span class="chip">500+ Dataset</span>
                    <span class="chip">Terintegrasi</span>
                </div>
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