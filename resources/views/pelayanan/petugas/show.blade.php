@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">
                Pelayanan / Petugas
            </p>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Detail Petugas
            </h1>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Informasi lengkap petugas layanan konsultasi
            </p>
        </div>

        <div class="flex items-center gap-3">

            <a href="{{ route('pelayanan.petugas.edit', $petugas->id) }}"
                class="inline-flex items-center gap-2 rounded-xl bg-[#035f9c] px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#024d7f]">

                <i class="ti ti-edit"></i>
                Edit
            </a>

            <a href="{{ route('pelayanan.petugas.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">

                <i class="ti ti-arrow-left text-base"></i>
                Kembali
            </a>

        </div>
    </div>

    {{-- Card --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">

        {{-- Top --}}
        <div class="p-8 border-b border-gray-100 dark:border-gray-800">

            <div class="flex flex-col md:flex-row md:items-center gap-6">

                {{-- Foto --}}
                <div class="shrink-0">
                    @if($petugas->foto)
                        <img src="{{ asset($petugas->foto) }}"
                            alt="{{ $petugas->nama_lengkap }}"
                            class="w-36 h-36 rounded-2xl object-cover border border-gray-200 dark:border-gray-700">
                    @else
                        <div class="w-36 h-36 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-700">

                            <i class="ti ti-user text-5xl text-gray-400"></i>

                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1">

                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                        {{ $petugas->nama_lengkap }}
                    </h2>

                    <div class="space-y-3">

                        <!-- <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-300">
                            <i class="ti ti-building text-[#035f9c] text-lg"></i>
                            {{ $petugas->instansi ?: '-' }}
                        </div> -->

                        <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-300">
                            <i class="ti ti-briefcase text-[#035f9c] text-lg"></i>
                            {{ $petugas->jabatan ?: '-' }}
                        </div>

                        <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-300">
                            <i class="ti ti-brand-whatsapp text-[#035f9c] text-lg"></i>
                            {{ $petugas->nomor_wa ?: '-' }}
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- Bidang Keahlian --}}
        <div class="p-8">

            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-5">
                Bidang Keahlian
            </h3>

            @if(!empty($petugas->bidang_keahlian))

                <div class="flex flex-wrap gap-3">

                    @foreach($petugas->bidang_keahlian as $bidang)

                        <span
                            class="inline-flex items-center rounded-xl bg-blue-50 text-[#035f9c] border border-blue-100 px-4 py-2 text-sm font-medium dark:bg-blue-900/20 dark:border-blue-800">

                            {{ $bidang }}

                        </span>

                    @endforeach

                </div>

            @else

                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Belum ada bidang keahlian.
                </div>

            @endif

        </div>

    </div>
</div>
@endsection