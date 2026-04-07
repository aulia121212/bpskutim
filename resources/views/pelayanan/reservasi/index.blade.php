@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Reservasi Konsultasi</h1>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Tanggal Konsultasi</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Nama</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Nomor WhatsApp</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Petugas</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Status</th>
                    <th class="text-left px-6 py-4 font-semibold text-blue-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasi ?? [] as $r)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
<td class="px-6 py-4 text-gray-700">
    {{ $r->user->name ?? '-' }}
</td>                    
<td class="px-6 py-4 text-gray-700">
    {{ $r->user->no_whatsapp ?? '-' }}
</td>                    <td class="px-6 py-4 text-gray-700">{{ $r->petugas->nama_lengkap ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusClass = match($r->status) {
                                'dijadwalkan' => 'bg-green-500 text-white',
                                'dibatalkan'  => 'bg-red-500 text-white',
                                default       => 'bg-blue-800 text-white',
                            };
                            $statusLabel = match($r->status) {
                                'dijadwalkan' => 'Dijadwalkan',
                                'dibatalkan'  => 'Dibatalkan',
                                default       => 'Diajukan',
                            };
                        @endphp
                        <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button class="p-1.5 text-gray-400 hover:text-blue-600 transition"><i class="ti ti-pencil"></i></button>
                            <button class="p-1.5 text-gray-400 hover:text-red-500 transition"><i class="ti ti-trash"></i></button>
                            <a href="{{ route('pelayanan.reservasi.show', $r->id_reservasi) }}" 
   class="inline-flex items-center gap-1 border border-blue-300 text-blue-600 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
    Detail <i class="ti ti-chevrons-right text-sm"></i>
</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">
                    <i class="ti ti-calendar-off text-3xl block mb-2"></i>Belum ada reservasi
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection