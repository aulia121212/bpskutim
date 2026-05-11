@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Judul & Interpretasi Data</h1>
            <p class="text-sm text-gray-400 mt-1">Kelola master judul data, label kolom, komponen, dan interpretasi</p>
        </div>
        <button @click="$dispatch('open-modal-add')"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#035f9c] text-white hover:bg-white hover:text-[#035f9c] border border-transparent hover:border-[#035f9c] text-sm font-semibold rounded-xl transition shadow-lg shadow-blue-600/20">
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
                    <th class="text-left px-4 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest w-10">No</th>
                    <th class="text-left px-4 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Indikator Data</th>
                    <th class="text-left px-4 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Judul Data</th>
                    <th class="text-left px-4 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Judul Kolom</th>
                    <th class="text-left px-4 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Komponen</th>
                    <th class="text-left px-4 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Dibuat</th>
                    <th class="text-center px-4 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                @forelse ($titles as $title)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition">
                    <td class="px-4 py-4 text-gray-400 text-xs font-medium">{{ $loop->iteration }}</td>

                    <td class="px-4 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-blue-50 text-[#035f9c] dark:bg-blue-900/20">
                            {{ Str::title(Str::replace('_', ' ', $title->indikator_data)) }}
                        </span>
                    </td>

                    <td class="px-4 py-4 font-semibold text-gray-800 dark:text-white max-w-[200px]">
                        <p class="line-clamp-2 text-sm leading-snug">{{ $title->judul_data }}</p>
                    </td>

                    <td class="px-4 py-4 text-xs text-gray-500 dark:text-gray-400">
                        {{ $title->judul_kolom ?: '—' }}
                    </td>

                    <td class="px-4 py-4">
                        @if($title->components->count() > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach($title->components->take(3) as $comp)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-semibold
                                        {{ $comp->is_sub ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20' : 'bg-gray-100 text-gray-600 dark:bg-gray-800' }}">
                                        {{ $comp->is_sub ? '· ' : '' }}{{ Str::limit($comp->nama, 18) }}
                                    </span>
                                @endforeach
                                @if($title->components->count() > 3)
                                    <span class="text-[10px] text-gray-400 font-semibold px-1 self-center">
                                        +{{ $title->components->count() - 3 }} lainnya
                                    </span>
                                @endif
                            </div>
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>

                    <td class="px-4 py-4 text-xs text-gray-400 whitespace-nowrap">
                        {{ $title->created_at->format('d M Y') }}
                    </td>

                    {{-- Aksi: 3 tombol selalu tampil --}}
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-1.5">

                            {{-- Detail → show page (read-only) --}}
                            <!-- <a href="{{ route('statistic-titles.show', $title->id) }}"
                                title="Lihat Detail"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-blue-900/30 dark:hover:text-blue-400 transition">
                                <i class="ti ti-eye text-sm"></i>
                            </a> -->

                            {{-- Edit → edit page --}}
                            <a href="{{ route('statistic-titles.edit', $title->id) }}"
                                title="Edit"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-amber-50 hover:text-amber-600 dark:hover:bg-amber-900/30 dark:hover:text-amber-400 transition">
                                <i class="ti ti-pencil text-sm"></i>
                            </a>

                            {{-- Hapus --}}
                            <form method="POST" action="{{ route('statistic-titles.destroy', $title->id) }}"
                                onsubmit="return confirm('Yakin hapus judul ini? Semua komponen terkait akan ikut terhapus.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    title="Hapus"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-rose-50 hover:text-rose-600 dark:hover:bg-rose-900/30 dark:hover:text-rose-400 transition">
                                    <i class="ti ti-trash text-sm"></i>
                                </button>
                            </form>

                            <a href="{{ route('statistic-titles.show', $title->id) }}"
                               class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-[#035f9c] text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                Detail <i class="ti ti-chevron-right text-sm"></i>
                            </a>

                            <!-- <a href="{{ route('statistic-titles.edit', $title->id) }}"
                                title="Lihat Detail"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-blue-900/30 dark:hover:text-blue-400 transition">
                                <i class="ti ti-eye text-sm"></i>
                            </a> -->


                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <i class="ti ti-database-off text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-sm font-semibold text-gray-400">Belum ada judul data</p>
                            <p class="text-xs text-gray-300">Klik tombol "Tambah Judul" untuk memulai</p>
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
<div x-data="{ open: false, ...componentForm() }" @open-modal-add.window="open = true; reset()">
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click="open = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
        <div x-show="open"
            x-transition:enter="transition duration-200 ease-out"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="relative w-full max-w-2xl bg-white dark:bg-gray-950 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl p-6 z-10 max-h-[90vh] overflow-y-auto">

            <h3 class="text-base font-bold text-gray-800 dark:text-white mb-5">Tambah Judul Data</h3>

            <form method="POST" action="{{ route('statistic-titles.store') }}">
                @csrf
                @include('statistic-titles._form')
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="open = false"
                        class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#035f9c] hover:bg-blue-700 text-white text-sm font-semibold transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function componentForm(existing = []) {
    return {
        components: existing.length > 0 ? existing : [],
        addComponent(isSub = false) {
            this.components.push({
                nama: '', is_sub: isSub, showInterp: false,
                satuan: '',
                interpretasi_lebih_kecil: '',
                interpretasi_lebih_besar: '',
                interpretasi_tetap: '',
            });
        },
        removeComponent(i) {
            this.components.splice(i, 1);
        },
        reset() {
            this.components = [];
        }
    }
}
</script>
@endsection