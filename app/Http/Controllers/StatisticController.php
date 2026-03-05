<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Models\StatisticValue;
use Illuminate\Support\Facades\Storage;

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
            'indikator_data'    => 'required',
            'statistic_title_id'=> 'required|exists:statistic_titles,id',
            'tahun_data.*'      => 'required',
            'wilayah_data'      => 'required',
            'file_data'         => 'required|file|mimes:pdf,xlsx,csv|max:2048',
            'value.*'           => 'required|numeric',
        ]);

        // Ambil judul & interpretasi dari master
        $title = \App\Models\StatisticTitle::findOrFail($request->statistic_title_id);

        $file     = $request->file('file_data');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/statistics'), $filename);
        $filePath = 'uploads/statistics/' . $filename;

        $statistic = Statistic::create([
            'indikator_data'           => $request->indikator_data,
            'judul_data'               => $title->judul_data,
            'wilayah_data'             => $request->wilayah_data,
            'file_data'                => $filePath,
            'interpretasi_lebih_kecil' => $title->interpretasi_lebih_kecil,
            'interpretasi_lebih_besar' => $title->interpretasi_lebih_besar,
            'status'                   => 'draft',
        ]);

        foreach ($request->tahun_data as $index => $tahun) {
            StatisticValue::create([
                'statistic_id' => $statistic->id,
                'year'         => $tahun,
                'value'        => $request->value[$index],
            ]);
        }

        return redirect()->route('statistics.preview', $statistic->id);
    }

    public function preview($id)
    {
        $statistic = Statistic::with('values')->findOrFail($id);
        $values    = $statistic->values->sortBy('year')->values();
        $interpretation = $this->generateInterpretation($values);

        return view('statistics.preview', compact('statistic', 'values', 'interpretation'));
    }

    public function destroy($id)
    {
        $statistic = Statistic::with('values')->findOrFail($id);

        // Hapus file fisik
        $filePath = public_path($statistic->file_data);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus nilai terkait lalu hapus statistik
        $statistic->values()->delete();
        $statistic->delete();

        return redirect()->route('statistics.index')
            ->with('success', 'Data statistik berhasil dihapus.');
    }

    private function generateInterpretation($values)
    {
        if ($values->count() < 2) return '';

        $first   = $values->first()->value;
        $last    = $values->last()->value;
        $diff    = $last - $first;
        $highest = $values->sortByDesc('value')->first();
        $lowest  = $values->sortBy('value')->first();

        return "Data menunjukkan perubahan dari {$first}% menjadi {$last}% 
        dengan selisih " . number_format($diff, 2) . " poin persentase. 
        Nilai tertinggi terjadi pada tahun {$highest->year} sebesar {$highest->value}%, 
        sedangkan terendah pada tahun {$lowest->year} sebesar {$lowest->value}%.";
    }

    public function grafik()
    {
        $statistics = Statistic::with('values')
            ->where('status', 'published')
            ->get()
            ->groupBy('judul_data')
            ->map(function ($group) {
                $merged = $group->first();
                $merged->setRelation('values',
                    $group->flatMap->values->sortBy('year')->values()
                );
                return $merged;
            })
            ->values();

        return view('statistics.grafik', compact('statistics'));
    }

    public function publish($id)
    {
        $statistic = Statistic::findOrFail($id);
        $statistic->update(['status' => 'published']);

        return redirect()->route('statistics.index');
    }
}