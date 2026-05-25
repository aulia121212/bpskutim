@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">
                Super Admin
            </p>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Admin Pelayanan
            </h1>
        </div>

        <a href="{{ route('superadmin.admin-pelayanan.create') }}"
            class="inline-flex items-center gap-2 bg-[#035f9c] text-white hover:bg-white hover:text-[#035f9c] text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">

            <i class="ti ti-plus"></i>

            TAMBAH ADMIN BARU

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

                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        Nama Lengkap
                    </th>

                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        Email
                    </th>

                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        Password
                    </th>

                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        No WhatsApp
                    </th>

                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        Asal Instansi
                    </th>

                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($admins as $admin)

                <tr class="border-b border-gray-50 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">

                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">
                        {{ $admin->name }}
                    </td>

                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                        {{ $admin->email }}
                    </td>

                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400 tracking-widest">
                        ••••••••••
                    </td>

                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                        {{ $admin->no_whatsapp ?? '-' }}
                    </td>

                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                        {{ $admin->asal_instansi ?? 'BPS Kutai Timur' }}
                    </td>

                    <td class="px-6 py-4">

                        <div class="flex items-center gap-2">

                            {{-- Edit --}}
                            <a href="{{ route('superadmin.admin-pelayanan.edit', $admin->id) }}"
                                class="p-1.5 text-gray-400 hover:text-blue-600 transition">

                                <i class="ti ti-pencil"></i>

                            </a>

                            {{-- Hapus --}}
                            <button
                                type="button"
                                onclick="openDeleteAdminModal(
                                    '{{ route('superadmin.admin-pelayanan.destroy', $admin->id) }}',
                                    '{{ $admin->name }}'
                                )"
                                class="p-1.5 text-gray-400 hover:text-red-500 transition"
                            >
                                <i class="ti ti-trash"></i>
                            </button>

                            {{-- Detail --}}
                            <a href="{{ route('superadmin.admin-pelayanan.show', $admin->id) }}"
                                class="inline-flex items-center gap-1 border border-blue-300 text-blue-600 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">

                                Detail

                                <i class="ti ti-chevrons-right text-sm"></i>

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

{{-- Modal Hapus Admin --}}
<div
    id="deleteAdminModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm"
>

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 animate-fadeIn">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-4">

            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">

                <i class="ti ti-trash text-red-500 text-xl"></i>

            </div>

            <div>

                <h3 class="text-lg font-bold text-gray-800">
                    Hapus Admin
                </h3>

                <p class="text-sm text-gray-500">
                    Data admin yang dihapus tidak dapat dikembalikan.
                </p>

            </div>

        </div>

        {{-- Text --}}
        <p class="text-sm text-gray-600 mb-6">

            Apakah Anda yakin ingin menghapus admin

            <span id="deleteAdminName"
                class="font-semibold text-gray-800">
            </span>?

        </p>

        {{-- Action --}}
        <div class="flex justify-end gap-3">

            <button
                type="button"
                onclick="closeDeleteAdminModal()"
                class="px-4 py-2 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition"
            >
                Batal
            </button>

            <form id="deleteAdminForm" method="POST">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="px-4 py-2 rounded-xl bg-red-500 text-white hover:bg-red-600 transition"
                >
                    Ya, Hapus
                </button>

            </form>

        </div>

    </div>

</div>

{{-- Script --}}
<script>

    function openDeleteAdminModal(actionUrl, adminName) {

        document.getElementById('deleteAdminForm').action = actionUrl;

        document.getElementById('deleteAdminName').innerText = adminName;

        const modal = document.getElementById('deleteAdminModal');

        modal.classList.remove('hidden');

        modal.classList.add('flex');

        document.body.style.overflow = 'hidden';
    }

    function closeDeleteAdminModal() {

        const modal = document.getElementById('deleteAdminModal');

        modal.classList.remove('flex');

        modal.classList.add('hidden');

        document.body.style.overflow = '';
    }

    // ESC untuk close modal
    document.addEventListener('keydown', function(e) {

        if (e.key === 'Escape') {

            closeDeleteAdminModal();

        }

    });

    // Klik luar modal untuk close
    document.getElementById('deleteAdminModal').addEventListener('click', function(e) {

        if (e.target === this) {

            closeDeleteAdminModal();

        }

    });

</script>

@endsection