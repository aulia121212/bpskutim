@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-8 pb-20" x-data="{ 
    deleteModalOpen: false, 
    deleteUrl: '', 
    userName: '',
    confirmDelete(url, name) {
        this.deleteUrl = url;
        this.userName = name;
        this.deleteModalOpen = true;
    }
}">
    
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Pengguna</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Kelola hak akses dan data personal pengguna sistem Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <x-button variant="secondary" icon="download" class="rounded-xl">
                Export
            </x-button>
            <x-button variant="primary" href="{{ route('laravel.users.create') }}" icon="plus" class="rounded-xl shadow-lg shadow-indigo-500/20">
                Tambah User
            </x-button>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600">
                    <i class="ti ti-users text-2xl"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total User</p>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $users->total() }}</h4>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600">
                    <i class="ti ti-user-check text-2xl"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Terverifikasi</p>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $users->whereNotNull('email_verified_at')->count() }}</h4>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-600">
                    <i class="ti ti-user-plus text-2xl"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">User Baru</p>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $users->where('created_at', '>=', now()->subMonth())->count() }}</h4>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Search & Filter Section --}}
    <div class="flex flex-col md:flex-row gap-4">
        <form action="{{ route('laravel.users.index') }}" method="GET" class="relative flex-1 group">
            <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-600 transition-colors"></i>
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Cari nama atau email pengguna..." 
                class="w-full pl-11 pr-12 py-3 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl text-sm outline-none focus:ring-4 focus:ring-indigo-500/5 transition-all dark:text-white"
            >
            @if(request('search'))
                <a href="{{ route('laravel.users.index') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-rose-500 transition-colors">
                    <i class="ti ti-x"></i>
                </a>
            @endif
        </form>
    </div>

    {{-- Main Data Card --}}
    <x-card :padding="false" title="Daftar Pengguna Aktif">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-50 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                        <th class="py-4 px-8 text-[11px] font-bold uppercase text-gray-400 tracking-wider">Pengguna</th>
                        <th class="py-4 px-8 text-[11px] font-bold uppercase text-gray-400 tracking-wider">Status</th>
                        <th class="py-4 px-8 text-[11px] font-bold uppercase text-gray-400 tracking-wider">Bergabung</th>
                        <th class="py-4 px-8 text-[11px] font-bold uppercase text-gray-400 tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/20 transition-colors group">
                            <td class="py-4 px-8">
                                <div class="flex items-center gap-3">
                                    <x-avatar :name="$user->name" size="sm" shape="xl" />
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">{{ $user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-8">
                                @if($user->email_verified_at)
                                    <x-badge variant="success" type="soft" icon="circle-check">Terverifikasi</x-badge>
                                @else
                                    <x-badge variant="warning" type="soft" icon="clock">Pending</x-badge>
                                @endif
                            </td>
                            <td class="py-4 px-8 text-sm text-gray-500 font-medium">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-8">
                                <div class="flex items-center justify-end gap-2">
                                    <x-button variant="secondary" size="sm" href="{{ route('laravel.users.edit', $user->id) }}" class="rounded-lg h-9 w-9 p-0 flex items-center justify-center">
                                        <i class="ti ti-pencil text-base"></i>
                                    </x-button>
                                    
                                    <x-button variant="danger" size="sm" type="button" 
                                        @click="confirmDelete('{{ route('laravel.users.destroy', $user->id) }}', '{{ $user->name }}')"
                                        class="rounded-lg h-9 w-9 p-0 flex items-center justify-center">
                                        <i class="ti ti-trash text-base"></i>
                                    </x-button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-24">
                                <div class="flex flex-col items-center justify-center text-center max-w-[280px] mx-auto">
                                    <div class="relative mb-6">
                                        <div class="absolute inset-0 bg-indigo-500/10 dark:bg-indigo-500/5 blur-2xl rounded-full"></div>
                                        <div class="relative w-20 h-20 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl flex items-center justify-center shadow-sm">
                                            <i class="ti ti-users-minus text-4xl text-gray-300 dark:text-gray-700"></i>
                                        </div>
                                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-indigo-50 dark:bg-indigo-500/10 border-4 border-white dark:border-gray-950 rounded-full flex items-center justify-center">
                                            <i class="ti ti-question-mark text-indigo-600 text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="text-base font-bold text-gray-900 dark:text-white">
                                            @if(request('search')) 
                                                Hasil tidak ditemukan 
                                            @else 
                                                Belum Ada Pengguna 
                                            @endif
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                                            @if(request('search'))
                                                Tidak ada hasil untuk kata kunci "{{ request('search') }}". Coba gunakan kata kunci lain.
                                            @else
                                                Sepertinya daftar pengguna Anda masih kosong. Mulai tambahkan pengguna baru untuk mengelola akses sistem.
                                            @endif
                                        </p>
                                    </div>
                                    <div class="mt-6">
                                        @if(request('search'))
                                            <x-button variant="secondary"  href="{{ route('laravel.users.index') }}">
                                                Reset Pencarian
                                            </x-button>
                                        @else
                                            <x-button variant="secondary"  href="{{ route('laravel.users.create') }}">
                                                <i class="ti ti-plus mr-2"></i> Tambah Sekarang
                                            </x-button>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-8 py-6 border-t border-gray-50 dark:border-gray-800">
                {{ $users->links() }}
            </div>
        @endif
    </x-card>

    {{-- Delete Confirmation Modal --}}
    <div x-show="deleteModalOpen" 
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white dark:bg-gray-900 w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-800"
            @click.away="deleteModalOpen = false">
            <div class="p-8 text-center">
                <div class="w-20 h-20 bg-rose-50 dark:bg-rose-500/10 text-rose-500 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <i class="ti ti-trash-x text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hapus Pengguna?</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    Anda akan menghapus akun <span class="font-bold text-gray-900 dark:text-white" x-text="userName"></span>. Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            
            <div class="flex gap-3 p-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800">
                <x-button variant="secondary" class="flex-1 rounded-xl" @click="deleteModalOpen = false">
                    Batal
                </x-button>
                <form :action="deleteUrl" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger" type="submit" class="w-full rounded-xl shadow-lg shadow-rose-500/20">
                        Ya, Hapus
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection