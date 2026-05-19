@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">
                Pelayanan / Petugas
            </p>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Edit Petugas
            </h1>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Perbarui data petugas layanan konsultasi
            </p>
        </div>

        <a href="{{ route('pelayanan.petugas.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">

            <i class="ti ti-arrow-left text-base"></i>
            Kembali
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">

        {{-- Top Bar --}}
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h2 class="text-base font-semibold text-gray-800 dark:text-white">
                Form Edit Petugas Layanan Konsultasi
            </h2>
        </div>

        {{-- Form --}}
        <form method="POST"
            action="{{ route('pelayanan.petugas.update', $petugas->id) }}"
            enctype="multipart/form-data"
            class="p-6">

            @csrf
            @method('PUT')

            {{-- Error --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-sm text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">
                        Nama Lengkap
                    </label>

                    <input type="text"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap', $petugas->nama_lengkap) }}"
                        placeholder="Nama Lengkap Petugas"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c] dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">
                        Nomor WhatsApp
                    </label>

                    <input type="text"
                        name="nomor_wa"
                        value="{{ old('nomor_wa', $petugas->nomor_wa) }}"
                        placeholder="0812xxxxxxx"
                        maxlength="13"
                        inputmode="numeric"
                        pattern="[0-9]{1,13}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,13)"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c] dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                </div>

                {{-- Instansi --}}
                <!-- <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">
                        Instansi
                    </label>

                    <input type="text"
                        name="instansi"
                        value="{{ old('instansi', $petugas->instansi) }}"
                        placeholder="Instansi Petugas"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c] dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                </div> -->

                {{-- Jabatan --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">
                        Jabatan
                    </label>

                    <input type="text"
                        name="jabatan"
                        value="{{ old('jabatan', $petugas->jabatan) }}"
                        placeholder="Jabatan Petugas"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c] dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                </div>

                {{-- Bidang Keahlian --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-[#035f9c] mb-2">
                        Bidang Keahlian
                    </label>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 max-h-56 overflow-y-auto space-y-2">

                        @php
                        $bidangList = [
                            'Pelayanan Umum',
                            'Pembelian Data Mikro',
                            'Potensi Desa',
                            'Kependudukan',
                            'Tenaga Kerja',
                            'Pertumbuhan Ekonomi',
                            'Ekspor-Impor',
                            'Konsumsi',
                            'Pertanian, Peternakan, dan Perikanan',
                            'Statistik Industri',
                            'Indeks Pembangunan Manusia',
                            'Pertambangan, Energi, dan Konstruksi',
                            'Big Data',
                            'Nilai Tukar Petani',
                            'Kemiskinan',
                            'Statistik Sektoral',
                            'Sains Data',
                            'Pariwisata',
                            'Harga & Inflasi',
                            'Demokrasi dan Kriminalitas',
                            'Layanan Pengaduan',
                            'Petugas PPID',
                        ];

                       $selectedBidang = old(
    'bidang_keahlian',
    $petugas->bidang_keahlian ?? []
);
                        @endphp

                        @foreach($bidangList as $bidang)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                name="bidang_keahlian[]"
                                value="{{ $bidang }}"
                                {{ in_array($bidang, $selectedBidang) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-[#035f9c] focus:ring-[#035f9c]">

                            <span class="text-sm text-gray-700 dark:text-gray-200">
                                {{ $bidang }}
                            </span>
                        </label>
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- Foto --}}
            <div class="mb-8">

                <label class="block text-sm font-semibold text-[#035f9c] mb-2">
                    Foto Petugas
                </label>

                <label class="flex flex-col items-center justify-center border-2 border-dashed border-blue-200 rounded-2xl p-10 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-800 transition">

                    <i class="ti ti-cloud-upload text-3xl text-blue-400 mb-2"></i>

                    <p class="text-sm text-[#035f9c] font-semibold">
                        Click to upload or drag and drop
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        PNG, JPG atau JPEG
                    </p>

                    <input type="file"
                        name="foto"
                        accept="image/*"
                        class="hidden"
                        onchange="previewFoto(this)">
                </label>

                {{-- Preview --}}
                <div class="mt-4">
                    <img id="foto-preview"
                        src="{{ $petugas->foto ? asset('storage/' . $petugas->foto) : '' }}"
                        class="{{ $petugas->foto ? '' : 'hidden' }} w-40 h-28 object-cover rounded-xl border border-gray-200 dark:border-gray-700">
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-5 border-t border-gray-100 dark:border-gray-800">

                <a href="{{ route('pelayanan.petugas.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    Batal
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 bg-[#035f9c] hover:bg-[#024d7f] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">

                    <i class="ti ti-device-floppy"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>
    </div>
</div>

<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById('foto-preview');

            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection