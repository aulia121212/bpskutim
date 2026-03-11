<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AdminPelayanan;
use Illuminate\Http\Request;

class AdminPelayananController extends Controller
{
    public function index()
    {
        $admins = AdminPelayanan::all();
        return view('super-admin.admin-pelayanan.index', compact('admins'));
    }

    public function create()
    {
        return view('super-admin.admin-pelayanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email'        => 'required|email|unique:admin_pelayanans,email',
            'password'     => 'required|min:6',
            'no_whatsapp'  => 'required',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/admin'), $filename);
            $foto = 'uploads/admin/' . $filename;
        }

        AdminPelayanan::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => bcrypt($request->password),
            'no_whatsapp'  => $request->no_whatsapp,
            'jabatan'      => $request->jabatan,
            'tim'          => $request->tim,
            'alamat'       => $request->alamat,
            'foto'         => $foto,
        ]);

        return redirect()->route('superadmin.admin-pelayanan.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function show($id)
    {
        $admin = AdminPelayanan::findOrFail($id);
        return view('super-admin.admin-pelayanan.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = AdminPelayanan::findOrFail($id);
        return view('super-admin.admin-pelayanan.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = AdminPelayanan::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'email'        => 'required|email|unique:admin_pelayanans,email,' . $id,
            'no_whatsapp'  => 'required',
        ]);

        $foto = $admin->foto;
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/admin'), $filename);
            $foto = 'uploads/admin/' . $filename;
        }

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'no_whatsapp'  => $request->no_whatsapp,
            'jabatan'      => $request->jabatan,
            'tim'          => $request->tim,
            'alamat'       => $request->alamat,
            'foto'         => $foto,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $admin->update($data);

        return redirect()->route('superadmin.admin-pelayanan.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        AdminPelayanan::findOrFail($id)->delete();
        return redirect()->route('superadmin.admin-pelayanan.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}