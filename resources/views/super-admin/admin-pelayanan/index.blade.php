@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Super Admin</p>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Admin Pelayanan        </h1>
        </div>
        <a href="{{ route('superadmin.admin-data-statistik.create') }}"
            class="inline-flex items-center gap-2 bg-[#035f9c] text-white hover:bg-white hover:text-[#035f9c] text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">
            <i class="ti ti-plus"></i> TAMBAH ADMIN BARU
        </a>
    </div>

    {{-- Success --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-4">
        {{ session('success') }}
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Nama Lengkap</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Email</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Password</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">No WhatsApp</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Asal Instansi</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr class="border-b border-gray-50 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">{{ $admin->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $admin->email }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400 tracking-widest">••••••••••</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $admin->no_whatsapp ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $admin->asal_instansi ?? 'BPS Kutai Timur' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('superadmin.admin-data-statistik.edit', $admin->id) }}"
                                class="p-1.5 text-gray-400 hover:text-blue-600 transition">
                                <i class="ti ti-pencil"></i>
                            </a>
                            <form action="{{ route('superadmin.admin-data-statistik.destroy', $admin->id) }}"
                                method="POST" onsubmit="return confirm('Yakin hapus admin ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 transition">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('superadmin.admin-data-statistik.show', $admin->id) }}"
                                class="inline-flex items-center gap-1 border border-blue-300 text-blue-600 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
                                Detail <i class="ti ti-chevrons-right text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="ti ti-users-off text-3xl block mb-2"></i>
                        Belum ada admin terdaftar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection