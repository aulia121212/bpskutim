<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publikasi;

class PublikasiController extends Controller
{
    public function index()
    {
        $publikasi = Publikasi::first(); // hanya 1 data
        return view('publikasi.index', compact('publikasi'));
    }

    public function create()
    {
        // Kalau sudah ada data, langsung redirect ke edit
        $publikasi = Publikasi::first();
        if ($publikasi) {
            return redirect()->route('superadmin.publikasi.edit', $publikasi->id)
                             ->with('info', 'Hanya boleh 1 link publikasi. Silakan edit yang sudah ada.');
        }
        return view('publikasi.create');
    }

    public function store(Request $request)
    {
        $request->validate(['link' => 'required|url|max:500']);

        // Pastikan hanya 1 — hapus lama kalau ada
        Publikasi::truncate();
        Publikasi::create(['link' => $request->link]);

        return redirect()->route('superadmin.publikasi.index')
                         ->with('success', 'Link publikasi berhasil disimpan.');
    }

    public function edit($id)
    {
        $publikasi = Publikasi::findOrFail($id);
        return view('publikasi.edit', compact('publikasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['link' => 'required|url|max:500']);
        Publikasi::findOrFail($id)->update(['link' => $request->link]);

        return redirect()->route('superadmin.publikasi.index')
                         ->with('success', 'Link publikasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Publikasi::findOrFail($id)->delete();

        return redirect()->route('superadmin.publikasi.index')
                         ->with('success', 'Link publikasi berhasil dihapus.');
    }
}