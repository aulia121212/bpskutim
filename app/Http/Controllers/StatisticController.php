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
        $statistics = Statistic::latest()->get();
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
            'indikator_data'     => 'required',
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
            'judul_data'               => $title->judul_data,
            'wilayah_data'             => $request->wilayah_data,
            'file_data'                => $filePath,
            'interpretasi_lebih_kecil' => $title->interpretasi_lebih_kecil,
            'interpretasi_lebih_besar' => $title->interpretasi_lebih_besar,
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
                    $yLabel = isset($row['y_label']) && $row['y_label'] !== '' ? trim($row['y_label']) : null;
                    $value  = $row['value'] ?? null;

                    if ($xLabel === '' || is_null($value)) continue;

                    StatisticValue::create([
                        'statistic_id' => $statistic->id,
                        'year'         => $yLabel ?? $xLabel,
                        'x_label'      => $xLabel,
                        'y_label'      => $yLabel,
                        'value'        => is_numeric($value) ? $value : 0,
                    ]);
                }
            }
        }

        return redirect()->route('statistics.preview', $statistic->id);
    }

    public function preview($id)
    {
        $statistic = Statistic::with('values')->findOrFail($id);
        $values    = $statistic->values->each(function ($val) {
            if (is_null($val->y_label) && !is_null($val->year)) {
                $val->y_label = (string) $val->year;
            }
        })->sortBy('x_label')->values();

        $is2D           = $values->whereNotNull('y_label')->count() > 0;
        $interpretation = $this->generateInterpretation($values, $is2D);

        return view('statistics.preview', compact('statistic', 'values', 'interpretation', 'is2D'));
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

        $statistics = Statistic::with('values')
            ->where('status', 'published')
            ->get()
            ->each(function ($stat) {
                // Normalisasi: jika y_label null tapi year terisi, pakai year sebagai y_label
                $stat->values->each(function ($val) {
                    if (is_null($val->y_label) && !is_null($val->year)) {
                        $val->y_label = (string) $val->year;
                    }
                });
            })
            ->each(function ($stat) use ($titlesByJudul) {
                $title = $titlesByJudul->get($stat->judul_data);

                $stat->setAttribute('judul_kolom', $title?->judul_kolom ?: 'Kategori');
                $stat->setAttribute('components', $title?->components?->map(function ($comp) {
                    return [
                        'id'     => $comp->id,
                        'nama'   => $comp->nama,
                        'is_sub' => (bool) $comp->is_sub,
                        'urutan' => $comp->urutan,
                    ];
                })->values() ?? collect());

                $stat->setRelation('values', $stat->values->sortBy([
                    ['x_label', 'asc'],
                    ['y_label', 'asc'],
                ])->values());
            });

        return view('statistics.grafik', compact('statistics'));
    }

    public function publish($id)
    {
        $statistic = Statistic::findOrFail($id);
        $statistic->update(['status' => 'published']);
        return redirect()->route('statistics.index');
    }
}
