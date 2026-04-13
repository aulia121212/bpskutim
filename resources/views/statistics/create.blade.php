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
                    {{-- x-model untuk tracking pilihan indikator --}}
                    <select name="indikator_data" x-model="selectedIndikator" @change="resetJudul()"
                        class="w-full appearance-none border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Indikator</option>
                        <option value="indikator_ekonomi">Indikator Ekonomi</option>
                        <option value="indikator_ketenagakerjaan">Indikator Ketenagakerjaan</option>
                        <option value="indikator_sosial">Indikator Sosial</option>
                        <option value="indikator_pembangunan_manusia">Indikator Pembangunan Manusia</option>
                        <option value="gender  ">Gender</option>
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-semibold text-blue-500">Judul Data</label>
                    <a href="{{ route('statistic-titles.index') }}" target="_blank"
                        class="text-[10px] font-bold text-blue-400 hover:text-blue-600 flex items-center gap-1">
                        <i class="ti ti-settings text-xs"></i> Kelola Judul
                    </a>
                </div>
                <div class="relative">
                    {{-- :disabled akan mengunci dropdown jika indikator kosong --}}
                    <select name="statistic_title_id" 
                        x-model="selectedTitleId"
                        :disabled="!selectedIndikator"
                        @change="fetchInterpretasi($event.target.value)"
                        class="w-full appearance-none border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm disabled:opacity-50 disabled:bg-gray-50 text-gray-700 dark:text-gray-300 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Judul Data</option>
                        @foreach($statisticTitles as $title)
                            {{-- x-show memfilter judul berdasarkan indikator yang dipilih --}}
                            <option 
                                value="{{ $title->id }}" 
                                x-show="selectedIndikator === '{{ $title->indikator_data }}'"
                                {{-- Kita juga disable opsinya agar tidak terpilih via keyboard jika hidden --}}
                                :disabled="selectedIndikator !== '{{ $title->indikator_data }}'"
                            >
                                {{ $title->judul_data }}
                            </option>
                        @endforeach
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                </div>

                {{-- Preview Interpretasi --}}
                <div x-show="hasAny" x-cloak
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

                    <div x-show="hasTetap">
                        <p class="text-[10px] font-bold text-gray-400 mb-0.5"><i class="ti ti-minus"></i> Tetap</p>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2" x-text="tetap"></p>
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
                        <option value="Paser">Paser</option>
                        <option value="Kutai Barat">Kutai Barat</option>
                        <option value="Kutai Kartanegara">Kutai Kartanegara</option>
                        <option value="Kabupaten Kutai Timur">Kutai Timur</option>
                        <option value="Berau">Berau</option>
                        <option value="Penajam Paser Utara">Penajam Paser Utara</option>
                        <option value="Mahakam Ulu">Mahakam Ulu</option>
                        <option value="Balikpapan">Balikpapan</option>
                        <option value="Samarinda">Samarinda</option>
                        <option value="Bontang">Bontang</option>
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

        {{-- NILAI DATA (GRID TABLE) --}}
        <div class="border-t border-gray-100 dark:border-gray-800 pt-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-semibold text-blue-500">Nilai Data</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Baris = <span class="font-semibold text-gray-600 dark:text-gray-300">Kategori/Lapangan Usaha</span> &nbsp;·&nbsp;
                        Kolom = <span class="font-semibold text-gray-600 dark:text-gray-300">Tahun</span>
                    </p>
                </div>
                <div class="flex items-center gap-2 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                    <i class="ti ti-table text-blue-500 text-sm"></i>
                    <span class="text-xs font-bold text-blue-600">Tabel Grid</span>
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

                <input type="hidden" name="years_list" :value="JSON.stringify(years)">
                <input type="hidden" name="grid_json" id="grid_json_input" value="">
            </div>
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

@push('scripts')
<script>
function createStatistic() {
    return {
        // State Baru
        selectedIndikator: '{{ old('indikator_data') ?? '' }}',
        selectedTitleId: '{{ old('statistic_title_id') ?? '' }}',
        
        // State Interpretasi
        kecil: '',
        besar: '',
        tetap: '',

        // State Grid
        years: [],
        categories: [],
        newYear: '',
        judulKolom: 'Kategori / Lapangan Usaha',

        get hasAny() { return !!(this.kecil || this.besar || this.tetap); },
        get hasTetap() { return !!(this.tetap); },

        init() {
            // Re-fetch jika ada data lama (old input)
            if (this.selectedTitleId) {
                this.fetchInterpretasi(this.selectedTitleId);
            }

            this.$el.addEventListener('load-components', (e) => {
                const { components, judulKolom } = e.detail;
                this.judulKolom = judulKolom || 'Kategori / Lapangan Usaha';
                this.categories = components.map(c => {
                    const existing = this.categories.find(x => x.name === c.nama);
                    const values = existing ? existing.values : {};
                    this.years.forEach(y => { if (!(y in values)) values[y] = ''; });
                    return { name: c.nama, isSub: c.is_sub, values };
                });
            });
        },

        resetJudul() {
            this.selectedTitleId = '';
            this.kecil = '';
            this.besar = '';
            this.tetap = '';
        },

        async fetchInterpretasi(id) {
            if (!id) return;
            try {
                const response = await fetch(`/statistic-titles/${id}/interpretasi`);
                const data = await response.json();
                
                this.kecil = data.interpretasi_lebih_kecil || '';
                this.besar = data.interpretasi_lebih_besar || '';
                this.tetap = data.interpretasi_tetap || '';

                if (data.components && data.components.length > 0) {
                    this.$dispatch('load-components', {
                        components: data.components,
                        judulKolom: data.judul_kolom || 'Kategori'
                    });
                }
            } catch(e) {
                console.error('Error fetching data:', e);
            }
        },

        // Fungsi Grid (Tetap Sama)
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

function submitStatisticForm() {
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
    document.getElementById('statisticForm').submit();
}
</script>
@endpush
@endsection