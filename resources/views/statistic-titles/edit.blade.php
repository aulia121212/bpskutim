@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">Edit Judul Data</h1>
            <p class="text-xs text-gray-400 mt-0.5">{{ $statisticTitle->judul_data }}</p>
        </div>
        <a href="{{ route('statistic-titles.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('statistic-titles.update', $statisticTitle) }}"
        x-data="titleForm()" x-init="init()">
        @csrf
        @method('PUT')

        <div class="space-y-5">

            {{-- ── Card: Info Judul ── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6 space-y-4">
                <h2 class="text-sm font-bold text-gray-700 dark:text-white flex items-center gap-2">
                    <i class="ti ti-file-description text-blue-500"></i> Informasi Judul
                </h2>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Indikator --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Indikator Data <span class="text-red-400">*</span></label>
                        <select name="indikator_data" required
                            class="w-full appearance-none border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach([
                                'indikator_ekonomi'             => 'Indikator Ekonomi',
                                'indikator_ketenagakerjaan'     => 'Indikator Kependudukan & Ketenagakerjaan',
                                'indikator_sosial'              => 'Indikator Sosial',
                                'indikator_pembangunan_manusia' => 'Indikator Pembangunan Manusia',
                                'gender'                        => 'Gender',
                            ] as $val => $label)
                                <option value="{{ $val }}" {{ $statisticTitle->indikator_data === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Judul Kolom --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Judul Kolom</label>
                        <input type="text" name="judul_kolom"
                            value="{{ old('judul_kolom', $statisticTitle->judul_kolom) }}"
                            placeholder="cth: Dimensi/Indikator"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                {{-- Judul Data --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Judul Data <span class="text-red-400">*</span></label>
                    <input type="text" name="judul_data" required
                        value="{{ old('judul_data', $statisticTitle->judul_data) }}"
                        placeholder="cth: Indeks Pembangunan Manusia (IPM)"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- ── Card: Interpretasi Level Judul ── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6 space-y-4">
                <h2 class="text-sm font-bold text-gray-700 dark:text-white flex items-center gap-2">
                    <i class="ti ti-message-2-text text-purple-500"></i> Interpretasi Level Judul
                    <span class="text-xs font-normal text-gray-400">(tampil di "Interpretasi Keseluruhan")</span>
                </h2>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-green-600 mb-1.5">
                            <i class="ti ti-trending-up"></i> Jika Naik / Lebih Besar
                        </label>
                        <textarea name="interpretasi_lebih_besar" rows="2"
                            placeholder="cth: Capaian ini menunjukkan bahwa masyarakat memiliki peluang hidup yang semakin panjang..."
                            class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 resize-none">{{ old('interpretasi_lebih_besar', $statisticTitle->interpretasi_lebih_besar) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-red-500 mb-1.5">
                            <i class="ti ti-trending-down"></i> Jika Turun / Lebih Kecil
                        </label>
                        <textarea name="interpretasi_lebih_kecil" rows="2"
                            placeholder="cth: Penurunan ini menunjukkan bahwa kondisi kesehatan perlu mendapat perhatian..."
                            class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400 resize-none">{{ old('interpretasi_lebih_kecil', $statisticTitle->interpretasi_lebih_kecil) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                            <i class="ti ti-minus"></i> Jika Tetap
                        </label>
                        <textarea name="interpretasi_tetap" rows="2"
                            placeholder="cth: Nilai relatif stabil dibandingkan tahun sebelumnya..."
                            class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 resize-none">{{ old('interpretasi_tetap', $statisticTitle->interpretasi_tetap) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── Card: Komponen / Kategori ── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-700 dark:text-white flex items-center gap-2">
                        <i class="ti ti-list text-blue-500"></i> Komponen / Kategori
                        <span class="text-xs font-normal text-gray-400">(<span x-text="components.length"></span> komponen)</span>
                    </h2>
                    <button type="button" @click="addComponent()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                        <i class="ti ti-plus"></i> Tambah Komponen
                    </button>
                </div>

                {{-- Empty state --}}
                <div x-show="components.length === 0" class="text-center py-8 text-gray-400">
                    <i class="ti ti-list-details text-3xl mb-2 block"></i>
                    <p class="text-sm">Belum ada komponen. Klik "Tambah Komponen" untuk menambahkan.</p>
                </div>

                {{-- List komponen --}}
                <div class="space-y-3" x-show="components.length > 0">
                    <template x-for="(comp, idx) in components" :key="comp._key">
                        <div class="rounded-xl border border-gray-100 dark:border-gray-800 overflow-hidden">

                            {{-- Header komponen --}}
                            <div class="flex items-center gap-3 px-4 py-2.5 bg-gray-50 dark:bg-gray-800/50">
                                {{-- Drag handle --}}
                                <i class="ti ti-grip-vertical text-gray-300 cursor-grab text-base"></i>

                                {{-- Nomor --}}
                                <span class="text-xs font-bold text-gray-400 w-5 shrink-0" x-text="idx + 1"></span>

                                {{-- Nama --}}
                                <input type="text" :name="`components[${idx}][nama]`"
                                    x-model="comp.nama"
                                    placeholder="Nama komponen..."
                                    class="flex-1 border-0 bg-transparent text-sm font-semibold text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-0 placeholder-gray-300">

                                {{-- Satuan --}}
                                <input type="text" :name="`components[${idx}][satuan]`"
                                    x-model="comp.satuan"
                                    placeholder="Satuan (cth: %)"
                                    class="w-28 border border-gray-200 dark:border-gray-700 rounded-lg px-2.5 py-1 text-xs text-gray-600 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-1 focus:ring-blue-400">

                                {{-- Toggle is_sub --}}
                                <label class="flex items-center gap-1.5 cursor-pointer shrink-0">
                                    <input type="checkbox" :name="`components[${idx}][is_sub]`"
                                        x-model="comp.is_sub" value="1"
                                        class="rounded accent-indigo-500">
                                    <span class="text-xs text-gray-500">Sub</span>
                                </label>

                                {{-- Toggle expand --}}
                                <button type="button" @click="comp._open = !comp._open"
                                    class="text-gray-400 hover:text-blue-500 transition">
                                    <i class="ti text-base" :class="comp._open ? 'ti-chevron-up' : 'ti-chevron-down'"></i>
                                </button>

                                {{-- Hapus --}}
                                <button type="button" @click="removeComponent(idx)"
                                    class="text-gray-300 hover:text-red-500 transition">
                                    <i class="ti ti-trash text-base"></i>
                                </button>
                            </div>

                            {{-- Hidden inputs wajib --}}
                            <input type="hidden" :name="`components[${idx}][is_sub]`" :value="comp.is_sub ? 1 : 0">

                            {{-- Body: interpretasi per komponen (collapsible) --}}
                            <div x-show="comp._open" x-transition class="px-4 py-3 space-y-3 border-t border-gray-100 dark:border-gray-800">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Interpretasi Komponen Ini</p>

                                <div class="grid grid-cols-1 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-green-600 mb-1">
                                            <i class="ti ti-trending-up"></i> Jika Naik
                                        </label>
                                        <textarea :name="`components[${idx}][interpretasi_lebih_besar]`"
                                            x-model="comp.interpretasi_lebih_besar"
                                            rows="2" placeholder="Interpretasi jika nilai naik..."
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-1 focus:ring-green-400 resize-none"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-red-500 mb-1">
                                            <i class="ti ti-trending-down"></i> Jika Turun
                                        </label>
                                        <textarea :name="`components[${idx}][interpretasi_lebih_kecil]`"
                                            x-model="comp.interpretasi_lebih_kecil"
                                            rows="2" placeholder="Interpretasi jika nilai turun..."
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-1 focus:ring-red-400 resize-none"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">
                                            <i class="ti ti-minus"></i> Jika Tetap
                                        </label>
                                        <textarea :name="`components[${idx}][interpretasi_tetap]`"
                                            x-model="comp.interpretasi_tetap"
                                            rows="2" placeholder="Interpretasi jika nilai tetap..."
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 resize-none"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </template>
                </div>

                {{-- Tombol tambah bawah --}}
                <button type="button" @click="addComponent()" x-show="components.length > 0"
                    class="mt-3 w-full py-2 rounded-xl border-2 border-dashed border-gray-200 text-xs font-semibold text-gray-400 hover:border-blue-300 hover:text-blue-500 transition flex items-center justify-center gap-1.5">
                    <i class="ti ti-plus"></i> Tambah Komponen
                </button>
            </div>

            {{-- ── Action Buttons ── --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('statistic-titles.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>
            </div>

        </div>
    </form>
</div>

<script>
function titleForm() {
    return {
        components: [],
        _keyCounter: 0,

        init() {
            {{-- ✅ $existingComponents sudah di-map di controller, aman di-pass ke @json() --}}
            const existing = @json($existingComponents);

            this.components = existing.map(c => ({
                ...c,
                _key:  ++this._keyCounter,
                _open: false,
            }));
        },

        addComponent() {
            this.components.push({
                _key:                     ++this._keyCounter,
                _open:                    true,
                nama:                     '',
                satuan:                   '',
                is_sub:                   false,
                interpretasi_lebih_kecil: '',
                interpretasi_lebih_besar: '',
                interpretasi_tetap:       '',
            });
            this.$nextTick(() => {
                const last = document.querySelector('[x-data] .space-y-3 > div:last-child');
                last?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        },

        removeComponent(idx) {
            if (confirm('Hapus komponen "' + (this.components[idx].nama || 'ini') + '"?')) {
                this.components.splice(idx, 1);
            }
        },
    };
}
</script>
@endsection