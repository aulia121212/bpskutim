@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Data Statistik</h1>
        <a href="{{ route('statistics.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
            <i class="ti ti-plus text-base"></i>
            TAMBAH DATA STATISTIK
        </a>
    </div>

    {{-- Search --}}
    <div class="mb-4">
        <div class="relative w-72">
            <input type="text" id="searchInput" placeholder="Cari data..."
                class="w-full border border-gray-200 rounded-xl px-4 py-2 pl-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
            <i class="ti ti-search absolute left-3 top-2.5 text-gray-400"></i>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Indikator</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Judul</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Wilayah</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Status</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($statistics as $stat)
                <tr class="border-b border-gray-50 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $stat->indikator_data }}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $stat->judul_data }}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $stat->wilayah_data }}</td>
                    <td class="px-6 py-4">
                        @if($stat->status === 'published')
                            <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                                Published
                            </span>
                        @else
                            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('statistics.preview', $stat->id) }}"
                               class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                <i class="ti ti-eye text-sm"></i> Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="ti ti-database-off text-3xl block mb-2"></i>
                        Belum ada data statistik
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($statistics instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-6 flex justify-center">
        {{ $statistics->links() }}
    </div>
    @endif

</div>

<script>
// Simple client-side search
document.getElementById('searchInput').addEventListener('input', function () {
    const query = this.value.toLowerCase();
    document.querySelectorAll('#tableBody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(query) ? '' : 'none';
    });
});
</script>
@endsection