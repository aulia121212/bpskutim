@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Manajemen</p>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Publikasi</h1>
        </div>

        {{-- Tombol tambah hanya muncul kalau belum ada data --}}
        @if(!$publikasi)
            <a href="{{ route('superadmin.publikasi.create') }}"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">
                <i class="ti ti-plus"></i> TAMBAH PUBLIKASI
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-4 flex items-center gap-2">
            <i class="ti ti-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm rounded-xl px-4 py-3 mb-4 flex items-center gap-2">
            <i class="ti ti-info-circle"></i> {{ session('info') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">No</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Link</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($publikasi)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-500">1.</td>
                        <td class="px-6 py-4">
                            <a href="{{ $publikasi->link }}" target="_blank"
                                class="inline-flex items-center gap-1 text-blue-600 hover:underline text-sm">
                                <i class="ti ti-external-link"></i>
                                {{ Str::limit($publikasi->link, 60) }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('superadmin.publikasi.edit', $publikasi->id) }}"
                                    class="p-1.5 text-gray-400 hover:text-blue-600 transition">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <form action="{{ route('superadmin.publikasi.destroy', $publikasi->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus link publikasi ini?')"
                                    class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 transition">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                            <i class="ti ti-link-off text-3xl block mb-2"></i>
                            Belum ada link publikasi
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection