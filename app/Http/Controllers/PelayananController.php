<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelayananController extends Controller
{
    public function petugas()
    {
        return view('pelayanan.petugas');
    }

    public function petugasStore(Request $request)
    {
        // implementasi store petugas
    }

    public function jadwal()
    {
        return view('pelayanan.jadwal');
    }

    public function reservasi()
    {
        return view('pelayanan.reservasi');
    }

    public function popup()
    {
        return view('pelayanan.popup');
    }

    public function popupStore(Request $request)
    {
        // implementasi store popup
    }

    public function user()
    {
        return view('pelayanan.user');
    }
}