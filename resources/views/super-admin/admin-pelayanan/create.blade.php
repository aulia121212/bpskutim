@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Super Admin / Admin Data Statistik</p>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah Admin Data Statistik</h1>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-8">

        {{-- Foto Profil --}}
        <div class="flex flex-col items-center mb-8">
            <div class="relative">
                <div id="fotoPreview"
                    class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-content-center overflow-hidden border-4 border-white shadow-lg">
                    <div class="w-full h-full flex items-center justify-center bg-blue-600 rounded-full">
                        <i class="ti ti-user text-white text-4xl"></i>
                    </div>
                </div>
                <label for="fotoInput"
                    class="absolute bottom-0 right-0 w-7 h-7 bg-white border border-gray-200 rounded-full flex items-center justify-center cursor-pointer shadow hover:bg-blue-50 transition">
                    <i class="ti ti-pencil text-blue-600 text-xs"></i>
                </label>
                <input type="file" id="fotoInput" name="foto" accept="image/*" class="hidden"
                    onchange="previewFoto(this)">
            </div>
            <span class="text-sm text-gray-500 mt-3 font-medium">Foto Profil</span>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('superadmin.admin-data-statistik.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-2 gap-x-8 gap-y-5">

            {{-- Nama Lengkap --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1.5">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    placeholder="Aulia Azizah Ramadhanti"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                    required>
                @error('nama_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Nomor WhatsApp --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1.5">
                    Nomor WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp') }}"
                    placeholder="0812-xxxx-xxxx"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                    required>
                @error('no_whatsapp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1.5">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="auliaramadhanti@gmail.com"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                    required>
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Kata Sandi --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1.5">
                    Kata Sandi <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" name="password" id="passwordField"
                        placeholder="••••••••••"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white pr-10"
                        required>
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="ti ti-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Asal Instansi --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1.5">Asal Instansi</label>
                <input type="text" name="asal_instansi" value="{{ old('asal_instansi', 'BPS Kutai Timur') }}"
                    placeholder="BPS Kutai Timur"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1.5">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}"
                    placeholder="Alamat Admin"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            </div>

            {{-- Jabatan --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1.5">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                    placeholder="Jabatan Admin"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            </div>

            {{-- Tim --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1.5">Tim</label>
                <input type="text" name="tim" value="{{ old('tim') }}"
                    placeholder="Tim Admin"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            </div>

        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('superadmin.admin-data-statistik.index') }}"
                class="px-6 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit"
                class="px-8 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition shadow-sm">
                Simpan
            </button>
        </div>
        </form>
    </div>
</div>

<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('fotoPreview').innerHTML =
                `<img src="${e.target.result}" class="w-full h-full object-cover rounded-full">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function togglePassword() {
    const f = document.getElementById('passwordField');
    const i = document.getElementById('eyeIcon');
    if (f.type === 'password') { f.type = 'text'; i.className = 'ti ti-eye-off'; }
    else { f.type = 'password'; i.className = 'ti ti-eye'; }
}
</script>
@endsection