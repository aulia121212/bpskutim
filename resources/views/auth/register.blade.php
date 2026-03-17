<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — BPS Kutai Timur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-shape {
            position: absolute;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4 relative overflow-hidden">

    {{-- Background shapes --}}
    <div class="bg-shape w-64 h-64 bg-orange-100 opacity-50 -right-16 top-1/4 pointer-events-none" style="border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%;"></div>
    <div class="bg-shape w-48 h-48 bg-blue-100 opacity-40 -left-8 top-1/3 pointer-events-none"></div>
    <div class="bg-shape w-40 h-40 bg-green-100 opacity-40 right-1/4 bottom-10 pointer-events-none"></div>

    {{-- Card --}}
    <div class="relative z-10 w-full max-w-md bg-white rounded-3xl shadow-xl shadow-gray-200/80 p-8 md:p-10">

        {{-- Logo --}}
        <div class="flex items-center gap-2.5 mb-8">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Logo_BPS.svg/200px-Logo_BPS.svg.png"
                 alt="Logo BPS" class="h-9 w-auto">
            <div class="leading-tight">
                <p class="text-[10px] font-black text-blue-600 uppercase tracking-wide">Badan Pusat Statistik</p>
                <p class="text-[10px] font-black text-blue-600 uppercase tracking-wide">Kabupaten Kutai Timur</p>
            </div>
        </div>

        {{-- Title --}}
        <h1 class="text-3xl font-extrabold text-blue-600 mb-7">Daftar</h1>

        {{-- Errors --}}
        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 rounded-xl px-4 py-3 space-y-1">
            @foreach($errors->all() as $error)
            <p class="text-xs text-red-600 flex items-center gap-1.5"><i class="ti ti-alert-circle"></i> {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    placeholder="Nama Lengkap Anda"
                    autocomplete="name"
                    class="w-full border @error('name') border-red-400 bg-red-50 @else border-gray-200 bg-gray-50 @enderror rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition">
            </div>

            {{-- Nomor WhatsApp --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor WhatsApp</label>
                <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp') }}"
                    placeholder="08XX-XXXX-XXXX"
                    class="w-full border @error('no_whatsapp') border-red-400 bg-red-50 @else border-gray-200 bg-gray-50 @enderror rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="username@gmail.com"
                    autocomplete="email"
                    class="w-full border @error('email') border-red-400 bg-red-50 @else border-gray-200 bg-gray-50 @enderror rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition">
            </div>

            {{-- Kata Sandi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password" id="reg-password"
                        placeholder="Kata Sandi"
                        autocomplete="new-password"
                        class="w-full border @error('password') border-red-400 bg-red-50 @else border-gray-200 bg-gray-50 @enderror rounded-xl px-4 py-3 pr-11 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition">
                    <button type="button" onclick="togglePwd('reg-password', this)"
                        class="absolute right-3.5 top-3.5 text-gray-400 hover:text-gray-600 transition">
                        <i class="ti ti-eye-off text-lg"></i>
                    </button>
                </div>
            </div>

            {{-- Konfirmasi Kata Sandi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="reg-password-confirm"
                        placeholder="Ulangi Kata Sandi"
                        autocomplete="new-password"
                        class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 pr-11 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition">
                    <button type="button" onclick="togglePwd('reg-password-confirm', this)"
                        class="absolute right-3.5 top-3.5 text-gray-400 hover:text-gray-600 transition">
                        <i class="ti ti-eye-off text-lg"></i>
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 active:scale-[0.98] text-white font-bold py-3.5 rounded-xl transition shadow-sm shadow-blue-200 text-sm tracking-wide mt-2">
                Daftar
            </button>
        </form>

        {{-- Divider --}}
        <div class="flex items-center gap-3 my-5">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs text-gray-400 font-medium">Atau lanjutkan dengan</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        {{-- Google --}}
        <a href="{{ route('auth.google') ?? '#' }}"
            class="w-full flex items-center justify-center gap-3 border border-gray-200 bg-white hover:bg-gray-50 rounded-xl py-3 text-sm font-semibold text-gray-700 transition">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Masuk dengan Google
        </a>

        {{-- Login link --}}
        <p class="text-center text-sm text-gray-500 mt-7">
            Sudah mempunyai akun?
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition">Masuk disini</a>
        </p>
    </div>

    <script>
    function togglePwd(id, btn) {
        const input = document.getElementById(id);
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'ti ti-eye text-lg';
        } else {
            input.type = 'password';
            icon.className = 'ti ti-eye-off text-lg';
        }
    }
    </script>
</body>
</html>
