<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Models\StatisticValue;
use App\Models\StatisticTitle;

class StatisticController extends Controller
{
    public function index()
{
    $statistics = Statistic::with(['values','title.components'])->get();

    return view('statistics.index', compact('statistics'));
}

    public function create()
    {
        $statisticTitles = \App\Models\StatisticTitle::orderBy('judul_data')->get();
        return view('statistics.create', compact('statisticTitles'));
    }

    public function store(Request $request)
{
    $request->validate([
        'indikator_data'    => 'required|string|max:255',
        'statistic_title_id' => 'required|exists:statistic_titles,id',
        'wilayah_data'       => 'required',
        'file_data'          => 'nullable|file|mimes:pdf,xlsx,csv|max:2048',
    ]);

    $title = \App\Models\StatisticTitle::findOrFail($request->statistic_title_id);

    // Upload file referensi
    $filePath = null;
    if ($request->hasFile('file_data')) {
        $file     = $request->file('file_data');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/statistics'), $filename);
        $filePath = 'uploads/statistics/' . $filename;
    }

    $statistic = Statistic::create([
    'indikator_data'           => $request->indikator_data,
    'statistic_title_id'       => $title->id, // <<< INI YANG HILANG
    'judul_data'               => $title->judul_data,
    'wilayah_data'             => $request->wilayah_data,
    'file_data'                => $filePath,
    'interpretasi_lebih_kecil' => $title->interpretasi_lebih_kecil,
    'interpretasi_lebih_besar' => $title->interpretasi_lebih_besar,
    'interpretasi_tetap' => $title->interpretasi_tetap,

    'status'                   => 'draft',
]);
    // ── Simpan nilai dari grid_json ──────────────────────────────────────
    $gridJson = $request->input('grid_json');

    \Log::info('grid_json received', ['raw' => substr($gridJson ?? '', 0, 200)]);

    if ($gridJson && $gridJson !== '[]' && $gridJson !== 'null') {
        $rows = json_decode($gridJson, true);
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
    $xLabel = trim($row['x_label'] ?? '');
    $yLabel = isset($row['y_label']) && $row['y_label'] !== '' 
              ? trim($row['y_label']) 
              : null;
    $value  = $row['value'] ?? null;

    if ($xLabel === '' || is_null($value)) continue;

    StatisticValue::create([
    'statistic_id' => $statistic->id,
    'year'         => null,      // ← tidak pakai kolom year lagi
    'x_label'      => $xLabel,
    'y_label'      => $yLabel,
    'value'        => is_numeric($value) ? $value : 0,
]);
}
        }
    }

    return redirect()->route('statistics.preview', $statistic->id);
}

    // public function preview($id)
    // {
    //     $statistic = Statistic::with('values')->findOrFail($id);
    //     $values    = $statistic->values->each(function ($val) {
    //         if (is_null($val->y_label) && !is_null($val->year)) {
    //             $val->y_label = (string) $val->year;
    //         }
    //     })->sortBy('x_label')->values();

    //     $is2D           = $values->whereNotNull('y_label')->count() > 0;
    //     $interpretation = $this->generateInterpretation($values, $is2D);

    //     return view('statistics.preview', compact('statistic', 'values', 'interpretation', 'is2D'));
    // }

   public function preview($id)
{
    $statistic = Statistic::with([
        'values',
        'title.components'
    ])->findOrFail($id);

    // Debug: lihat struktur data sebelum diproses
    \Log::info('=== PREVIEW DEBUG ===');
    \Log::info('Statistic ID: ' . $statistic->id);
    \Log::info('Judul: ' . $statistic->judul_data);
    \Log::info('Wilayah: ' . $statistic->wilayah_data);
    \Log::info('Total values: ' . $statistic->values->count());

    if ($statistic->values->isNotEmpty()) {
        $sample = $statistic->values->first();
        \Log::info('Sample value structure:', [
            'id' => $sample->id,
            'x_label' => $sample->x_label,
            'y_label' => $sample->y_label,
            'year' => $sample->year,
            'value' => $sample->value
        ]);

        \Log::info('Unique x_labels:', [
            'labels' => $statistic->values->pluck('x_label')->unique()->values()->toArray()
        ]);
    }

    // Proses values
    $values = $statistic->values->map(function ($val) {
        // Clone untuk menghindari side effects
        $val = clone $val;
        
        // Normalisasi: pastikan y_label ada
        if (is_null($val->y_label) && !is_null($val->year)) {
            $val->y_label = (string) $val->year;
        }
        
        // Pastikan x_label tidak null
        if (is_null($val->x_label)) {
            $val->x_label = 'Tanpa Kategori';
        }
        
        return $val;
    })->sortBy([
        ['x_label', 'asc'],
        ['y_label', 'asc'],
    ])->values();

    // Cek hasil setelah diproses
    \Log::info('After processing:');
    \Log::info('Total processed: ' . $values->count());
    \Log::info('Has y_label: ' . $values->whereNotNull('y_label')->count());
    \Log::info('Unique x_labels after:', [
        'labels' => $values->pluck('x_label')->unique()->values()->toArray()
    ]);

    $is2D = $values->whereNotNull('y_label')->count() > 0;
    \Log::info('Is 2D: ' . ($is2D ? 'Yes' : 'No'));

    $interpretation = $this->generateInterpretation($values, $is2D);

    return view('statistics.preview', compact(
        'statistic',
        'values',
        'interpretation',
        'is2D'
    ));
} 

    public function destroy($id)
    {
        $statistic = Statistic::with('values')->findOrFail($id);


        
        if ($statistic->file_data && file_exists(public_path($statistic->file_data))) {
            unlink(public_path($statistic->file_data));
        }

        $statistic->values()->delete();
        $statistic->delete();

        return redirect()->route('statistics.index')
            ->with('success', 'Data statistik berhasil dihapus.');
    }

    private function generateInterpretation($values, bool $is2D = false): string
    {
        if ($is2D || $values->count() < 2) return '';

        $sorted  = $values->sortBy('x_label');
        $first   = $sorted->first();
        $last    = $sorted->last();
        $diff    = $last->value - $first->value;
        $highest = $values->sortByDesc('value')->first();
        $lowest  = $values->sortBy('value')->first();

        return "Data menunjukkan perubahan dari {$first->value} ({$first->x_label}) "
             . "menjadi {$last->value} ({$last->x_label}) "
             . "dengan selisih " . number_format(abs($diff), 2) . ". "
             . "Tertinggi: {$highest->x_label} ({$highest->value}), "
             . "Terendah: {$lowest->x_label} ({$lowest->value}).";
    }

    public function grafik()
{
    $titlesByJudul = StatisticTitle::with('components')
        ->get()
        ->keyBy('judul_data');

    // Gabungkan semua statistic dengan judul+wilayah yang sama
  $grouped = Statistic::with([
    'values',
    'title.components'
])
->where('status', 'published')
->get()
->groupBy(fn($s) => $s->judul_data . '|||' . $s->wilayah_data);

    $statistics = $grouped->map(function ($group) use ($titlesByJudul) {
        $stat = $group->first();

        // Gabungkan semua values dari semua stat dalam group
        $allValues = $group->flatMap(fn($s) => $s->values)->map(function ($val) {
            if (is_null($val->y_label) && !is_null($val->year)) {
                $val->y_label = (string) $val->year;
            }
            return $val;
        })->sortBy([
            ['x_label', 'asc'],
            ['y_label', 'asc'],
        ])->values();

        $stat->setRelation('values', $allValues);

        $title = $stat->title;

$stat->setAttribute('judul_kolom', $title?->judul_kolom ?: 'Kategori');

$stat->setAttribute(
    'components',
    $title?->components?->map(fn($c) => [
        'id'     => $c->id,
        'nama'   => $c->nama,
        'is_sub' => (bool) $c->is_sub,
        'urutan' => $c->urutan,
    ])->values() ?? collect()
);

        return $stat;
    })->values();

    $statistics = Statistic::with([
        'values',
        'statisticTitle.components'
    ])
    ->where('status', 'published')
    ->get();

    return view('statistics.grafik', compact('statistics'));
}

    public function publish($id)
    {
        $statistic = Statistic::findOrFail($id);
        $statistic->update(['status' => 'published']);
        return redirect()->route('statistics.index');
    }
}


// $statistics = Statistic::with([
//     'values',
//     'title.components'
// ])->get();