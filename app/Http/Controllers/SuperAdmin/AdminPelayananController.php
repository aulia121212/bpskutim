<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPelayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $admins = \App\Models\AdminPelayanan::latest()->get();
    return view('superadmin.admin-pelayanan.index', compact('admins'));
}

public function create()
{
    return view('superadmin.admin-pelayanan.create');
}

public function store(Request $request)
{
    $request->validate([
        'nama_lengkap' => 'required',
        'email' => 'required|email|unique:admin_pelayanans',
        'password' => 'required|min:6',
    ]);

    \App\Models\AdminPelayanan::create([
        ...$request->except('password'),
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('superadmin.admin-pelayanan.index')
        ->with('success', 'Admin berhasil ditambahkan');
}

public function edit($id)
{
    $admin = \App\Models\AdminPelayanan::findOrFail($id);
    return view('superadmin.admin-pelayanan.edit', compact('admin'));
}

public function update(Request $request, $id)
{
    $admin = \App\Models\AdminPelayanan::findOrFail($id);

    $admin->update($request->except('password'));

    return redirect()->route('superadmin.admin-pelayanan.index');
}

public function destroy($id)
{
    \App\Models\AdminPelayanan::destroy($id);

    return back()->with('success', 'Data dihapus');
}
}
