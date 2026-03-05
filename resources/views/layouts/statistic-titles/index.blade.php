@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Judul & Interpretasi Data</h1>
            <p class="text-sm text-gray-400 mt-1">Kelola master judul data beserta teks interpretasinya</p>
        </div>
        <button @click="$dispatch('open-modal-add')"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-blue-600/20">
            <i class="ti ti-plus"></i> Tambah Judul
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl">
            <i class="ti ti-circle-check text-lg"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50">
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest w-8">#</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Judul Data</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Interpretasi Lebih Kecil</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Interpretasi Lebih Besar</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Dibuat</th>
                    <th class="px-6 py-4 w-24"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                @forelse ($titles as $title)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition group" x-data="{ editOpen: false }">
                    <td class="px-6 py-4 text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">{{ $title->judul_data }}</td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 max-w-xs">
                        <p class="line-clamp-2 text-xs leading-relaxed">{{ $title->interpretasi_lebih_kecil ?: '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 max-w-xs">
                        <p class="line-clamp-2 text-xs leading-relaxed">{{ $title->interpretasi_lebih_besar ?: '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400">{{ $title->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            {{-- Edit Button --}}
                            <button @click="editOpen = true"
                                class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 text-blue-500 transition">
                                <i class="ti ti-pencil text-base"></i>
                            </button>
                            {{-- Delete Button --}}
                            <form method="POST" action="{{ route('statistic-titles.destroy', $title->id) }}"
                                onsubmit="return confirm('Hapus judul ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/20 text-rose-500 transition">
                                    <i class="ti ti-trash text-base"></i>
                                </button>
                            </form>
                        </div>

                        {{-- Edit Modal (inline per row) --}}
                        <div x-show="editOpen" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center p-4">
                            <div @click="editOpen = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
                            <div class="relative w-full max-w-lg bg-white dark:bg-gray-950 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl p-6 z-10">
                                <h3 class="text-base font-bold text-gray-800 dark:text-white mb-5">Edit Judul Data</h3>
                                <form method="POST" action="{{ route('statistic-titles.update', $title->id) }}">
                                    @csrf @method('PUT')
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-blue-500 mb-1">Judul Data</label>
                                            <input type="text" name="judul_data" value="{{ $title->judul_data }}"
                                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-blue-400 mb-1">Interpretasi Lebih Kecil</label>
                                            <textarea name="interpretasi_lebih_kecil" rows="3"
                                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ $title->interpretasi_lebih_kecil }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-blue-400 mb-1">Interpretasi Lebih Besar</label>
                                            <textarea name="interpretasi_lebih_besar" rows="3"
                                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ $title->interpretasi_lebih_besar }}</textarea>
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-3 mt-6">
                                        <button type="button" @click="editOpen = false"
                                            class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <i class="ti ti-database-off text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-sm font-semibold text-gray-400">Belum ada judul data</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($titles->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $titles->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ===================== MODAL TAMBAH ===================== --}}
<div x-data="{ open: false }" @open-modal-add.window="open = true">
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click="open = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
        <div x-show="open"
            x-transition:enter="transition duration-200 ease-out"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="relative w-full max-w-lg bg-white dark:bg-gray-950 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl p-6 z-10">

            <h3 class="text-base font-bold text-gray-800 dark:text-white mb-5">Tambah Judul Data</h3>

            <form method="POST" action="{{ route('statistic-titles.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-blue-500 mb-1">Judul Data</label>
                        <input type="text" name="judul_data" value="{{ old('judul_data') }}"
                            placeholder="Contoh: Persentase Penduduk Miskin"
                            class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('judul_data')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-400 mb-1">Interpretasi Lebih Kecil</label>
                        <textarea name="interpretasi_lebih_kecil" rows="3"
                            placeholder="Penjelasan jika data mengalami penurunan..."
                            class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('interpretasi_lebih_kecil') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-400 mb-1">Interpretasi Lebih Besar</label>
                        <textarea name="interpretasi_lebih_besar" rows="3"
                            placeholder="Penjelasan jika data mengalami kenaikan..."
                            class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('interpretasi_lebih_besar') }}</textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="open = false"
                        class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection