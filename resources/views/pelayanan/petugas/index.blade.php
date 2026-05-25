@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>

            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">
                Admin Pelayanan
            </p>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Manajemen Petugas
            </h1>

        </div>

        <a href="{{ route('pelayanan.petugas.create') }}"
            class="inline-flex items-center gap-2 bg-[#035f9c] text-white hover:bg-white hover:text-[#035f9c] text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">

            <i class="ti ti-plus"></i>

            TAMBAH PETUGAS KONSULTASI

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
                        No
                    </th>

                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        Nama Lengkap
                    </th>

                    <!--
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        Instansi
                    </th>
                    -->

                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        Jabatan
                    </th>

                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        Bidang Keahlian
                    </th>

                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($petugas as $i => $p)

                <tr class="border-b border-gray-50 hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50 transition">

                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                        {{ $i + 1 }}.
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">
                        {{ $p->nama_lengkap }}
                    </td>

                    <!--
                    <td class="px-6 py-4 text-gray-700">
                        BPS Kutai Timur
                    </td>
                    -->

                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                        {{ $p->jabatan }}
                    </td>

                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">

                        @php
                            $bidang = is_array($p->bidang_keahlian)
                                ? $p->bidang_keahlian
                                : json_decode($p->bidang_keahlian, true);
                        @endphp

                        <div class="flex flex-wrap gap-1">

                            @foreach(array_slice($bidang ?? [], 0, 2) as $b)

                            <span class="text-xs bg-blue-50 text-[#035f9c] px-2 py-0.5 rounded-full">
                                {{ $b }}
                            </span>

                            @endforeach

                            @if(count($bidang ?? []) > 2)

                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                +{{ count($bidang) - 2 }}
                            </span>

                            @endif

                        </div>

                    </td>

                    <td class="px-6 py-4">

                        <div class="flex items-center gap-2">

                            {{-- Edit --}}
                            <a href="{{ route('pelayanan.petugas.edit', $p->id) }}"
                                class="p-1.5 text-gray-400 hover:text-blue-600 transition">

                                <i class="ti ti-pencil"></i>

                            </a>

                            {{-- Hapus --}}
                            <button
                                type="button"
                                onclick="openDeletePetugasModal(
                                    '{{ route('pelayanan.petugas.destroy', $p->id) }}',
                                    '{{ $p->nama_lengkap }}'
                                )"
                                class="p-1.5 text-gray-400 hover:text-red-500 transition"
                            >
                                <i class="ti ti-trash"></i>
                            </button>

                            {{-- Detail --}}
                            <a href="{{ route('pelayanan.petugas.show', $p->id) }}"
                                class="inline-flex items-center gap-1 border border-[#035f9c] text-[#035f9c] text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-[#035f9c] hover:text-white transition">

                                Detail

                                <i class="ti ti-chevrons-right text-sm"></i>

                            </a>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">

                        <i class="ti ti-users-off text-3xl block mb-2"></i>

                        Belum ada petugas

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- Modal Hapus Petugas --}}
<div
    id="deletePetugasModal"
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
                    Hapus Petugas
                </h3>

                <p class="text-sm text-gray-500">
                    Data petugas yang dihapus tidak dapat dikembalikan.
                </p>

            </div>

        </div>

        {{-- Text --}}
        <p class="text-sm text-gray-600 mb-6">

            Apakah Anda yakin ingin menghapus petugas

            <span id="deletePetugasName"
                class="font-semibold text-gray-800">
            </span>?

        </p>

        {{-- Action --}}
        <div class="flex justify-end gap-3">

            <button
                type="button"
                onclick="closeDeletePetugasModal()"
                class="px-4 py-2 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition"
            >
                Batal
            </button>

            <form id="deletePetugasForm" method="POST">

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

    function openDeletePetugasModal(actionUrl, petugasName) {

        document.getElementById('deletePetugasForm').action = actionUrl;

        document.getElementById('deletePetugasName').innerText = petugasName;

        const modal = document.getElementById('deletePetugasModal');

        modal.classList.remove('hidden');

        modal.classList.add('flex');

        document.body.style.overflow = 'hidden';
    }

    function closeDeletePetugasModal() {

        const modal = document.getElementById('deletePetugasModal');

        modal.classList.remove('flex');

        modal.classList.add('hidden');

        document.body.style.overflow = '';
    }

    // ESC untuk close modal
    document.addEventListener('keydown', function(e) {

        if (e.key === 'Escape') {

            closeDeletePetugasModal();

        }

    });

    // Klik luar modal untuk close
    document.getElementById('deletePetugasModal').addEventListener('click', function(e) {

        if (e.target === this) {

            closeDeletePetugasModal();

        }

    });

</script>

@endsection