<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Models\StatisticValue;

class StatisticController extends Controller
{
    public function index()
    {
        $statistics = Statistic::latest()->get();
        return view('statistics.index', compact('statistics'));
    }

    public function create()
    {
        return view('statistics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'indikator_data' => 'required',
            'judul_data' => 'required',
            'tahun_data.*' => 'required',
            //'interpretasi_data' => 'required',
            'wilayah_data' => 'required',
            'file_data' => 'required|file|mimes:pdf,xlsx,csv|max:2048',            
            'interpretasi_lebih_kecil' => 'required',  
            'interpretasi_lebih_besar' => 'required',  
            'value.*' => 'required|numeric',

        ]);

        $filePath = $request->file('file_data')->store('statistics', 'public');


        $statistic = Statistic::create([
            'indikator_data' => $request->indikator_data,
            'judul_data' => $request->judul_data,
            //'tahun_data' => $request->tahun_data,
            //'interpretasi_data' => $request->interpretasi_data,
            'wilayah_data' => $request->wilayah_data,
            'file_data'    => $filePath,  
            'interpretasi_lebih_kecil' => $request->interpretasi_lebih_kecil,  
            'interpretasi_lebih_besar' => $request->interpretasi_lebih_besar,          
            'status' => 'draft'
        ]);

        foreach ($request->tahun_data as $index => $tahun) {
            StatisticValue::create([
                'statistic_id' => $statistic->id,
                'year' => $tahun,
                'value' => $request->value[$index]
            ]);
        }

        return redirect()->route('statistics.preview', $statistic->id);
    }

    public function preview($id)
    {
        $statistic = Statistic::with('values')->findOrFail($id);

        $values = $statistic->values->sortBy('year')->values();

        $interpretation = $this->generateInterpretation($values);

        return view('statistics.preview', compact('statistic','values','interpretation'));
    }

    private function generateInterpretation($values)
    {
        if ($values->count() < 2) return '';

        $first = $values->first()->value;
        $last = $values->last()->value;
        $diff = $last - $first;

        $highest = $values->sortByDesc('value')->first();
        $lowest = $values->sortBy('value')->first();

        return "
        Data menunjukkan perubahan dari {$first}% menjadi {$last}% 
        dengan selisih ".number_format($diff,2)." poin persentase. 
        Nilai tertinggi terjadi pada tahun {$highest->year} sebesar {$highest->value}%, 
        sedangkan terendah pada tahun {$lowest->year} sebesar {$lowest->value}%.
        ";
    }

    public function publish($id)
    {
        $statistic = Statistic::findOrFail($id);
        $statistic->update(['status'=>'published']);

        return redirect()->route('statistics.index');
    }
}

