@extends('layouts.app')

@section('content')
<div class="p-6" x-data="editStatistic()">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Edit Data Statistik</h1>

    <form method="POST" action="{{ route('statistics.update', $statistic->id) }}" enctype="multipart/form-data" id="editStatisticForm">
    @csrf
    @method('PUT')

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
        @foreach($errors->all() as $error)
            <li class="text-sm text-red-600">{{ $error }}</li>
        @endforeach
    </div>
    @endif

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">

        {{-- Row 1: Indikator + Judul Data (read-only) --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-[#035f9c] mb-1">Indikator</label>
                <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50">
                    {{ ucwords(str_replace('_', ' ', $statistic->indikator_data)) }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#035f9c] mb-1">Judul Data</label>
                <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50">
                    {{ $statistic->judul_data }}
                </div>
            </div>
        </div>

        {{-- Row 2: Wilayah + File Referensi --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-[#035f9c] mb-1">Wilayah Data</label>
                <div class="relative">
                    <select name="wilayah_data"
                        class="w-full appearance-none border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#035f9c]">
                        @foreach(['Paser','Kutai Barat','Kutai Kartanegara','Kutai Timur','Berau','Penajam Paser Utara','Mahakam Ulu','Balikpapan','Samarinda','Bontang','Kalimantan Timur','Indonesia'] as $wil)
                        <option value="{{ $wil }}" {{ $statistic->wilayah_data === $wil ? 'selected' : '' }}>{{ $wil }}</option>
                        @endforeach
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
            <!-- <div>
                <label class="block text-sm font-semibold text-[#035f9c] mb-1">File Referensi (opsional, ganti jika perlu)</label>
                <label class="flex items-center justify-between border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-400 dark:bg-gray-800 cursor-pointer hover:bg-gray-50 transition">
                    <span id="file-label">
                         {{ $statistic->file_data ? basename($statistic->file_data) : 'Pilih file...' }}
                    </span>
                    <i class="ti ti-upload text-gray-400"></i>
                    <input type="file" name="file_data" accept=".pdf,.xlsx,.csv" class="hidden"
                        onchange="document.getElementById('file-label').textContent = this.files[0]?.name || 'Pilih file...'">
                </label>
                <p class="text-xs text-gray-400 mt-1">PDF, XLSX, CSV (maks 2MB). Kosongkan jika tidak ingin mengganti.</p>
            </div> -->
        </div>

        {{-- NILAI DATA (GRID TABLE EDITABLE) --}}
        <div class="border-t border-gray-100 dark:border-gray-800 pt-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-semibold text-[#035f9c]">Nilai Data</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Baris = <span class="font-semibold text-gray-600 dark:text-gray-300">Kategori</span> &nbsp;·&nbsp;
                        Kolom = <span class="font-semibold text-gray-600 dark:text-gray-300">Tahun</span>
                    </p>
                </div>
                <div class="flex items-center gap-2 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                    <i class="ti ti-table text-[#035f9c] text-sm"></i>
                    <span class="text-xs font-bold text-[#035f9c]">Tabel Grid</span>
                </div>
            </div>

            <div>
                {{-- Toolbar --}}
                <div class="flex items-center gap-3 mb-4 flex-wrap">
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

                    <button type="button" @click="addCategory(false)"
                        class="flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 dark:bg-blue-900/20 rounded-xl px-3 py-2 transition">
                        <i class="ti ti-layout-rows text-sm"></i> + Kategori
                    </button>

                    <button type="button" @click="addCategory(true)"
                        class="flex items-center gap-1.5 text-xs font-bold text-indigo-500 hover:text-indigo-700 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl px-3 py-2 transition">
                        <i class="ti ti-indent-increase text-sm"></i> + Sub-kategori
                    </button>
                </div>

                {{-- Grid Tabel --}}
                <div x-show="years.length > 0 && categories.length > 0" class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-700">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800">
                                <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-r border-gray-100 dark:border-gray-700 min-w-[240px]">
                                    Kategori
                                </th>
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

                                    <td class="border-b border-r border-gray-100 dark:border-gray-700 px-2 py-1">
                                        <div class="flex items-center gap-2" :class="cat.isSub ? 'pl-5' : ''">
                                            <span x-show="cat.isSub" class="text-indigo-300 text-xs font-bold shrink-0">·</span>
                                            <input type="text"
                                                :name="'grid[' + ci + '][category]'"
                                                x-model="cat.name"
                                                :class="cat.isSub
                                                    ? 'text-gray-600 dark:text-gray-400 italic text-xs'
                                                    : 'text-gray-800 dark:text-white font-semibold text-sm'"
                                                class="w-full bg-transparent px-2 py-1.5 focus:outline-none focus:bg-white dark:focus:bg-gray-800 rounded-lg transition">
                                        </div>
                                    </td>

                                    <template x-for="(year, yi) in years" :key="year">
                                        <td class="border-b border-r border-gray-100 dark:border-gray-700 px-2 py-1 text-center">
                                            <input type="text"
                                                :name="'grid[' + ci + '][values][' + year + ']'"
                                                x-model="cat.values[year]"
                                                @blur="cat.values[year] = parseIndonesian(cat.values[year])"
                                                :class="cat.isSub ? 'text-gray-500 text-xs' : 'text-gray-700 text-sm'"
                                                class="w-full bg-transparent px-2 py-1.5 text-center dark:text-gray-300 focus:outline-none focus:bg-white dark:focus:bg-gray-800 rounded-lg transition">
                                        </td>
                                    </template>

                                    <td class="border-b border-gray-100 dark:border-gray-700 px-2 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <button type="button" @click="cat.isSub = !cat.isSub"
                                                class="w-6 h-6 flex items-center justify-center rounded transition text-gray-300 hover:text-indigo-400">
                                                <i class="ti ti-indent-increase text-xs"></i>
                                            </button>
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

                <div x-show="years.length === 0 || categories.length === 0"
                    class="rounded-xl border border-dashed border-gray-200 dark:border-gray-700 py-8 text-center">
                    <i class="ti ti-table text-2xl text-gray-300 block mb-2"></i>
                    <p class="text-sm text-gray-400">Tambah tahun dan kategori untuk mulai mengisi data</p>
                </div>

                <input type="hidden" name="grid_json" id="grid_json_input" value="">
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('statistics.preview', $statistic->id) }}"
                class="px-6 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="button" onclick="submitEditForm()"
                class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                Simpan Perubahan
            </button>
        </div>

    </div>
    </form>
</div>

@push('scripts')
<script>
// Data existing dari server
const existingValues = @json($existingGrid);

function editStatistic() {
    // Parse existing data menjadi struktur years + categories
    const allYears = [...new Set(existingValues.map(v => v.y_label).filter(Boolean))].map(Number).sort();
    
    // Build categories dari x_label unik (pertahankan urutan asli)
    const seen = [];
    const catMap = {};
    existingValues.forEach(v => {
        if (!catMap[v.x_label]) {
            catMap[v.x_label] = {};
            seen.push(v.x_label);
        }
        if (v.y_label) {
            catMap[v.x_label][parseInt(v.y_label)] = v.value;
        }
    });

    const initialCategories = seen.map(xLabel => {
        const isSub = xLabel.startsWith('· ');
        const displayName = isSub ? xLabel.slice(2) : xLabel;
        const values = {};
        allYears.forEach(y => { values[y] = catMap[xLabel][y] ?? ''; });
        return { name: displayName, isSub, values };
    });

    return {
        years: allYears,
        categories: initialCategories,
        newYear: '',

        addYear() {
            const y = parseInt(this.newYear);
            if (!y || this.years.includes(y)) return;
            this.years.push(y);
            this.years.sort((a,b) => a - b);
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
        parseIndonesian(val) {
            if (!val || val === '-') return val;
            let s = String(val).trim();
            if (s.includes('.') && s.includes(',')) {
                s = s.lastIndexOf(',') > s.lastIndexOf('.') ? s.replace(/\./g, '').replace(',', '.') : s.replace(/,/g, '');
            } else if (s.includes(',')) {
                s = s.replace(',', '.');
            }
            const num = parseFloat(s);
            return isNaN(num) ? val : num;
        }
    }
}

function submitEditForm() {
    const rows = [];
    const categoryInputs = document.querySelectorAll('input[name^="grid"][name$="[category]"]');

    categoryInputs.forEach(catInput => {
        const match = catInput.name.match(/grid\[(\d+)\]/);
        if (!match) return;
        const ci = match[1];
        const rawName = catInput.value.trim();
        if (!rawName) return;

        const row = catInput.closest('tr');
        const isSub = row && row.classList.toString().includes('indigo');
        const xLabel = isSub ? '· ' + rawName : rawName;

        const valInputs = document.querySelectorAll(`input[name^="grid[${ci}][values]"]`);
        valInputs.forEach(valInput => {
            const yearMatch = valInput.name.match(/\[values\]\[(\d+)\]/);
            if (!yearMatch) return;
            const year = yearMatch[1];
            const raw = valInput.value.trim();
            if (!raw || raw === '-') return;

            let s = raw;
            if (s.includes('.') && s.includes(',')) {
                s = s.lastIndexOf(',') > s.lastIndexOf('.') ? s.replace(/\./g, '').replace(',', '.') : s.replace(/,/g, '');
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
    document.getElementById('editStatisticForm').submit();
}
</script>
@endpush
@endsection