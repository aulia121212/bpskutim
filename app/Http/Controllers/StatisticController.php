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
        $statistics = Statistic::with(['values', 'title.components'])->get();

        return view('statistics.index', compact('statistics'));
    }

    public function create()
    {
        $statisticTitles = StatisticTitle::orderBy('judul_data')->get();

        return view('statistics.create', compact('statisticTitles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'indikator_data'     => 'required|string|max:255',
            'statistic_title_id' => 'required|exists:statistic_titles,id',
            'wilayah_data'       => 'required|string|max:255',
        ]);

        $title = StatisticTitle::findOrFail($request->statistic_title_id);

        $statistic = Statistic::create([
            'indikator_data'           => $request->indikator_data,
            'statistic_title_id'       => $title->id,
            'judul_data'               => $title->judul_data,
            'wilayah_data'             => $request->wilayah_data,
            'interpretasi_lebih_kecil' => $title->interpretasi_lebih_kecil,
            'interpretasi_lebih_besar' => $title->interpretasi_lebih_besar,
            'interpretasi_tetap'       => $title->interpretasi_tetap,
            'status'                   => 'draft',
        ]);

        $this->saveGridJson(
            $request->input('grid_json'),
            $statistic->id
        );

        return redirect()->route('statistics.preview', $statistic->id);
    }

    public function preview($id)
    {
        $statistic = Statistic::with([
            'values',
            'title.components'
        ])->findOrFail($id);

        $values = $statistic->values
            ->map(function ($val) {
                $val = clone $val;

                if (is_null($val->y_label) && !is_null($val->year)) {
                    $val->y_label = (string) $val->year;
                }

                if (is_null($val->x_label)) {
                    $val->x_label = 'Tanpa Kategori';
                }

                return $val;
            })
            ->sortBy([
                ['x_label', 'asc'],
                ['y_label', 'asc'],
            ])
            ->values();

        $is2D = $values->whereNotNull('y_label')->count() > 0;

        $interpretation = $this->generateInterpretation($values, $is2D);

        return view('statistics.preview', compact(
            'statistic',
            'values',
            'interpretation',
            'is2D'
        ));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $statistic = Statistic::with('values')->findOrFail($id);

        $existingGrid = $statistic->values
            ->map(function ($val) {
                return [
                    'x_label' => $val->x_label ?? 'Tanpa Kategori',
                    'y_label' => $val->y_label ?? (
                        $val->year ? (string) $val->year : null
                    ),
                    'value' => $val->value,
                ];
            })
            ->values()
            ->toArray();

        return view('statistics.edit', compact(
            'statistic',
            'existingGrid'
        ));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'wilayah_data' => 'required|string|max:255',
        ]);

        $statistic = Statistic::findOrFail($id);

        $statistic->update([
            'wilayah_data' => $request->wilayah_data,
        ]);

        // Hapus data lama
        $statistic->values()->delete();

        // Simpan data baru
        $this->saveGridJson(
            $request->input('grid_json'),
            $statistic->id
        );

        return redirect()
            ->route('statistics.preview', $statistic->id)
            ->with('success', 'Data statistik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $statistic = Statistic::with('values')->findOrFail($id);

        $statistic->values()->delete();
        $statistic->delete();

        return redirect()
            ->route('statistics.index')
            ->with('success', 'Data statistik berhasil dihapus.');
    }

    public function publish($id)
    {
        $statistic = Statistic::findOrFail($id);

        $statistic->update([
            'status' => 'published'
        ]);

        return redirect()->route('statistics.index');
    }

    public function grafik()
    {
        $statistics = Statistic::with([
                'values',
                'title.components'
            ])
            ->where('status', 'published')
            ->get();

        return view('statistics.grafik', compact('statistics'));
    }

    // ─────────────────────────────────────────────
    // Helper: Simpan grid_json ke statistic_values
    // ─────────────────────────────────────────────
    private function saveGridJson(?string $gridJson, int $statisticId): void
    {
        if (
            !$gridJson ||
            $gridJson === '[]' ||
            $gridJson === 'null'
        ) {
            return;
        }

        $rows = json_decode($gridJson, true);

        if (!is_array($rows) || count($rows) === 0) {
            return;
        }

        foreach ($rows as $row) {
            $xLabel = trim($row['x_label'] ?? '');

            $yLabel = isset($row['y_label']) &&
                      $row['y_label'] !== ''
                ? trim($row['y_label'])
                : null;

            $value = $row['value'] ?? null;

            if ($xLabel === '' || is_null($value)) {
                continue;
            }

            StatisticValue::create([
                'statistic_id' => $statisticId,
                'year'         => null,
                'x_label'      => $xLabel,
                'y_label'      => $yLabel,
                'value'        => is_numeric($value)
                    ? $value
                    : 0,
            ]);
        }
    }

    // ─────────────────────────────────────────────
    // Helper: Generate interpretasi
    // ─────────────────────────────────────────────
    private function generateInterpretation($values, bool $is2D = false): string
    {
        if ($is2D || $values->count() < 2) {
            return '';
        }

        $sorted = $values->sortBy('x_label');

        $first = $sorted->first();
        $last  = $sorted->last();

        $diff = $last->value - $first->value;

        $highest = $values->sortByDesc('value')->first();
        $lowest  = $values->sortBy('value')->first();

        return
            "Data menunjukkan perubahan dari {$first->value} ({$first->x_label}) " .
            "menjadi {$last->value} ({$last->x_label}) " .
            "dengan selisih " . number_format(abs($diff), 2) . ". " .
            "Tertinggi: {$highest->x_label} ({$highest->value}), " .
            "Terendah: {$lowest->x_label} ({$lowest->value}).";
    }
}