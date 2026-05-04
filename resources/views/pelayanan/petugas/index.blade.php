@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Manajemen Petugas</h1>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('pelayanan.petugas.create') }}"
            class="inline-flex items-center gap-2 bg-[#035f9c] text-white hover:bg-white hover:text-[#035f9c] text-sm font-semibold px-4 py-2 rounded-xl transition">
            <i class="ti ti-plus"></i> TAMBAH PETUGAS KONSULTASI
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">No</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Nama Lengkap</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Instansi</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Jabatan</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Bidang Keahlian</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($petugas as $i => $p)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-600">{{ $i + 1 }}.</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-gray-700">BPS Kutai Timur</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->jabatan }}</td>
                    <td class="px-6 py-4 text-gray-700">
                        @php $bidang = is_array($p->bidang_keahlian) ? $p->bidang_keahlian : json_decode($p->bidang_keahlian, true); @endphp
                        <div class="flex flex-wrap gap-1">
                            @foreach(array_slice($bidang ?? [], 0, 2) as $b)
                            <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full">{{ $b }}</span>
                            @endforeach
                            @if(count($bidang ?? []) > 2)
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">+{{ count($bidang) - 2 }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('pelayanan.petugas.edit', $p->id) }}" class="p-1.5 text-gray-400 hover:text-blue-600 transition">
                                <i class="ti ti-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('pelayanan.petugas.destroy', $p->id) }}" onsubmit="return confirm('Hapus petugas ini?')">
                                @csrf @method('DELETE')
                                <button class="p-1.5 text-gray-400 hover:text-red-500 transition"><i class="ti ti-trash"></i></button>
                            </form>
                            <a href="{{ route('pelayanan.petugas.show', $p->id) }}"
                                class="inline-flex items-center gap-1 border border-blue-300 text-blue-600 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
                                Detail <i class="ti ti-chevrons-right text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="ti ti-users-off text-3xl block mb-2"></i>Belum ada petugas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection