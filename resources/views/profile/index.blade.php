@extends('layouts.app')

@section('title', 'Profil Akun')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Profil Akun</h1>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-8">

        {{-- Foto Profil --}}
        <div class="flex flex-col items-center mb-10">
            <div class="relative group mb-3">
                <div class="w-24 h-24 rounded-full bg-blue-700 flex items-center justify-center overflow-hidden ring-4 ring-white dark:ring-gray-900 shadow-lg">
                    @if(auth()->check() && auth()->user()?->foto_profil)
                        <img src="{{ Storage::url(auth()->user()?->foto_profil) }}" 
                             alt="Foto Profil" 
                             class="w-full h-full object-cover">
                    @else
                        <i class="ti ti-user-circle text-5xl text-white"></i>
                    @endif
                </div>
                <label for="foto-input"
                    class="absolute bottom-0 right-0 w-8 h-8 bg-blue-700 hover:bg-blue-800 text-white rounded-full flex items-center justify-center cursor-pointer shadow transition">
                    <i class="ti ti-pencil text-sm"></i>
                    <input type="file" id="foto-input" name="foto_profil" accept="image/*" class="hidden"
                        onchange="previewFoto(this)">
                </label>
            </div>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Foto Profil</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profileForm">
            @csrf
            @method('PUT')

            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
                <i class="ti ti-circle-check text-green-500 text-lg"></i>
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-600 flex items-center gap-2"><i class="ti ti-alert-circle"></i> {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">
                        Nama Lengkap<span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}"
                        placeholder="Nama Lengkap"
                        class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#035f9c] transition">
                </div>

                {{-- Nomor WhatsApp --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">
                        Nomor WhatsApp<span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', auth()->user()?->no_whatsapp) }}"
                        placeholder="0812-xxxx-xxxx"
                        class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#035f9c] transition">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">
                        Email<span class="text-red-400">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}"
                        placeholder="email@example.com"
                        class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#035f9c] transition">
                </div>

                {{-- Kata Sandi --}}
<div id="current-password-wrap" style="display:none">
    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">
        Password Saat Ini<span class="text-red-400">*</span>
    </label>
    <input type="password" name="current_password" id="current_password"
        class="w-full border rounded-xl px-4 py-3 text-sm"
        placeholder="Masukkan password saat ini">
</div>

{{-- Password Baru --}}
<div>
    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">
        Password Baru
    </label>
    <input type="password" name="new_password" id="new_password"
        placeholder="Kosongkan jika tidak ingin mengubah"
        oninput="toggleCurrentPwField(this)"
        class="w-full border rounded-xl px-4 py-3 text-sm">
</div>

                {{-- Asal Instansi --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">Asal Instansi</label>
                    <input type="text" name="instansi" value="{{ old('instansi', auth()->user()?->instansi) }}"
                        placeholder="BPS Kutai Timur"
                        class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#035f9c] transition">
                </div>

                {{-- Alamat --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', auth()->user()?->alamat) }}"
                        placeholder="Alamat Admin"
                        class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#035f9c] transition">
                </div>

                {{-- Jabatan --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', auth()->user()?->jabatan) }}"
                        placeholder="Jabatan Admin"
                        class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#035f9c] transition">
                </div>

                {{-- Tim --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">Tim</label>
                    <input type="text" name="tim" value="{{ old('tim', auth()->user()?->tim) }}"
                        placeholder="Tim Admin"
                        class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#035f9c] transition">
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 mt-10">
                <a href="{{ url()->previous() }}"
                    class="px-6 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-8 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold transition shadow-sm">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function previewFoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const wrap = input.closest('label').previousElementSibling;
        wrap.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-full">`;
    };
    reader.readAsDataURL(input.files[0]);
}

function togglePassword() {
    const field = document.getElementById('password-field');
    const eye   = document.getElementById('password-eye');
    if (field.type === 'password') {
        field.type = 'text';
        eye.className = 'ti ti-eye-off';
    } else {
        field.type = 'password';
        eye.className = 'ti ti-eye';
    }
}

function toggleCurrentPwField(input) {
    const wrap = document.getElementById('current-password-wrap');
    const current = document.getElementById('current_password');

    if (input.value.length > 0) {
        wrap.style.display = 'block';
        current.required = true;
    } else {
        wrap.style.display = 'none';
        current.required = false;
        current.value = '';
    }
}
</script>
@endsection