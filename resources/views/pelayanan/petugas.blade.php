@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Manajemen Petugas</h1>

    <div class="flex justify-end mb-4">
        <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
            <i class="ti ti-plus"></i> TAMBAH PETUGAS KONSULTASI
        </button>
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
                @forelse($petugas ?? [] as $i => $p)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-600">{{ $i + 1 }}.</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->instansi }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->jabatan }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->bidang_keahlian }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button class="p-1.5 text-gray-400 hover:text-blue-600 transition"><i class="ti ti-pencil"></i></button>
                            <button class="p-1.5 text-gray-400 hover:text-red-500 transition"><i class="ti ti-trash"></i></button>
                            <a href="#" class="inline-flex items-center gap-1 border border-blue-300 text-blue-600 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
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

{{-- Modal Tambah --}}
<div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Tambah Petugas</h3>
            <button onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="ti ti-x text-xl"></i></button>
        </div>
        <form method="POST" action="{{ route('pelayanan.petugas.store') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Instansi</label>
                <input type="text" name="instansi" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Jabatan</label>
                <input type="text" name="jabatan" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Bidang Keahlian</label>
                <input type="text" name="bidang_keahlian" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">Batal</button>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold">Simpan</button>
        </div>
        </form>
    </div>
</div>
@endsection