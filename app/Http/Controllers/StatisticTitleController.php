<?php

namespace App\Http\Controllers;

use App\Models\StatisticTitle;
use Illuminate\Http\Request;

class StatisticTitleController extends Controller
{
    public function index()
    {
        $titles = StatisticTitle::latest()->paginate(15);
        return view('layouts.statistic-titles.index', compact('titles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_data'               => 'required|string|max:255',
            'interpretasi_lebih_kecil' => 'nullable|string',
            'interpretasi_lebih_besar' => 'nullable|string',
        ]);

        StatisticTitle::create($request->only([
            'judul_data',
            'interpretasi_lebih_kecil',
            'interpretasi_lebih_besar',
        ]));

        return back()->with('success', 'Judul data berhasil ditambahkan.');
    }

    public function update(Request $request, StatisticTitle $statisticTitle)
    {
        $request->validate([
            'judul_data'               => 'required|string|max:255',
            'interpretasi_lebih_kecil' => 'nullable|string',
            'interpretasi_lebih_besar' => 'nullable|string',
        ]);

        $statisticTitle->update($request->only([
            'judul_data',
            'interpretasi_lebih_kecil',
            'interpretasi_lebih_besar',
        ]));

        return back()->with('success', 'Judul data berhasil diperbarui.');
    }

    public function destroy(StatisticTitle $statisticTitle)
    {
        $statisticTitle->delete();
        return back()->with('success', 'Judul data berhasil dihapus.');
    }

    /**
     * API endpoint — return interpretasi JSON untuk dropdown di form create statistic
     */
    public function getInterpretasi(StatisticTitle $statisticTitle)
    {
        return response()->json([
            'interpretasi_lebih_kecil' => $statisticTitle->interpretasi_lebih_kecil,
            'interpretasi_lebih_besar' => $statisticTitle->interpretasi_lebih_besar,
        ]);
    }
}