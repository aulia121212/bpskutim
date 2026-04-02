<?php

namespace App\Http\Controllers;

use App\Models\Statistictitle;
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
        // Eager load relasi sesuai nama di model Statistictitle
        // Ganti 'statisticValues' jika nama relasi di model berbeda
        $statistics = Statistictitle::with('statisticValues')->latest()->take(8)->get()
            ->each(function ($stat) {
                // Alias agar view tetap bisa pakai ->values
                $stat->setRelation('values', $stat->statisticValues ?? collect());
            });

        return view('data-statistik', compact('statistics'));
    }

    public function indikator(Request $request, string $slug)
    {
        abort_unless(array_key_exists($slug, $this->indikatorMap), 404);
        $namaIndikator = $this->indikatorMap[$slug];

        $query = Statistictitle::with('statisticValues')
            ->where('indikator_data', $namaIndikator);

        if ($search = $request->input('search')) {
            $query->where('judul_data', 'like', "%{$search}%");
        }

        $statistics = $query->latest()->paginate(10)->withQueryString();

        // Alias relasi
        $statistics->each(fn($s) => $s->setRelation('values', $s->statisticValues ?? collect()));

        return view('data-statistik.indikator', [
            'statistics'    => $statistics,
            'slug'          => $slug,
            'namaIndikator' => $namaIndikator,
            'indikatorMap'  => $this->indikatorMap,
        ]);
    }

    public function show(int $id)
    {
        $stat = Statistictitle::with(['statisticValues', 'components'])->findOrFail($id);
        $stat->setRelation('values', $stat->statisticValues ?? collect());

        $slug = array_search($stat->indikator_data, $this->indikatorMap) ?: 'indikator_ekonomi';

        return view('data-statistik.show', [
            'stat'         => $stat,
            'slug'         => $slug,
            'indikatorMap' => $this->indikatorMap,
        ]);
    }
}