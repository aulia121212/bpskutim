<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Models\PopupOverlay;
use App\Models\Publikasi;

class HomeController extends Controller
{
    public function index()
    {
        // ───────────────────────────────────────────────
        // Ambil data statistik (group per judul + wilayah)
        // ───────────────────────────────────────────────
        $rawStatistics = Statistic::with('values')
            ->where('status', 'published')
            ->get()
            ->groupBy(fn($s) => $s->judul_data . '|||' . $s->wilayah_data);

        $statistics = $rawStatistics->map(function ($group) {

            $stat      = $group->first();
            $allValues = $group->flatMap(fn($s) => $s->values);

            // ───────────────────────────────────────────
            // 1. Filter data yang punya tahun (y_label)
            // ───────────────────────────────────────────
            $withYLabel = $allValues->filter(
                fn($v) => !is_null($v->y_label) && !is_null($v->x_label)
            );

            // ───────────────────────────────────────────
            // Fallback: format lama (x_label = tahun)
            // ───────────────────────────────────────────
            if ($withYLabel->isEmpty()) {
                return $this->buildSingleDataset($stat, $allValues);
            }

            // ───────────────────────────────────────────
            // 2. Ambil 5 tahun terakhir
            // ───────────────────────────────────────────
            $allYears = $withYLabel
                ->pluck('y_label')
                ->unique()
                ->sortDesc()
                ->take(5)
                ->sort()
                ->values()
                ->map(fn($y) => (string) $y)
                ->toArray();

            if (empty($allYears)) return null;

            // ───────────────────────────────────────────
            // 3. Ambil SATU x_label (komponen)
            // ───────────────────────────────────────────
            $firstXLabel = $withYLabel
                ->pluck('x_label')
                ->filter()
                ->first();

            if (!$firstXLabel) return null;

            // Filter hanya komponen tersebut
            $filtered = $withYLabel->filter(
                fn($v) => $v->x_label == $firstXLabel
            );

            // Mapping nilai per tahun
            $byYear = $filtered->keyBy(fn($v) => (string) $v->y_label);

            $values = collect($allYears)->map(
                fn($y) => isset($byYear[$y]) ? (float) $byYear[$y]->value : null
            )->toArray();

            // ───────────────────────────────────────────
            // 4. Dataset → hanya 1 (wilayah)
            // ───────────────────────────────────────────
            $datasets = [
                [
                    'label'  => $stat->wilayah_data, // ✅ legend = wilayah
                    'values' => $values,
                ]
            ];

            // ───────────────────────────────────────────
            // 5. Periode (untuk UI)
            // ───────────────────────────────────────────
            $periode = count($allYears) === 1
                ? $allYears[0]
                : $allYears[0] . '–' . end($allYears);

            return [
                'id'       => $stat->id,
                'judul'    => $stat->judul_data,
                'wilayah'  => $stat->wilayah_data,
                'updated'  => $stat->updated_at,
                'periode'  => $periode,

                // 🔥 untuk badge
                'komponen' => $firstXLabel,

                // 🔥 untuk chart
                'y_labels' => $allYears,
                'datasets' => $datasets,

                // fallback
                'labels'   => $allYears,
                'values'   => $values,
            ];
        })
        ->filter()
        ->sortByDesc('updated')
        ->take(6)
        ->values();

        // ───────────────────────────────────────────────
        // POPUP
        // ───────────────────────────────────────────────
        $activePopup = PopupOverlay::where('tanggal_mulai', '<=', today())
            ->where('tanggal_akhir', '>=', today())
            ->latest()
            ->first();

        // ───────────────────────────────────────────────
        // PUBLIKASI
        // ───────────────────────────────────────────────
        $publikasi = Publikasi::first();

        return view('home', [
            'statistics'  => $statistics,
            'activePopup' => $activePopup,
            'publikasi'   => $publikasi,
        ]);
    }

    // ───────────────────────────────────────────────
    // Helper: format lama (x_label = tahun)
    // ───────────────────────────────────────────────
    private function buildSingleDataset($stat, $values): ?array
    {
        $filtered = $values->filter(fn($v) => !is_null($v->x_label));

        if ($filtered->isEmpty()) return null;

        $sorted = $filtered
            ->sortByDesc(fn($v) => (int) $v->x_label)
            ->take(5)
            ->sortBy(fn($v) => (int) $v->x_label)
            ->values();

        if ($sorted->isEmpty()) return null;

        $years = $sorted->pluck('x_label')->map(fn($v) => (string) $v)->toArray();
        $vals  = $sorted->pluck('value')->map(fn($v) => (float) $v)->toArray();

        $periode = count($years) === 1
            ? $years[0]
            : $years[0] . '–' . end($years);

        return [
            'id'       => $stat->id,
            'judul'    => $stat->judul_data,
            'wilayah'  => $stat->wilayah_data,
            'updated'  => $stat->updated_at,
            'periode'  => $periode,

            'komponen' => 'Indikator',

            'y_labels' => $years,
            'datasets' => [
                [
                    'label'  => $stat->wilayah_data,
                    'values' => $vals
                ]
            ],

            'labels' => $years,
            'values' => $vals,
        ];
    }

    // ───────────────────────────────────────────────
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