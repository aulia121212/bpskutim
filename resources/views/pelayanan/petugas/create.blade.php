@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Tambah Petugas</h1>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-8">
        <h2 class="text-center text-lg font-semibold text-gray-700 dark:text-white mb-8">Tambah Petugas Layanan Konsultasi</h2>

        <form method="POST" action="{{ route('pelayanan.petugas.store') }}" enctype="multipart/form-data">
        @csrf

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
            @foreach($errors->all() as $error)
                <li class="text-sm text-red-600">{{ $error }}</li>
            @endforeach
        </div>
        @endif

        <div class="grid grid-cols-2 gap-6 mb-6">
            {{-- Nama Lengkap --}}
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap Petugas"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Nomor WhatsApp --}}
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Nomor WhatsApp</label>
                <input type="text" name="nomor_wa" value="{{ old('nomor_wa') }}" placeholder="0812-xxxx-xxxx"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- <div>
    <label class="block text-sm font-semibold text-gray-600 mb-1">Instansi</label>
    <input type="text" name="instansi" value="{{ old('instansi') }}" placeholder="Instansi Petugas"
        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
</div> -->

            {{-- Jabatan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Jabatan Petugas"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Bidang Keahlian --}}
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Bidang Keahlian</label>
                <div class="border border-gray-200 rounded-xl px-4 py-3 max-h-48 overflow-y-auto space-y-2">
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
                    @endphp
                    @foreach($bidangList as $bidang)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="bidang_keahlian[]" value="{{ $bidang }}"
                            {{ in_array($bidang, old('bidang_keahlian', [])) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">{{ $bidang }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Foto Petugas --}}
        <div class="mb-8">
            <label class="block text-sm font-semibold text-gray-600 mb-1">Foto Petugas</label>
            <label class="flex flex-col items-center justify-center border-2 border-dashed border-blue-200 rounded-xl p-10 cursor-pointer hover:bg-blue-50 transition"
                id="foto-label">
                <i class="ti ti-cloud-upload text-3xl text-blue-400 mb-2"></i>
                <p class="text-sm text-blue-500 font-semibold">Click to upload or drag and drop</p>
                <p class="text-xs text-gray-400 mt-1">PNG, JPG or JPEG (max. 800x400px)</p>
                <input type="file" name="foto" accept="image/*" class="hidden"
                    onchange="previewFoto(this)">
            </label>
            <img id="foto-preview" src="" class="hidden mt-3 w-40 h-28 object-cover rounded-xl border border-gray-200">
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('pelayanan.petugas.index') }}"
                class="px-6 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
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
            const preview = document.getElementById('foto-preview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection