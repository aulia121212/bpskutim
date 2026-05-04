<div class="space-y-4">

{{-- Indikator --}}
        <div>
            <label class="block text-sm font-semibold text-[#035f9c] mb-1">
                Indikator
            </label>
            <select name="indikator_data"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                <option value="">Pilih Indikator</option>
                <option value="indikator_ekonomi">Indikator Ekonomi</option>
                <option value="indikator_ketenagakerjaan">Indikator Kependudukan dan Ketenagakerjaan</option>
                <option value="indikator_sosial">Indikator Sosial</option>
                <option value="indikator_pembangunan_manusia">Indikator Pembangunan Manusia</option>
                <option value="gender">Gender</option>
            </select>
        </div>

    {{-- Judul Data --}}
    <div>
        <label class="block text-xs font-semibold text-[#035f9c] mb-1">Judul Data <span class="text-red-400">*</span></label>
        <input type="text" name="judul_data"
            value="{{ old('judul_data', $title->judul_data ?? '') }}"
            placeholder="Contoh: Struktur PDRB Menurut Lapangan Usaha (persen)"
            class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('judul_data')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- Judul Kolom --}}
    <div>
        <label class="block text-xs font-semibold text-[#035f9c] mb-1">
            Judul Kolom Kategori
            <span class="font-normal text-gray-400 normal-case ml-1">(header kolom pertama tabel, misal: "Lapangan Usaha")</span>
        </label>
        <input type="text" name="judul_kolom"
            value="{{ old('judul_kolom', $title->judul_kolom ?? '') }}"
            placeholder="Lapangan Usaha"
            class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    {{-- =========================================================== --}}
    {{-- KOMPONEN / KATEGORI                                         --}}
    {{-- =========================================================== --}}
    <div class="border-t border-gray-100 dark:border-gray-800 pt-4">
        <div class="flex items-center justify-between mb-3">
            <div>
                <p class="text-xs font-semibold text-[#035f9c]">Komponen / Kategori</p>
                <p class="text-[10px] text-gray-400 mt-0.5">Akan otomatis muncul sebagai baris di form input data</p>
            </div>
            <div class="flex gap-2">
                <button type="button" @click="addComponent(false)"
                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-[#035f9c] text-white text-xs font-bold hover:bg-white hover:text-[#035f9c] transition">
                    <i class="ti ti-plus text-xs"></i> Kategori
                </button>
                <button type="button" @click="addComponent(true)"
                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-indigo-500 text-xs font-bold hover:bg-indigo-100 transition">
                    <i class="ti ti-indent-increase text-xs"></i> Sub
                </button>
            </div>
        </div>

        {{-- List komponen --}}
        <div class="space-y-2" x-show="components.length > 0">
            <template x-for="(comp, i) in components" :key="i">
                <div class="rounded-xl border overflow-hidden"
                    :class="comp.is_sub
                        ? 'bg-indigo-50/60 dark:bg-indigo-900/10 border-indigo-100 dark:border-indigo-800'
                        : 'bg-gray-50 dark:bg-gray-800 border-gray-100 dark:border-gray-700'">

                    {{-- Header baris --}}
                    <div class="flex items-center gap-2 px-3 py-2" :class="comp.is_sub ? 'pl-7' : ''">
                        <span x-show="comp.is_sub" class="text-indigo-300 font-bold text-sm shrink-0">·</span>

                        <input type="text"
                            :name="'components[' + i + '][nama]'"
                            x-model="comp.nama"
                            :placeholder="comp.is_sub ? 'Nama sub-kategori...' : 'Nama kategori...'"
                            :class="comp.is_sub ? 'text-gray-500 italic text-xs' : 'text-gray-700 text-sm font-medium'"
                            class="flex-1 bg-transparent focus:outline-none dark:text-gray-300 placeholder-gray-300">

                        {{-- Satuan --}}
                        <input type="text"
                            :name="'components[' + i + '][satuan]'"
                            x-model="comp.satuan"
                            placeholder="satuan..."
                            class="w-24 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-2 py-1 text-xs text-gray-500 dark:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-400 shrink-0"
                            :title="'Satuan: ' + (comp.satuan || '-')">

                        <input type="hidden" :name="'components[' + i + '][is_sub]'" :value="comp.is_sub ? '1' : '0'">

                        {{-- Toggle expand interpretasi --}}
                        <button type="button" @click="comp.showInterp = !comp.showInterp"
                            :title="comp.showInterp ? 'Sembunyikan interpretasi' : 'Tambah interpretasi per kategori'"
                            :class="comp.showInterp ? 'text-[#035f9c] bg-[#035f9c]/10' : 'text-gray-300 hover:text-[#035f9c]'"
                            class="w-6 h-6 flex items-center justify-center rounded transition shrink-0">
                            <i class="ti ti-message-2 text-xs"></i>
                        </button>

                        {{-- Toggle sub/utama --}}
                        <button type="button" @click="comp.is_sub = !comp.is_sub"
                            :class="comp.is_sub ? 'text-indigo-400 hover:text-indigo-600' : 'text-gray-300 hover:text-indigo-400'"
                            class="w-6 h-6 flex items-center justify-center rounded transition shrink-0">
                            <i class="ti ti-indent-increase text-xs"></i>
                        </button>

                        <span class="text-gray-300 cursor-grab shrink-0"><i class="ti ti-grip-vertical text-sm"></i></span>

                        <button type="button" @click="removeComponent(i)"
                            class="w-6 h-6 flex items-center justify-center rounded text-gray-300 hover:text-rose-500 transition shrink-0">
                            <i class="ti ti-x text-xs"></i>
                        </button>
                    </div>

                    {{-- Expandable: Interpretasi per kategori (3 kolom) --}}
                    <div x-show="comp.showInterp" x-collapse
                        class="border-t px-3 pb-3 pt-2 grid grid-cols-3 gap-3"
                        :class="comp.is_sub
                            ? 'border-indigo-100 dark:border-indigo-800 bg-indigo-50/30'
                            : 'border-gray-100 dark:border-gray-700 bg-white/60 dark:bg-gray-900/20'">

                        {{-- Turun --}}
                        <div>
                            <label class="block text-[10px] font-bold text-green-500 mb-1 flex items-center gap-1">
                                <i class="ti ti-trending-down text-[10px]"></i> Interpretasi Turun
                            </label>
                            <textarea :name="'components[' + i + '][interpretasi_lebih_kecil]'"
                                x-model="comp.interpretasi_lebih_kecil" rows="3"
                                placeholder="Penjelasan jika kategori ini menurun..."
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-xs dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400 resize-none placeholder-gray-300"></textarea>
                        </div>

                        {{-- Naik --}}
                        <div>
                            <label class="block text-[10px] font-bold text-red-400 mb-1 flex items-center gap-1">
                                <i class="ti ti-trending-up text-[10px]"></i> Interpretasi Naik
                            </label>
                            <textarea :name="'components[' + i + '][interpretasi_lebih_besar]'"
                                x-model="comp.interpretasi_lebih_besar" rows="3"
                                placeholder="Penjelasan jika kategori ini meningkat..."
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-xs dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-red-400 resize-none placeholder-gray-300"></textarea>
                        </div>

                        {{-- Tetap --}}
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 mb-1 flex items-center gap-1">
                                <i class="ti ti-minus text-[10px]"></i> Interpretasi Tetap
                            </label>
                            <textarea :name="'components[' + i + '][interpretasi_tetap]'"
                                x-model="comp.interpretasi_tetap" rows="3"
                                placeholder="Penjelasan jika kategori ini tidak berubah..."
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-xs dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 resize-none placeholder-gray-300"></textarea>
                        </div>

                        {{-- Preview badge --}}
                        <div class="col-span-3 flex gap-2 flex-wrap"
                            x-show="comp.interpretasi_lebih_kecil || comp.interpretasi_lebih_besar || comp.interpretasi_tetap">
                            <span x-show="comp.interpretasi_lebih_kecil"
                                class="inline-flex items-center gap-1 text-[10px] font-semibold text-green-600 bg-green-50 border border-green-100 rounded-md px-2 py-0.5">
                                <i class="ti ti-check text-[9px]"></i> Interpretasi turun tersimpan
                            </span>
                            <span x-show="comp.interpretasi_lebih_besar"
                                class="inline-flex items-center gap-1 text-[10px] font-semibold text-red-500 bg-red-50 border border-red-100 rounded-md px-2 py-0.5">
                                <i class="ti ti-check text-[9px]"></i> Interpretasi naik tersimpan
                            </span>
                            <span x-show="comp.interpretasi_tetap"
                                class="inline-flex items-center gap-1 text-[10px] font-semibold text-gray-500 bg-gray-50 border border-gray-200 rounded-md px-2 py-0.5">
                                <i class="ti ti-check text-[9px]"></i> Interpretasi tetap tersimpan
                            </span>
                        </div>
                    </div>

                </div>
            </template>
        </div>

        {{-- Empty state --}}
        <div x-show="components.length === 0"
            class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl py-6 text-center">
            <p class="text-xs text-gray-400">Belum ada komponen — klik <strong>+ Kategori</strong> untuk menambah</p>
        </div>
    </div>

    {{-- =========================================================== --}}
    {{-- INTERPRETASI DEFAULT (fallback jika kategori tidak punya)   --}}
    {{-- =========================================================== --}}
    <div class="border-t border-gray-100 dark:border-gray-800 pt-4">
        <p class="text-xs font-semibold text-[#035f9c] mb-1">Interpretasi Default</p>
        <p class="text-[10px] text-gray-400 mb-3">Digunakan sebagai fallback jika kategori tidak memiliki interpretasi sendiri</p>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-green-500 mb-1">
                    <i class="ti ti-trending-down text-xs"></i> Lebih Kecil (Turun)
                </label>
                <textarea name="interpretasi_lebih_kecil" rows="3"
                    placeholder="Penjelasan jika data mengalami penurunan..."
                    class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400 resize-none">{{ old('interpretasi_lebih_kecil', $title->interpretasi_lebih_kecil ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-red-400 mb-1">
                    <i class="ti ti-trending-up text-xs"></i> Lebih Besar (Naik)
                </label>
                <textarea name="interpretasi_lebih_besar" rows="3"
                    placeholder="Penjelasan jika data mengalami kenaikan..."
                    class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-red-400 resize-none">{{ old('interpretasi_lebih_besar', $title->interpretasi_lebih_besar ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    <i class="ti ti-minus text-xs"></i> Tetap
                </label>
                <textarea name="interpretasi_tetap" rows="3"
                    placeholder="Penjelasan jika data tidak berubah..."
                    class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 resize-none">{{ old('interpretasi_tetap', $title->interpretasi_tetap ?? '') }}</textarea>
            </div>
        </div>
    </div>

</div>