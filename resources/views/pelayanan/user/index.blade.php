@extends('layouts.app')

@section('content')
<div class="p-6">

@if(session('success'))
<div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
    {{ session('error') }}
</div>
@endif

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Manajemen User</h1>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">No</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Nama Lengkap</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">No. WhatsApp</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Email</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Password</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $i => $u)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-600">{{ $i + 1 }}.</td>
                    <td class="px-6 py-4 text-gray-700">{{ $u->nama_lengkap ?? $u->name }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $u->nomor_wa ?? '08 11-xxxx-xxxx' }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $u->email }}</td>
                    <td class="px-6 py-4 text-gray-500 tracking-widest">••••••</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <form action="{{ route('pelayanan.user.destroy', $u->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>

                            <a href="{{ route('pelayanan.user.show', $u->id) }}" 
   class="inline-flex items-center gap-1 border border-blue-300 text-blue-600 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
    Detail <i class="ti ti-chevrons-right text-sm"></i>
</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">
                    <i class="ti ti-user-off text-3xl block mb-2"></i>Belum ada user
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection