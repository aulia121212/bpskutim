@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Tambah Data Statistik</h1>

    <form method="POST" action="{{ route('statistics.store') }}" enctype="multipart/form-data">
    @csrf

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
        @foreach($errors->all() as $error)
            <li class="text-sm text-red-600">{{ $error }}</li>
        @endforeach
    </div>
    @endif

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">

        {{-- Row 1: Indikator + Judul Data (dropdown dari master) --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Indikator</label>
                <div class="relative">
                    <select name="indikator_data"
                        class="w-full appearance-none border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Indikator</option>
                        <option value="indikator_ekonomi" {{ old('indikator_data') === 'indikator_ekonomi' ? 'selected' : '' }}>Indikator Ekonomi</option>
                        <option value="indikator_ketenagakerjaan" {{ old('indikator_data') === 'indikator_ketenagakerjaan' ? 'selected' : '' }}>Indikator Ketenagakerjaan</option>
                        <option value="indikator_sosial" {{ old('indikator_data') === 'indikator_sosial' ? 'selected' : '' }}>Indikator Sosial</option>
                        <option value="indikator_pembangunan_manusia" {{ old('indikator_data') === 'indikator_pembangunan_manusia' ? 'selected' : '' }}>Indikator Pembangunan Manusia</option>
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                </div>
                @error('indikator_data')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Judul Data — dropdown dari StatisticTitle --}}
            <div x-data="judulPicker()" x-init="init()">
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-semibold text-blue-500">Judul Data</label>
                    <a href="{{ route('statistic-titles.index') }}" target="_blank"
                        class="text-[10px] font-bold text-blue-400 hover:text-blue-600 transition flex items-center gap-1">
                        <i class="ti ti-settings text-xs"></i> Kelola Judul
                    </a>
                </div>
                <div class="relative">
                    <select name="statistic_title_id" @change="fetchInterpretasi($event.target.value)"
                        class="w-full appearance-none border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Judul Data</option>
                        @foreach($statisticTitles as $title)
                            <option value="{{ $title->id }}" {{ old('statistic_title_id') == $title->id ? 'selected' : '' }}>
                                {{ $title->judul_data }}
                            </option>
                        @endforeach
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                </div>
                @error('statistic_title_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                {{-- Preview Interpretasi (muncul otomatis saat judul dipilih) --}}
                <div x-show="kecil || besar" x-cloak
                    x-transition:enter="transition duration-200 ease-out"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="mt-3 rounded-2xl border border-blue-100 dark:border-blue-900/40 bg-blue-50/50 dark:bg-blue-900/10 p-4 space-y-3">
                    <p class="text-[10px] font-black uppercase tracking-widest text-blue-400">Preview Interpretasi</p>
                    <div x-show="kecil">
                        <p class="text-[10px] font-bold text-green-500 mb-1 flex items-center gap-1">
                            <i class="ti ti-trending-down"></i> Lebih Kecil (Turun)
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed" x-text="kecil"></p>
                    </div>
                    <div x-show="besar">
                        <p class="text-[10px] font-bold text-red-400 mb-1 flex items-center gap-1">
                            <i class="ti ti-trending-up"></i> Lebih Besar (Naik)
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed" x-text="besar"></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 2: Tahun Data + File Data --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Tahun Data</label>
                <div class="relative">
                    <select name="tahun_data[]"
                        class="w-full appearance-none border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Tahun</option>
                        @for($y = date('Y'); $y >= 2000; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                </div>
                @error('tahun_data.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">File Data</label>
                <div class="flex items-center gap-2">
                    <label class="flex-1 flex items-center justify-between border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-400 dark:bg-gray-800 cursor-pointer hover:bg-gray-50 transition">
                        <span id="file-label">Pilih file...</span>
                        <i class="ti ti-upload text-gray-400"></i>
                        <input type="file" name="file_data" accept=".pdf,.xlsx,.csv" class="hidden"
                            onchange="document.getElementById('file-label').textContent = this.files[0]?.name || 'Pilih file...'">
                    </label>
                </div>
                <p class="text-xs text-gray-400 mt-1">Format: PDF, XLSX, CSV (maks 2MB)</p>
                @error('file_data')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Row 3: Wilayah Data --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Wilayah Data</label>
                <div class="relative">
                    <select name="wilayah_data"
                        class="w-full appearance-none border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Wilayah</option>
                        <option value="Kabupaten Kutai Timur">Kabupaten Kutai Timur</option>
                        <option value="Kalimantan Timur">Kalimantan Timur</option>
                        <option value="Indonesia">Indonesia</option>
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                </div>
                @error('wilayah_data')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Nilai Data --}}
        <div class="mt-2">
            <label class="block text-sm font-semibold text-blue-500 mb-2">Nilai Data</label>
            <div id="value-container" class="space-y-2">
                <div class="flex gap-3">
                    <input type="number" step="0.01" name="value[]" placeholder="Nilai"
                        class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            @error('value.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('statistics.index') }}"
                class="px-6 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                Simpan
            </button>
        </div>

    </div>
    </form>
</div>

<script>
function judulPicker() {
    return {
        kecil: '',
        besar: '',
        init() {
            // Restore preview jika ada old value (validation failed)
            const oldId = '{{ old('statistic_title_id') }}';
            if (oldId) this.fetchInterpretasi(oldId);
        },
        async fetchInterpretasi(id) {
            this.kecil = '';
            this.besar = '';
            if (!id) return;
            try {
                const res  = await fetch(`/statistic-titles/${id}/interpretasi`);
                const data = await res.json();
                this.kecil = data.interpretasi_lebih_kecil || '';
                this.besar = data.interpretasi_lebih_besar || '';
            } catch (e) {
                console.error('Gagal mengambil interpretasi:', e);
            }
        }
    }
}
</script>
@endsection