<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\StatisticTitle;
use Illuminate\Http\Request;

class DataStatistikController extends Controller
{
    private array $indikatorMap = [
        'indikator_ekonomi'             => 'Indikator Ekonomi',
        'indikator_ketenagakerjaan'     => 'Indikator Kependudukan dan Ketenagakerjaan',
        'indikator_sosial'              => 'Indikator Sosial',
        'indikator_pembangunan_manusia' => 'Indikator Pembangunan Manusia',
        'gender'                        => 'Gender',
    ];

    // =========================================================
    // INDEX → pakai logic dari HOME (chart + grouping)
    // =========================================================
    public function index()
{
    $rawStatistics = Statistic::with('values')
        ->where('status', 'published')
        ->get()
        ->groupBy(fn($s) => $s->judul_data . '|||' . $s->wilayah_data);

    $statistics = $rawStatistics->map(function ($group) {

        $stat      = $group->first();
        $allValues = $group->flatMap(fn($s) => $s->values);

        $withYLabel = $allValues->filter(
            fn($v) => !is_null($v->y_label) && !is_null($v->x_label)
        );

        // fallback
        if ($withYLabel->isEmpty()) {
            return $this->buildSingleDataset($stat, $allValues);
        }

        // ambil 5 tahun
        $allYears = $withYLabel->pluck('y_label')
            ->unique()
            ->sortDesc()
            ->take(5)
            ->sort()
            ->values()
            ->map(fn($y) => (string) $y)
            ->toArray();

        if (empty($allYears)) return null;

        // ambil komponen
        $firstXLabel = $withYLabel->pluck('x_label')->filter()->first();
        if (!$firstXLabel) return null;

        $filtered = $withYLabel->filter(
            fn($v) => $v->x_label == $firstXLabel
        );

        $byYear = $filtered->keyBy(fn($v) => (string) $v->y_label);

        $values = collect($allYears)->map(
            fn($y) => isset($byYear[$y]) ? (float) $byYear[$y]->value : null
        )->toArray();

        $periode = count($allYears) === 1
            ? $allYears[0]
            : $allYears[0] . '–' . end($allYears);

        return [
            'id'       => $stat->id,
            'judul'    => $stat->judul_data,
            'wilayah'  => $stat->wilayah_data,
            'updated'  => $stat->updated_at,
            'periode'  => $periode,
            'komponen' => $firstXLabel,
            'labels'   => $allYears,
            'values'   => $values,
        ];
    })
    ->filter()
    ->sortByDesc('updated')
    ->values();

    // ✅ AMBIL KUTAI TIMUR DI SINI (SETELAH mapping)
    $kutim = $statistics
    ->filter(fn($s) => str_contains(strtolower($s['wilayah']), 'kutai timur'))
    ->sortByDesc('updated')
    ->first();

    return view('data-statistik', compact('statistics', 'kutim'));
}
   
    // FILTER BERDASARKAN INDIKATOR
    
   public function indikator(Request $request, string $slug)
{
    abort_unless(array_key_exists($slug, $this->indikatorMap), 404);

    $query = StatisticTitle::with(['statistics' => function ($q) {
        $q->with('values')->where('status', 'published');
    }])->where('indikator_data', $slug);

    if ($search = $request->input('search')) {
        $query->where('judul_data', 'like', "%{$search}%");
    }

    $statistics = $query->latest()->paginate(10)->withQueryString();

    return view('data-statistik.indikator', [
        'statistics'    => $statistics,
        'slug'          => $slug,
        'namaIndikator' => $this->indikatorMap[$slug],
        'indikatorMap'  => $this->indikatorMap,
    ]);
}

    // =========================================================
    // DETAIL (SHOW) → tetap pakai logic lama (multi wilayah)
    // =========================================================
    public function show(int $id)
    {
        $statTitle = StatisticTitle::with([
            'statistics' => fn($q) => $q->with('values')->where('status', 'published'),
            'components'
        ])->findOrFail($id);

        $allWilayahs = $statTitle->statistics->map(function ($s) use ($statTitle) {

            $processedValues = $s->values->map(function ($val) {
                if (is_null($val->y_label) && !is_null($val->year)) {
                    $val->y_label = (string) $val->year;
                }

                if (is_null($val->x_label)) {
                    $val->x_label = 'Lainnya';
                }

                return [
                    'x_label' => $val->x_label,
                    'y_label' => $val->y_label,
                    'value'   => (float) $val->value,
                ];
            })->sortBy([
                ['x_label', 'asc'],
                ['y_label', 'asc'],
            ])->values();

            return [
                'wilayah' => $s->wilayah_data,
                'values'  => $processedValues->toArray(),
            ];
        })->values();

        $components = $statTitle->components->map(fn($c) => [
            'id'     => $c->id,
            'nama'   => $c->nama,
            'is_sub' => (bool) $c->is_sub,
            'urutan' => $c->urutan,
        ])->sortBy('urutan')->values();

        return view('data-statistik.show', [
            'stat'         => $statTitle,
            'slug'         => $statTitle->indikator_data,
            'allWilayahs'  => $allWilayahs,
            'components'   => $components,
            'indikatorMap' => $this->indikatorMap,
            'judul'        => $statTitle->judul_data,
        ]);
    }

    // =========================================================
    // HELPER → biar bisa dipakai ulang (indikator)
    // =========================================================
    private function formatStatistics($rawStatistics)
    {
        return $rawStatistics->map(function ($group) {

            $stat      = $group->first();
            $allValues = $group->flatMap(fn($s) => $s->values);

            $withYLabel = $allValues->filter(
                fn($v) => !is_null($v->y_label) && !is_null($v->x_label)
            );

            if ($withYLabel->isEmpty()) {
                return $this->buildSingleDataset($stat, $allValues);
            }

            $years = $withYLabel->pluck('y_label')
                ->unique()
                ->sortDesc()
                ->take(5)
                ->sort()
                ->values()
                ->map(fn($y) => (string) $y)
                ->toArray();

            if (empty($years)) return null;

            $firstX = $withYLabel->pluck('x_label')->filter()->first();
            if (!$firstX) return null;

            $filtered = $withYLabel->filter(fn($v) => $v->x_label == $firstX);
            $byYear   = $filtered->keyBy(fn($v) => (string) $v->y_label);

            $values = collect($years)->map(
                fn($y) => isset($byYear[$y]) ? (float) $byYear[$y]->value : null
            )->toArray();

            return [
                'judul'   => $stat->judul_data,
                'wilayah' => $stat->wilayah_data,
                'labels'  => $years,
                'values'  => $values,
            ];
        })->filter()->values();
    }

    // =========================================================
    // HELPER FORMAT LAMA
    // =========================================================
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

        return [
            'judul'   => $stat->judul_data,
            'wilayah' => $stat->wilayah_data,
            'labels'  => $years,
            'values'  => $vals,
        ];
    }
}