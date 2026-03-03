<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDataStatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $admins = \App\Models\AdminDataStatistik::latest()->get();
    return view('superadmin.admin-data-statistik.index', compact('admins'));
}

public function create()
{
    return view('superadmin.admin-data-statistik.create');
}

public function store(Request $request)
{
    $request->validate([
        'nama_lengkap' => 'required',
        'email' => 'required|email|unique:admin_data_statistiks',
        'password' => 'required|min:6',
    ]);

    \App\Models\AdminDataStatistik::create([
        ...$request->except('password'),
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('superadmin.admin-data-statistik.index')
        ->with('success', 'Admin berhasil ditambahkan');
}

public function edit($id)
{
    $admin = \App\Models\AdminDataStatistik::findOrFail($id);
    return view('superadmin.admin-data-statistik.edit', compact('admin'));
}

public function update(Request $request, $id)
{
    $admin = \App\Models\AdminDataStatistik::findOrFail($id);

    $admin->update($request->except('password'));

    return redirect()->route('superadmin.admin-data-statistik.index');
}

public function destroy($id)
{
    \App\Models\AdminDataStatistik::destroy($id);

    return back()->with('success', 'Data dihapus');
}
}
