<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatisticTitle;
use App\Models\StatisticTitleComponent;

use Illuminate\Support\Facades\DB;

class StatisticTitleController extends Controller
{
    // app/Http/Controllers/StatisticTitleController.php

// app/Http/Controllers/StatisticTitleController.php

public function index()
{
    // ✅ Pastikan relasi 'components' dimuat dengan ->with()
    // ✅ Ganti $titles menjadi $statistics agar sesuai dengan Blade
    $statistics = StatisticTitle::with('components')
        ->get(); // Gunakan ->get() agar semua data tersedia untuk filter client-side

    // ✅ Pastikan nama view sesuai dengan file Blade Anda
    return view('statistic-titles.index', compact('statistics'));
}

    public function store(Request $request)
    {
        $request->validate([
            'judul_data'  => 'required|string|max:255',
            'judul_kolom' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {

            $title = StatisticTitle::create([
                'judul_data'               => $request->judul_data,
                'judul_kolom'              => $request->judul_kolom,
                'interpretasi_lebih_kecil' => $request->interpretasi_lebih_kecil,
                'interpretasi_lebih_besar' => $request->interpretasi_lebih_besar,
            ]);

            $this->syncComponents($title, $request->input('components', []));
        });

        return redirect()->route('statistic-titles.index')
            ->with('success', 'Judul data berhasil ditambahkan.');
    }

    public function update(Request $request, StatisticTitle $statisticTitle)
    {
        $request->validate([
            'judul_data'  => 'required|string|max:255',
            'judul_kolom' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $statisticTitle) {

            $statisticTitle->update([
                'judul_data'               => $request->judul_data,
                'judul_kolom'              => $request->judul_kolom,
                'interpretasi_lebih_kecil' => $request->interpretasi_lebih_kecil,
                'interpretasi_lebih_besar' => $request->interpretasi_lebih_besar,
            ]);

            $statisticTitle->components()->delete();

            $this->syncComponents(
                $statisticTitle,
                $request->input('components', [])
            );
        });

        return redirect()->route('statistic-titles.index')
            ->with('success', 'Judul data berhasil diperbarui.');
    }

    public function destroy(StatisticTitle $statisticTitle)
    {
        DB::transaction(function () use ($statisticTitle) {

            $statisticTitle->components()->delete();
            $statisticTitle->delete();
        });

        return redirect()->route('statistic-titles.index')
            ->with('success', 'Judul data berhasil dihapus.');
    }

    public function getInterpretasi(StatisticTitle $statisticTitle)
    {
        $statisticTitle->load([
            'components' => function ($q) {
                $q->orderBy('urutan');
            }
        ]);

        return response()->json([
            'interpretasi_lebih_kecil' => $statisticTitle->interpretasi_lebih_kecil,
            'interpretasi_lebih_besar' => $statisticTitle->interpretasi_lebih_besar,
            'judul_kolom'              => $statisticTitle->judul_kolom,
            'components'               => $statisticTitle->components->map(function ($c) {
                return [
                    'nama'   => $c->nama,
                    'is_sub' => $c->is_sub,
                    'urutan' => $c->urutan
                ];
            })
        ]);
    }

    private function syncComponents(StatisticTitle $title, array $components): void
    {
        foreach ($components as $i => $comp) {

            $nama = trim($comp['nama'] ?? '');

            if ($nama === '') {
                continue;
            }

            StatisticTitleComponent::create([
                'statistic_title_id' => $title->id,
                'nama'               => $nama,
                'is_sub'             => !empty($comp['is_sub']),
                'urutan'             => $i
            ]);
        }
    }
}

// class StatisticTitleController extends Controller
// {
//     public function index()
//     {
//         $titles = StatisticTitle::with('components')->latest()->paginate(20);
//         return view('statistic-titles.index', compact('titles'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'judul_data'  => 'required|string|max:255',
//             'judul_kolom' => 'nullable|string|max:255',
//         ]);

//         $title = StatisticTitle::create([
//             'judul_data'               => $request->judul_data,
//             'judul_kolom'              => $request->judul_kolom,
//             'interpretasi_lebih_kecil' => $request->interpretasi_lebih_kecil,
//             'interpretasi_lebih_besar' => $request->interpretasi_lebih_besar,
//         ]);

//         // Simpan komponen
//         $this->syncComponents($title, $request->input('components', []));

//         return redirect()->route('statistic-titles.index')
//             ->with('success', 'Judul data berhasil ditambahkan.');
//     }

//     public function update(Request $request, StatisticTitle $statisticTitle)
//     {
//         $request->validate([
//             'judul_data'  => 'required|string|max:255',
//             'judul_kolom' => 'nullable|string|max:255',
//         ]);

//         $statisticTitle->update([
//             'judul_data'               => $request->judul_data,
//             'judul_kolom'              => $request->judul_kolom,
//             'interpretasi_lebih_kecil' => $request->interpretasi_lebih_kecil,
//             'interpretasi_lebih_besar' => $request->interpretasi_lebih_besar,
//         ]);

//         // Hapus lama, simpan baru
//         $statisticTitle->components()->delete();
//         $this->syncComponents($statisticTitle, $request->input('components', []));

//         return redirect()->route('statistic-titles.index')
//             ->with('success', 'Judul data berhasil diperbarui.');
//     }

//     public function destroy(StatisticTitle $statisticTitle)
//     {
//         $statisticTitle->components()->delete();
//         $statisticTitle->delete();

//         return redirect()->route('statistic-titles.index')
//             ->with('success', 'Judul data berhasil dihapus.');
//     }

//     public function getInterpretasi(StatisticTitle $statisticTitle)
//     {
//         return response()->json([
//             'interpretasi_lebih_kecil' => $statisticTitle->interpretasi_lebih_kecil,
//             'interpretasi_lebih_besar' => $statisticTitle->interpretasi_lebih_besar,
//             'judul_kolom'              => $statisticTitle->judul_kolom,
//             'components'               => $statisticTitle->components->map(fn($c) => [
//                 'nama'   => $c->nama,
//                 'is_sub' => $c->is_sub,
//             ]),
//         ]);
//     }

//     private function syncComponents(StatisticTitle $title, array $components): void
//     {
//         foreach ($components as $i => $comp) {
//             $nama = trim($comp['nama'] ?? '');
//             if ($nama === '') continue;

//             StatisticTitleComponent::create([
//                 'statistic_title_id' => $title->id,
//                 'nama'               => $nama,
//                 'is_sub'             => ($comp['is_sub'] ?? '0') === '1',
//                 'urutan'             => $i,
//             ]);
//         }
//     }
// }