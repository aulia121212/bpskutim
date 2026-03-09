@extends('layouts.app')

@section('content')
<div class="p-6" x-data="createStatistic()">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Tambah Data Statistik</h1>

    <form method="POST" action="{{ route('statistics.store') }}" enctype="multipart/form-data" id="statisticForm">
    @csrf

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
        @foreach($errors->all() as $error)
            <li class="text-sm text-red-600">{{ $error }}</li>
        @endforeach
    </div>
    @endif

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">

        {{-- Row 1: Indikator + Judul Data --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Indikator</label>
                <div class="relative">
                    <select name="indikator_data"
                        class="w-full appearance-none border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Indikator</option>
                        <option value="indikator_ekonomi">Indikator Ekonomi</option>
                        <option value="indikator_ketenagakerjaan">Indikator Ketenagakerjaan</option>
                        <option value="indikator_sosial">Indikator Sosial</option>
                        <option value="indikator_pembangunan_manusia">Indikator Pembangunan Manusia</option>
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <div x-data="judulPicker()" x-init="init()">
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-semibold text-blue-500">Judul Data</label>
                    <a href="{{ route('statistic-titles.index') }}" target="_blank"
                        class="text-[10px] font-bold text-blue-400 hover:text-blue-600 flex items-center gap-1">
                        <i class="ti ti-settings text-xs"></i> Kelola Judul
                    </a>
                </div>
                <div class="relative">
                    <select name="statistic_title_id" @change="fetchInterpretasi($event.target.value)"
                        class="w-full appearance-none border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Judul Data</option>
                        @foreach($statisticTitles as $title)
                            <option value="{{ $title->id }}">{{ $title->judul_data }}</option>
                        @endforeach
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                </div>
                <div x-show="kecil || besar" x-cloak
                    class="mt-3 rounded-2xl border border-blue-100 dark:border-blue-900/40 bg-blue-50/50 p-3 space-y-2">
                    <p class="text-[10px] font-black uppercase tracking-widest text-blue-400">Preview Interpretasi</p>
                    <div x-show="kecil">
                        <p class="text-[10px] font-bold text-green-500 mb-0.5"><i class="ti ti-trending-down"></i> Turun</p>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2" x-text="kecil"></p>
                    </div>
                    <div x-show="besar">
                        <p class="text-[10px] font-bold text-red-400 mb-0.5"><i class="ti ti-trending-up"></i> Naik</p>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2" x-text="besar"></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 2: Wilayah + File Referensi --}}
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
            </div>
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">File Referensi</label>
                <label class="flex items-center justify-between border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-400 dark:bg-gray-800 cursor-pointer hover:bg-gray-50 transition">
                    <span id="file-label">Pilih file...</span>
                    <i class="ti ti-upload text-gray-400"></i>
                    <input type="file" name="file_data" accept=".pdf,.xlsx,.csv" class="hidden"
                        onchange="document.getElementById('file-label').textContent = this.files[0]?.name || 'Pilih file...'">
                </label>
                <p class="text-xs text-gray-400 mt-1">PDF, XLSX, CSV (maks 2MB)</p>
            </div>
        </div>

        {{-- ================================================================ --}}
        {{-- NILAI DATA                                                        --}}
        {{-- ================================================================ --}}
        <div class="border-t border-gray-100 dark:border-gray-800 pt-6">

            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-semibold text-blue-500">Nilai Data</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Baris = <span class="font-semibold text-gray-600 dark:text-gray-300">Kategori/Lapangan Usaha</span> &nbsp;·&nbsp;
                        Kolom = <span class="font-semibold text-gray-600 dark:text-gray-300">Tahun</span>
                    </p>
                </div>
                {{-- Tab Manual / Excel --}}
                <div class="flex rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden text-xs font-bold">
                    <button type="button" @click="inputMode = 'grid'"
                        :class="inputMode === 'grid' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-900 text-gray-500 hover:bg-gray-50'"
                        class="px-4 py-2 transition flex items-center gap-1.5">
                        <i class="ti ti-table text-sm"></i> Tabel Grid
                    </button>
                    <button type="button" @click="inputMode = 'excel'"
                        :class="inputMode === 'excel' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-900 text-gray-500 hover:bg-gray-50'"
                        class="px-4 py-2 transition flex items-center gap-1.5 border-l border-gray-200 dark:border-gray-700">
                        <i class="ti ti-table-import text-sm"></i> Import Excel
                    </button>
                </div>
            </div>

            {{-- =================== TABEL GRID =================== --}}
            <div x-show="inputMode === 'grid'">

                {{-- Toolbar: tambah tahun + tambah baris --}}
                <div class="flex items-center gap-3 mb-4 flex-wrap">
                    {{-- Tambah Tahun --}}
                    <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-800 rounded-xl px-3 py-2 border border-gray-200 dark:border-gray-700">
                        <input type="number" x-model="newYear" placeholder="2024" min="2000" max="2100"
                            class="w-20 bg-transparent text-sm text-gray-700 dark:text-gray-300 focus:outline-none"
                            @keydown.enter.prevent="addYear()">
                        <button type="button" @click="addYear()"
                            class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 whitespace-nowrap">
                            <i class="ti ti-plus text-sm"></i> Tahun
                        </button>
                    </div>

                    <div class="h-5 w-px bg-gray-200 dark:bg-gray-700"></div>

                    {{-- Tambah Kategori Utama --}}
                    <button type="button" @click="addCategory(false)"
                        class="flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 dark:bg-blue-900/20 rounded-xl px-3 py-2 transition">
                        <i class="ti ti-layout-rows text-sm"></i> + Kategori
                    </button>

                    {{-- Tambah Sub-kategori --}}
                    <button type="button" @click="addCategory(true)"
                        class="flex items-center gap-1.5 text-xs font-bold text-indigo-500 hover:text-indigo-700 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl px-3 py-2 transition">
                        <i class="ti ti-indent-increase text-sm"></i> + Sub-kategori
                    </button>

                    <span class="text-xs text-gray-400 italic" x-show="years.length === 0">← Tambah tahun dulu</span>
                </div>

                {{-- Legend --}}
                <div class="flex items-center gap-4 mb-3 text-[10px] font-semibold text-gray-400">
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600"></span>
                        Kategori Utama
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-700"></span>
                        Sub-kategori <span class="opacity-60">(prefix "· " otomatis)</span>
                    </span>
                </div>

                {{-- Grid Tabel --}}
                <div x-show="years.length > 0 && categories.length > 0" class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-700">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800">
                                <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-r border-gray-100 dark:border-gray-700 min-w-[240px]"
                                    x-text="judulKolom"></th>
                                <template x-for="(year, yi) in years" :key="year">
                                    <th class="px-3 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-r border-gray-100 dark:border-gray-700 text-center min-w-[110px]">
                                        <div class="flex items-center justify-center gap-1">
                                            <span x-text="year"></span>
                                            <button type="button" @click="removeYear(yi)"
                                                class="text-gray-300 hover:text-rose-500 transition">
                                                <i class="ti ti-x text-[10px]"></i>
                                            </button>
                                        </div>
                                    </th>
                                </template>
                                <th class="bg-gray-50 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 w-10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(cat, ci) in categories" :key="ci">
                                <tr class="transition"
                                    :class="cat.isSub
                                        ? 'bg-indigo-50/40 dark:bg-indigo-900/10 hover:bg-indigo-50 dark:hover:bg-indigo-900/20'
                                        : 'bg-white dark:bg-gray-900 hover:bg-gray-50/50 dark:hover:bg-gray-800/30'">

                                    {{-- Nama kategori --}}
                                    <td class="border-b border-r border-gray-100 dark:border-gray-700 px-2 py-1">
                                        <div class="flex items-center gap-2" :class="cat.isSub ? 'pl-5' : ''">
                                            {{-- Indent indicator untuk sub --}}
                                            <span x-show="cat.isSub" class="text-indigo-300 text-xs font-bold shrink-0">·</span>
                                            <input type="text"
                                                :name="'grid[' + ci + '][category]'"
                                                x-model="cat.name"
                                                :placeholder="cat.isSub ? 'Nilai (Juta Rupiah)' : 'PDRB per Kapita'"
                                                :class="cat.isSub
                                                    ? 'text-gray-600 dark:text-gray-400 italic text-xs'
                                                    : 'text-gray-800 dark:text-white font-semibold text-sm'"
                                                class="w-full bg-transparent px-2 py-1.5 focus:outline-none focus:bg-white dark:focus:bg-gray-800 rounded-lg transition">
                                        </div>
                                    </td>

                                    {{-- Nilai per tahun --}}
                                    <template x-for="(year, yi) in years" :key="year">
                                        <td class="border-b border-r border-gray-100 dark:border-gray-700 px-2 py-1 text-center">
                                            <input type="text"
                                                :name="'grid[' + ci + '][values][' + year + ']'"
                                                x-model="cat.values[year]"
                                                placeholder="-"
                                                @blur="cat.values[year] = parseIndonesian(cat.values[year])"
                                                :class="cat.isSub ? 'text-gray-500 text-xs' : 'text-gray-700 text-sm'"
                                                class="w-full bg-transparent px-2 py-1.5 text-center dark:text-gray-300 focus:outline-none focus:bg-white dark:focus:bg-gray-800 rounded-lg transition">
                                        </td>
                                    </template>

                                    {{-- Aksi --}}
                                    <td class="border-b border-gray-100 dark:border-gray-700 px-2 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            {{-- Toggle sub/utama --}}
                                            <button type="button" @click="cat.isSub = !cat.isSub; syncPrefix(ci)"
                                                :title="cat.isSub ? 'Jadikan kategori utama' : 'Jadikan sub-kategori'"
                                                :class="cat.isSub ? 'text-indigo-400 hover:text-indigo-600' : 'text-gray-300 hover:text-indigo-400'"
                                                class="w-6 h-6 flex items-center justify-center rounded transition">
                                                <i class="ti ti-indent-increase text-xs"></i>
                                            </button>
                                            {{-- Hapus --}}
                                            <button type="button" @click="removeCategory(ci)"
                                                class="w-6 h-6 flex items-center justify-center rounded text-gray-300 hover:text-rose-500 transition">
                                                <i class="ti ti-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                {{-- Empty state --}}
                <div x-show="years.length === 0 || categories.length === 0"
                    class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl py-12 text-center">
                    <i class="ti ti-table text-3xl text-gray-300 mb-3 block"></i>
                    <p class="text-sm font-semibold text-gray-400">Tambah tahun dan kategori untuk mulai mengisi data</p>
                </div>

                <input type="hidden" name="input_mode" value="grid">
                <input type="hidden" name="years_list" :value="JSON.stringify(years)">
            </div>

            {{-- =================== IMPORT EXCEL =================== --}}
            <div x-show="inputMode === 'excel'" x-cloak>
                <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl p-8 text-center transition"
                    :class="excelFile ? 'border-blue-300 bg-blue-50/30 dark:bg-blue-900/10' : 'hover:border-blue-300'"
                    @dragover.prevent @drop.prevent="handleDrop($event)">

                    <template x-if="!excelFile">
                        <div>
                            <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-4">
                                <i class="ti ti-table-import text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-sm font-bold text-gray-700 dark:text-white mb-1">Upload file Excel / CSV</p>
                            <p class="text-xs text-gray-400 mb-1">Format yang didukung: kolom pertama = kategori, kolom berikutnya = tahun</p>
                            <p class="text-xs text-gray-300 mb-4">Contoh: Kolom A = Lapangan Usaha, Kolom B = 2020, Kolom C = 2021, dst</p>
                            <label class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl cursor-pointer transition">
                                <i class="ti ti-upload"></i> Pilih File
                                <input type="file" name="excel_values" accept=".xlsx,.csv" class="hidden"
                                    @change="handleExcelUpload($event)">
                            </label>
                        </div>
                    </template>

                    <template x-if="excelFile">
                        <div class="text-left">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center shrink-0">
                                    <i class="ti ti-file-spreadsheet text-xl text-blue-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-800 dark:text-white truncate" x-text="excelFile.name"></p>
                                    <p class="text-xs text-gray-400"
                                        x-text="formatBytes(excelFile.size) + ' · ' + excelCategories.length + ' kategori · ' + excelYears.length + ' tahun'"></p>
                                </div>
                                <button type="button" @click="resetExcel()"
                                    class="text-xs font-bold text-rose-500 hover:text-rose-700 flex items-center gap-1 shrink-0">
                                    <i class="ti ti-x"></i> Ganti
                                </button>
                            </div>

                            {{-- Preview --}}
                            <div x-show="excelPreview.length > 0"
                                class="mb-4 max-h-52 overflow-auto rounded-xl border border-gray-200 dark:border-gray-700">
                                <table class="w-full text-xs">
                                    <thead class="bg-gray-50 dark:bg-gray-800 sticky top-0">
                                        <tr>
                                            <template x-for="(col, i) in excelPreview[0]" :key="i">
                                                <th class="px-3 py-2 text-left font-bold text-gray-500 whitespace-nowrap" x-text="col ?? '-'"></th>
                                            </template>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                        <template x-for="(row, ri) in excelPreview.slice(1, 8)" :key="ri">
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                                <template x-for="(cell, ci) in row" :key="ci">
                                                    <td class="px-3 py-2 text-gray-600 dark:text-gray-400 whitespace-nowrap" x-text="cell ?? '-'"></td>
                                                </template>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                                <p class="text-[10px] text-gray-400 px-3 py-2 border-t border-gray-100"
                                    x-text="'Preview 7 dari ' + (excelPreview.length - 1) + ' baris'"></p>
                            </div>

                            {{-- Pilih kolom kategori --}}
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">Mapping Kolom</p>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-bold text-blue-500 mb-1.5">Kolom Kategori <span class="text-red-400">*</span></label>
                                        <select x-model="excelColCategory" name="col_category"
                                            class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-xs dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Pilih kolom...</option>
                                            <template x-for="h in excelHeaders" :key="h">
                                                <option :value="h" x-text="h" :selected="excelColCategory === h"></option>
                                            </template>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-blue-400 mb-1.5">Kolom Tahun (otomatis)</label>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            <template x-for="y in excelYears" :key="y">
                                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 text-[10px] font-bold rounded-lg" x-text="y"></span>
                                            </template>
                                            <span x-show="excelYears.length === 0" class="text-xs text-gray-400">Pilih kolom kategori dulu</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <input type="hidden" name="input_mode" value="excel" x-show="inputMode === 'excel'">
            </div>

            {{-- Hidden JSON payload — diisi oleh onSubmit sebelum form dikirim --}}
            <input type="hidden" name="input_mode" :value="inputMode">
            <input type="hidden" name="grid_json" id="grid_json_input" value="">
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('statistics.index') }}"
                class="px-6 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="button" onclick="submitStatisticForm()"
                class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                Simpan
            </button>
        </div>

    </div>
    </form>
</div>

<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
<script>
function createStatistic() {
    return {
        inputMode: 'grid',

        // ── Grid mode ──────────────────────────────────────────────────────
        years:      [],
        categories: [],
        newYear:    '',
        judulKolom: 'Kategori / Lapangan Usaha',

        init() {
            // Terima komponen dari judulPicker saat judul dipilih
            this.$el.addEventListener('load-components', (e) => {
                const { components, judulKolom } = e.detail;
                this.judulKolom = judulKolom || 'Kategori / Lapangan Usaha';
                // Isi kategori dari komponen master, preserve values yang sudah diisi
                this.categories = components.map(c => {
                    const existing = this.categories.find(x => x.name === c.nama);
                    const values   = existing ? existing.values : {};
                    this.years.forEach(y => { if (!(y in values)) values[y] = ''; });
                    return { name: c.nama, isSub: c.is_sub, values };
                });
            });
        },
        addYear() {
            const y = parseInt(this.newYear);
            if (!y || this.years.includes(y)) return;
            this.years.push(y);
            this.years.sort();
            this.categories.forEach(c => { if (!(y in c.values)) c.values[y] = ''; });
            this.newYear = '';
        },
        removeYear(yi) {
            const y = this.years[yi];
            this.years.splice(yi, 1);
            this.categories.forEach(c => delete c.values[y]);
        },
        addCategory(isSub = false) {
            const values = {};
            this.years.forEach(y => { values[y] = ''; });
            this.categories.push({ name: '', isSub, values });
        },
        removeCategory(ci) {
            this.categories.splice(ci, 1);
        },
        // Dipanggil saat toggle sub/utama — tidak perlu ubah nama, prefix ditambah di gridJson
        syncPrefix(ci) {
            // tidak ada side-effect, prefix dihandle di getter gridJson
        },

        // ── Excel mode ─────────────────────────────────────────────────────
        excelFile:         null,
        excelPreview:      [],
        excelHeaders:      [],
        excelYears:        [],
        excelCategories:   [],
        excelColCategory:  '',

        handleDrop(e)       { const f = e.dataTransfer.files[0]; if (f) this.parseExcel(f); },
        handleExcelUpload(e){ const f = e.target.files[0];       if (f) this.parseExcel(f); },
        resetExcel()        {
            this.excelFile = null; this.excelPreview = []; this.excelHeaders = [];
            this.excelYears = []; this.excelCategories = []; this.excelColCategory = '';
        },

        parseExcel(file) {
            this.excelFile = file;
            const reader  = new FileReader();
            reader.onload = (e) => {
                const wb      = XLSX.read(new Uint8Array(e.target.result), { type: 'array' });
                const ws      = wb.Sheets[wb.SheetNames[0]];
                const rawRows = XLSX.utils.sheet_to_json(ws, { header: 1, defval: null });

                this.excelPreview = rawRows;
                this.excelHeaders = rawRows[0] ? rawRows[0].map(String) : [];

                // Auto-detect kolom kategori (kolom pertama non-numerik)
                const firstCol = this.excelHeaders[0] || '';
                this.excelColCategory = firstCol;

                // Kolom tahun = semua kolom selain kategori yang isinya angka tahun
                this.excelYears = this.excelHeaders.filter((h, i) => {
                    if (i === 0) return false;
                    return /^\d{4}$/.test(String(h).trim());
                });

                // Build kategori dari kolom yg dipilih
                this.buildExcelCategories();
            };
            reader.readAsArrayBuffer(file);
        },

        buildExcelCategories() {
            if (!this.excelColCategory || this.excelPreview.length < 2) return;
            const catIdx = this.excelHeaders.indexOf(this.excelColCategory);
            this.excelCategories = this.excelPreview.slice(1)
                .map(row => row[catIdx])
                .filter(v => v !== null && v !== '');
        },

        formatBytes(b) {
            return b < 1024 ? b+' B' : b < 1048576 ? (b/1024).toFixed(1)+' KB' : (b/1048576).toFixed(1)+' MB';
        },

        // Parse format angka Indonesia maupun internasional
        // Contoh input yang didukung:
        //   159.497,23  → 159497.23
        //   159,497.23  → 159497.23
        //   -6,75       → -6.75
        //   471.27      → 471.27
        //   159497.23   → 159497.23
        parseIndonesian(val) {
            if (val === '' || val === '-' || val === null || val === undefined) return val;
            let s = String(val).trim();
            // Deteksi format: jika ada titik DAN koma
            if (s.includes('.') && s.includes(',')) {
                const dotPos   = s.lastIndexOf('.');
                const commaPos = s.lastIndexOf(',');
                if (commaPos > dotPos) {
                    // Format Indonesia: 159.497,23 → titik = ribuan, koma = desimal
                    s = s.replace(/\./g, '').replace(',', '.');
                } else {
                    // Format Inggris: 159,497.23 → koma = ribuan, titik = desimal
                    s = s.replace(/,/g, '');
                }
            } else if (s.includes(',')) {
                // Hanya koma → desimal: -6,75 → -6.75
                s = s.replace(',', '.');
            }
            // Hanya titik → sudah format standar atau ribuan tanpa desimal
            const num = parseFloat(s);
            return isNaN(num) ? val : num;
        }
    }
}

function judulPicker() {
    return {
        kecil: '', besar: '',
        init() {
            const oldId = '{{ old('statistic_title_id') }}';
            if (oldId) this.fetchInterpretasi(oldId);
        },
        async fetchInterpretasi(id) {
            this.kecil = ''; this.besar = '';
            if (!id) return;
            try {
                const data = await (await fetch(`/statistic-titles/${id}/interpretasi`)).json();
                this.kecil = data.interpretasi_lebih_kecil || '';
                this.besar = data.interpretasi_lebih_besar || '';

                // Jika ada komponen terdaftar, load ke grid otomatis
                if (data.components && data.components.length > 0) {
                    this.$dispatch('load-components', {
                        components: data.components,
                        judulKolom: data.judul_kolom || 'Kategori'
                    });
                }
            } catch(e) {}
        }
    }
}

function submitStatisticForm() {
    const rows = [];

    // Baca tiap baris dari DOM input yang di-render Alpine
    const categoryInputs = document.querySelectorAll('input[name^="grid"][name$="[category]"]');

    categoryInputs.forEach(catInput => {
        // Ambil index baris: grid[0][category] → 0
        const match = catInput.name.match(/grid\[(\d+)\]/);
        if (!match) return;
        const ci = match[1];

        const rawName = catInput.value.trim();
        if (!rawName) return;

        // Cek apakah sub-kategori (row punya class bg-indigo)
        const row    = catInput.closest('tr');
        const isSub  = row && row.classList.toString().includes('indigo');
        const xLabel = isSub ? '· ' + rawName : rawName;

        // Cari semua value input di baris yang sama: grid[ci][values][YEAR]
        const valueInputs = document.querySelectorAll(`input[name^="grid[${ci}][values]"]`);
        valueInputs.forEach(valInput => {
            // Ambil tahun dari nama: grid[0][values][2024] → 2024
            const yearMatch = valInput.name.match(/\[values\]\[(\d+)\]/);
            if (!yearMatch) return;
            const year = yearMatch[1];
            const raw  = valInput.value.trim();
            if (!raw || raw === '-') return;

            // Parse format Indonesia
            let s = raw;
            if (s.includes('.') && s.includes(',')) {
                s = s.lastIndexOf(',') > s.lastIndexOf('.')
                    ? s.replace(/\./g, '').replace(',', '.')
                    : s.replace(/,/g, '');
            } else if (s.includes(',')) {
                s = s.replace(',', '.');
            }
            const num = parseFloat(s);
            if (!isNaN(num)) {
                rows.push({ x_label: xLabel, y_label: String(year), value: num });
            }
        });
    });

    document.getElementById('grid_json_input').value = JSON.stringify(rows);
    document.getElementById('statisticForm').submit();
}
</script>
@endsection