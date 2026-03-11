<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AdminDataStatistik;
use Illuminate\Http\Request;

class AdminDataStatistikController extends Controller
{
    public function index()
    {
        $admins = AdminDataStatistik::all();
        return view('super-admin.admin-data-statistik.index', compact('admins'));
    }

    public function create()
    {
        return view('super-admin.admin-data-statistik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email'        => 'required|email|unique:admin_data_statistiks,email',
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

        AdminDataStatistik::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => bcrypt($request->password),
            'no_whatsapp'  => $request->no_whatsapp,
            'asal_instansi'=> $request->asal_instansi,
            'jabatan'      => $request->jabatan,
            'tim'          => $request->tim,
            'alamat'       => $request->alamat,
            'foto'         => $foto,
        ]);

        return redirect()->route('superadmin.admin-data-statistik.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function show($id)
    {
        $admin = AdminDataStatistik::findOrFail($id);
        return view('super-admin.admin-data-statistik.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = AdminDataStatistik::findOrFail($id);
        return view('super-admin.admin-data-statistik.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = AdminDataStatistik::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'email'        => 'required|email|unique:admin_data_statistiks,email,' . $id,
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
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
            'no_whatsapp'   => $request->no_whatsapp,
            'asal_instansi' => $request->asal_instansi,
            'jabatan'       => $request->jabatan,
            'tim'           => $request->tim,
            'alamat'        => $request->alamat,
            'foto'          => $foto,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $admin->update($data);

        return redirect()->route('superadmin.admin-data-statistik.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        AdminDataStatistik::findOrFail($id)->delete();
        return redirect()->route('superadmin.admin-data-statistik.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}