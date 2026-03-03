@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Admin Data Statistik</h1>

    <a href="{{ route('superadmin.admin-data-statistik.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg">
        Tambah Admin
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full text-left">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Nama</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Tim</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($admins as $admin)
            <tr class="border-t">
                <td class="p-3">{{ $admin->nama_lengkap }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->jabatan }}</td>
                <td>{{ $admin->tim }}</td>
                <td class="text-center space-x-2">

                    <a href="{{ route('superadmin.admin-data-statistik.edit', $admin->id) }}"
                       class="text-yellow-600">Edit</a>

                    <form action="{{ route('superadmin.admin-data-statistik.destroy', $admin->id) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600"
                                onclick="return confirm('Yakin hapus?')">
                            Hapus
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection