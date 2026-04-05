<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\StatisticTitle;
use Illuminate\Http\Request;

class DataStatistikController extends Controller
{
    private array $indikatorMap = [
        'indikator_ekonomi'             => 'Indikator Ekonomi',
        'indikator_ketenagakerjaan'     => 'Indikator Ketenagakerjaan',
        'indikator_sosial'              => 'Indikator Sosial',
        'indikator_pembangunan_manusia' => 'Indikator Pembangunan Manusia',
    ];

    public function index()
    {
        $statistics = StatisticTitle::with(['statistics' => function ($q) {
            $q->with('values')->where('status', 'published');
        }])->latest()->take(8)->get();

        return view('data-statistik', compact('statistics'));
    }

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

    /**
     * HALAMAN DETAIL (SHOW)
     * Disesuaikan dengan logika StatisticController@grafik
     */
    public function show(int $id)
    {
        // 1. Ambil Title beserta Statistics yang statusnya published
        $statTitle = StatisticTitle::with([
            'statistics' => fn($q) => $q->with('values')->where('status', 'published'),
            'components'
        ])->findOrFail($id);

        // 2. Olah data per wilayah (mirip logika grouped di StatisticController)
        $allWilayahs = $statTitle->statistics->map(function ($s) use ($statTitle) {
            // Normalisasi & Urutkan Values (X_label dan Y_label)
            $processedValues = $s->values->map(function ($val) {
                // Pastikan y_label ada (jika null, gunakan year)
                if (is_null($val->y_label) && !is_null($val->year)) {
                    $val->y_label = (string) $val->year;
                }
                // Pastikan x_label tidak null
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
                'wilayah'      => $s->wilayah_data,
                'values'       => $processedValues->toArray(),
                // Ambil interpretasi dari level wilayah, jika kosong ambil dari level judul (Title)
                'interp_kecil' => $s->interpretasi_lebih_kecil ?? $statTitle->interpretasi_lebih_kecil ?? '',
                'interp_besar' => $s->interpretasi_lebih_besar ?? $statTitle->interpretasi_lebih_besar ?? '',
                'interp_tetap' => $s->interpretasi_tetap       ?? $statTitle->interpretasi_tetap       ?? '',
            ];
        })->values();

        // 3. Siapkan data komponen untuk filter checkbox
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

                'judul' => $statTitle->judul_data,

        ]);
    }
}