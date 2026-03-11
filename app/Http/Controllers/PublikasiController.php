<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publikasi;

class PublikasiController extends Controller
{
    public function index() {
    $publikasis = Publikasi::latest()->get();
    return view('publikasi.index', compact('publikasis'));
}
public function create() { return view('publikasi.create'); }
public function store(Request $request) {
    $request->validate(['link'=>'required|url']);
    Publikasi::create($request->only('link'));
    return redirect()->route('publikasi.index')->with('success','Publikasi berhasil ditambahkan.');
}
public function edit($id) {
    $publikasi = Publikasi::findOrFail($id);
    return view('publikasi.edit', compact('publikasi'));
}
public function update(Request $request, $id) {
    $request->validate(['link'=>'required|url']);
    Publikasi::findOrFail($id)->update($request->only('link'));
    return redirect()->route('publikasi.index')->with('success','Publikasi berhasil diperbarui.');
}
public function destroy($id) {
    Publikasi::findOrFail($id)->delete();
    return redirect()->route('publikasi.index')->with('success','Publikasi berhasil dihapus.');
}

}
