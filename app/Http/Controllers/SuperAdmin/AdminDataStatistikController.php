<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminDataStatistikController extends Controller
{
    public function index()
    {
        $admins = User::where('role', User::ROLE_ADMIN_STATISTIK)->get();

        return view('super-admin.admin-data-statistik.index', compact('admins'));
    }

    public function create()
    {
        return view('super-admin.admin-data-statistik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email',
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

        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => User::ROLE_ADMIN_STATISTIK,
            'no_whatsapp'  => $request->no_whatsapp,
            'instansi'     => $request->instansi,
            'jabatan'      => $request->jabatan,
            'tim'          => $request->tim,
            'alamat'       => $request->alamat,
            'foto_profil'  => $foto,
            'is_active'    => true,
        ]);

        return redirect()->route('superadmin.admin-data-statistik.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function show($id)
    {
        $admin = User::where('role', User::ROLE_ADMIN_STATISTIK)->findOrFail($id);

        return view('super-admin.admin-data-statistik.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = User::where('role', User::ROLE_ADMIN_STATISTIK)->findOrFail($id);

        return view('super-admin.admin-data-statistik.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('role', User::ROLE_ADMIN_STATISTIK)->findOrFail($id);

        $request->validate([
            'name'        => 'required',
            'email'       => 'required|email|unique:users,email,' . $id,
            'no_whatsapp' => 'required',
        ]);

        $foto = $admin->foto_profil;

        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/admin'), $filename);
            $foto = 'uploads/admin/' . $filename;
        }

        $data = [
            'name'        => $request->name,
            'email'       => $request->email,
            'no_whatsapp' => $request->no_whatsapp,
            'instansi'    => $request->instansi,
            'jabatan'     => $request->jabatan,
            'tim'         => $request->tim,
            'alamat'      => $request->alamat,
            'foto_profil' => $foto,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('superadmin.admin-data-statistik.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = User::where('role', User::ROLE_ADMIN_STATISTIK)->findOrFail($id);
        $admin->delete();

        return redirect()->route('superadmin.admin-data-statistik.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}