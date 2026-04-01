/**
 * API Routes untuk Statistic Titles
 * File: routes/api.php
 * 
 * Tambahkan route berikut ke file routes/api.php
 */

// Route untuk mendapatkan detail statistic title (interpretasi, judul kolom, dll)
Route::get('/statistic-titles/{id}', function($id) {
    $title = \App\Models\StatisticTitle::findOrFail($id);
    
    return response()->json([
        'id' => $title->id,
        'judul_data' => $title->judul_data,
        'judul_kolom' => $title->judul_kolom,
        'indikator_data' => $title->indikator_data,
        'interpretasi_lebih_kecil' => $title->interpretasi_lebih_kecil,
        'interpretasi_lebih_besar' => $title->interpretasi_lebih_besar,
        'interpretasi_tetap' => $title->interpretasi_tetap,
    ]);
});