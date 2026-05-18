<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatisticTitle;
use App\Models\StatisticTitleComponent;
use Illuminate\Support\Facades\DB;

class StatisticTitleController extends Controller
{
    public function index()
    {
        $titles = StatisticTitle::with('components')
            ->latest()
            ->paginate(10);

        return view('statistic-titles.index', compact('titles'));
    }

    public function show(StatisticTitle $statisticTitle)
    {
        $statisticTitle->load(['components' => fn($q) => $q->orderBy('urutan')]);

        return view('statistic-titles.show', compact('statisticTitle'));
    }

    public function edit(StatisticTitle $statisticTitle)
    {
        $statisticTitle->load(['components' => fn($q) => $q->orderBy('urutan')]);

        $existingComponents = $statisticTitle->components
            ->sortBy('urutan')
            ->values()
            ->map(fn($c) => [
                'id'                       => $c->id,   // ✅ Sertakan id agar update() bisa match
                'nama'                     => $c->nama,
                'satuan'                   => $c->satuan ?? '',
                'definisi'                 => $c->definisi ?? '',
                'is_sub'                   => (bool) $c->is_sub,
                'interpretasi_lebih_kecil' => $c->interpretasi_lebih_kecil ?? '',
                'interpretasi_lebih_besar' => $c->interpretasi_lebih_besar ?? '',
                'interpretasi_tetap'       => $c->interpretasi_tetap ?? '',
            ])
            ->toArray();

        return view('statistic-titles.edit', compact('statisticTitle', 'existingComponents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'indikator_data' => 'required|string|max:255',
            'judul_data'     => 'required|string|max:255',
            'judul_kolom'    => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $title = StatisticTitle::create([
                'indikator_data'           => $request->indikator_data,
                'judul_data'               => $request->judul_data,
                'judul_kolom'              => $request->judul_kolom,
                'interpretasi_lebih_kecil' => $request->interpretasi_lebih_kecil,
                'interpretasi_lebih_besar' => $request->interpretasi_lebih_besar,
                'interpretasi_tetap'       => $request->interpretasi_tetap,
            ]);

            $this->syncComponents($title, $request->input('components', []));
        });

        return redirect()->route('statistic-titles.index')
            ->with('success', 'Judul data berhasil ditambahkan.');
    }

    public function update(Request $request, StatisticTitle $statisticTitle)
    {
        $request->validate([
            'indikator_data' => 'required|string|max:255',
            'judul_data'     => 'required|string|max:255',
            'judul_kolom'    => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $statisticTitle) {
            $statisticTitle->update([
                'indikator_data'           => $request->indikator_data,
                'judul_data'               => $request->judul_data,
                'judul_kolom'              => $request->judul_kolom,
                'interpretasi_lebih_kecil' => $request->interpretasi_lebih_kecil,
                'interpretasi_lebih_besar' => $request->interpretasi_lebih_besar,
                'interpretasi_tetap'       => $request->interpretasi_tetap,
            ]);

            // ✅ Ganti: sync cerdas — tidak delete semua
            $this->syncComponentsForUpdate($statisticTitle, $request->input('components', []));
        });

        return redirect()->route('statistic-titles.show', $statisticTitle->id)
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
        $statisticTitle->load(['components' => fn($q) => $q->orderBy('urutan')]);

        return response()->json([
            'interpretasi_lebih_kecil' => $statisticTitle->interpretasi_lebih_kecil,
            'interpretasi_lebih_besar' => $statisticTitle->interpretasi_lebih_besar,
            'interpretasi_tetap'       => $statisticTitle->interpretasi_tetap,
            'judul_kolom'              => $statisticTitle->judul_kolom,
            'components'               => $statisticTitle->components->map(fn($c) => [
                'nama'                     => $c->nama,
                'is_sub'                   => $c->is_sub,
                'satuan'                   => $c->satuan,
                'definisi'                 => $c->definisi,
                'urutan'                   => $c->urutan,
                'interpretasi_lebih_kecil' => $c->interpretasi_lebih_kecil,
                'interpretasi_lebih_besar' => $c->interpretasi_lebih_besar,
                'interpretasi_tetap'       => $c->interpretasi_tetap,
            ]),
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    // Dipakai saat STORE (data baru, tidak ada komponen existing)
    // ─────────────────────────────────────────────────────────────
    private function syncComponents(StatisticTitle $title, array $components): void
    {
        foreach ($components as $i => $comp) {
            $nama = trim($comp['nama'] ?? '');
            if ($nama === '') continue;

            StatisticTitleComponent::create([
                'statistic_title_id'       => $title->id,
                'nama'                     => $nama,
                'is_sub'                   => !empty($comp['is_sub']),
                'satuan'                   => $comp['satuan'] ?? null,
                'definisi'                 => $comp['definisi'] ?? null,
                'urutan'                   => $i,
                'interpretasi_lebih_kecil' => $comp['interpretasi_lebih_kecil'] ?? null,
                'interpretasi_lebih_besar' => $comp['interpretasi_lebih_besar'] ?? null,
                'interpretasi_tetap'       => $comp['interpretasi_tetap'] ?? null,
            ]);
        }
    }

    // ─────────────────────────────────────────────────────────────
    // Dipakai saat UPDATE:
    // - Komponen dengan id yang dikenal  → UPDATE (nama boleh berubah)
    // - Komponen tanpa id / id baru      → INSERT
    // - Komponen yang tidak ada di form  → DELETE
    // ─────────────────────────────────────────────────────────────
    private function syncComponentsForUpdate(StatisticTitle $title, array $components): void
    {
        // Kumpulkan id yang dikirim dari form (hanya yang valid & milik title ini)
        $validExistingIds = $title->components()->pluck('id')->toArray();
        $keptIds          = [];

        foreach ($components as $i => $comp) {
            $nama = trim($comp['nama'] ?? '');
            if ($nama === '') continue;

            $incomingId = isset($comp['id']) ? (int) $comp['id'] : null;

            if ($incomingId && in_array($incomingId, $validExistingIds)) {

    // ambil nama lama sebelum update
    $oldComponent = StatisticTitleComponent::find($incomingId);
    $oldName = $oldComponent?->nama;

    // update komponen
    StatisticTitleComponent::where('id', $incomingId)->update([
        'nama'                     => $nama,
        'is_sub'                   => !empty($comp['is_sub']),
        'satuan'                   => $comp['satuan'] ?? null,
        'definisi'                 => $comp['definisi'] ?? null,
        'urutan'                   => $i,
        'interpretasi_lebih_kecil' => $comp['interpretasi_lebih_kecil'] ?? null,
        'interpretasi_lebih_besar' => $comp['interpretasi_lebih_besar'] ?? null,
        'interpretasi_tetap'       => $comp['interpretasi_tetap'] ?? null,
    ]);

    // ✅ sinkronkan nama lama ke data statistik
    if ($oldName && $oldName !== $nama) {

        \App\Models\StatisticValue::where('x_label', $oldName)
            ->update([
                'x_label' => $nama
            ]);

        \App\Models\StatisticValue::where('y_label', $oldName)
            ->update([
                'y_label' => $nama
            ]);
    }

    $keptIds[] = $incomingId;
} else {
                // ✅ Komponen baru (tidak ada id / id tidak dikenal) → INSERT
                $newComp   = StatisticTitleComponent::create([
                    'statistic_title_id'       => $title->id,
                    'nama'                     => $nama,
                    'is_sub'                   => !empty($comp['is_sub']),
                    'satuan'                   => $comp['satuan'] ?? null,
                    'definisi'                 => $comp['definisi'] ?? null,
                    'urutan'                   => $i,
                    'interpretasi_lebih_kecil' => $comp['interpretasi_lebih_kecil'] ?? null,
                    'interpretasi_lebih_besar' => $comp['interpretasi_lebih_besar'] ?? null,
                    'interpretasi_tetap'       => $comp['interpretasi_tetap'] ?? null,
                ]);
                $keptIds[] = $newComp->id;
            }
        }

        // ✅ Hapus HANYA komponen yang memang dihilangkan user dari form
        if (!empty($keptIds)) {
            $title->components()
                ->whereNotIn('id', $keptIds)
                ->delete();
        }
        // Jika $keptIds kosong (form kirim komponen kosong semua), tidak ada yang dihapus
        // — ini safety net agar tidak wipe semua komponen karena bug form
    }
}