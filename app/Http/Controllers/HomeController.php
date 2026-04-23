<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Models\PopupOverlay;
use App\Models\Publikasi;
use App\Models\StatisticTitle;

class HomeController extends Controller
{
   public function index()
{
    $titles = StatisticTitle::with(['statistics.values'])
        ->latest()
        ->get(); // ❗ jangan di-take dulu di sini

    $charts = [];

    foreach ($titles as $title) {
        foreach ($title->statistics as $stat) {

            $values = $stat->values
                ->sortByDesc('tahun')
                ->take(5)          // 🔥 max 5 tahun
                ->sortBy('tahun')
                ->values();

            if ($values->isEmpty()) continue;

            $charts[] = [
                'title' => $title->judul . ' di ' . $stat->wilayah,
                'id' => 'chart-' . \Str::slug($title->judul . '-' . $stat->wilayah),
                'labels' => $values->pluck('tahun')->toArray(),
                'values' => $values->pluck('nilai')->toArray(),
                'latest_year' => $values->last()->tahun ?? 0 // 🔥 untuk sorting
            ];
        }
    }

    // 🔥 SORT BERDASARKAN TAHUN TERBARU
    $charts = collect($charts)
        ->sortByDesc('latest_year')
        ->take(6) // 🔥 BATASI MAX 6 DATA
        ->values()
        ->toArray();

    $activePopup = PopupOverlay::where('tanggal_mulai', '<=', today())
        ->where('tanggal_akhir', '>=', today())
        ->latest()
        ->first();

    $publikasi = Publikasi::first();

    return view('home', [
        'charts' => $charts,
        'activePopup' => $activePopup,
        'publikasi' => $publikasi
    ]);
}

    public function dataStatistik()
    {
        $statistics = Statistic::with('values')
            ->where('status', 'published')
            ->when(request('indikator'), fn($q) =>
                $q->where('indikator_data', request('indikator'))
            )
            ->latest()
            ->get();

        return view('data-statistik', compact('statistics'));
    }
}