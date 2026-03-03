@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Tambah Admin Pelayanan</h1>

<form action="{{ route('superadmin.admin-pelayanan.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded-xl shadow space-y-4">

    @csrf

    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap"
        class="w-full border p-2 rounded">

    <input type="text" name="no_whatsapp" placeholder="Nomor WhatsApp"
        class="w-full border p-2 rounded">

    <input type="email" name="email" placeholder="Email"
        class="w-full border p-2 rounded">

    <input type="password" name="password" placeholder="Kata Sandi"
        class="w-full border p-2 rounded">

    <textarea name="alamat" placeholder="Alamat"
        class="w-full border p-2 rounded"></textarea>

    <select name="jabatan" class="w-full border p-2 rounded">
        <option value="">Pilih Jabatan</option>
        <option>Koordinator</option>
        <option>Staff</option>
    </select>

    <select name="tim" class="w-full border p-2 rounded">
        <option value="">Pilih Tim</option>
        <option>Tim A</option>
        <option>Tim B</option>
    </select>

    <input type="file" name="foto" class="w-full">

    <div class="flex gap-3">
        <a href="{{ route('superadmin.admin-pelayanan.index') }}"
           class="px-4 py-2 bg-gray-400 text-white rounded">
           Batal
        </a>

        <button class="px-4 py-2 bg-blue-600 text-white rounded">
            Simpan
        </button>
    </div>

</form>

@endsection