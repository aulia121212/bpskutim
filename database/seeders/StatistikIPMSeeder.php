<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Statistic;
use App\Models\StatisticTitle;
use App\Models\StatisticTitleComponent;
use App\Models\StatisticValue;

class StatistikIPMSeeder extends Seeder
{
    public function run(): void
    {
        // 🔥 NONAKTIFKAN FK (biar aman truncate)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 🔥 HAPUS DATA LAMA
        StatisticValue::truncate();
        Statistic::truncate();
        StatisticTitleComponent::truncate();
        StatisticTitle::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ══════════════════════════════════════════════════════
        // 1. STATISTIC TITLE
        // ══════════════════════════════════════════════════════

        $title = StatisticTitle::create([
            'judul_data'               => 'Indeks Pembangunan Manusia (IPM) Menurut Dimensi Penyusunnya',
            'judul_kolom'              => 'Tahun',
            'interpretasi_lebih_besar' => 'Peningkatan IPM menunjukkan kemajuan dalam dimensi kesehatan, pendidikan, dan standar hidup layak masyarakat.',
            'interpretasi_lebih_kecil' => 'Penurunan IPM menunjukkan adanya perlambatan atau kemunduran dalam salah satu atau lebih dimensi pembangunan manusia.',
            'interpretasi_tetap'       => 'IPM yang relatif stabil menunjukkan kondisi pembangunan manusia yang tidak mengalami perubahan signifikan dibandingkan periode sebelumnya.',
        ]);

        // ══════════════════════════════════════════════════════
        // 2. COMPONENTS
        // ══════════════════════════════════════════════════════

        $components = [
            ['nama' => 'Umur Panjang dan Hidup Sehat', 'is_sub' => false, 'urutan' => 1],
            ['nama' => 'Umur Harapan Hidup (UHH) saat Lahir', 'satuan' => 'tahun', 'is_sub' => true, 'urutan' => 2],
            ['nama' => 'Pengetahuan', 'is_sub' => false, 'urutan' => 3],
            ['nama' => 'Harapan Lama Sekolah (HLS)', 'satuan' => 'tahun', 'is_sub' => true, 'urutan' => 4],
            ['nama' => 'Rata-rata Lama Sekolah (RLS)', 'satuan' => 'tahun', 'is_sub' => true, 'urutan' => 5],
            ['nama' => 'Standar Hidup Layak', 'is_sub' => false, 'urutan' => 6],
            ['nama' => 'Pengeluaran Riil per Kapita (yang disesuaikan)', 'satuan' => 'ribu rupiah', 'is_sub' => true, 'urutan' => 7],
        ];

        foreach ($components as $comp) {
            StatisticTitleComponent::create([
                'statistic_title_id' => $title->id,
                'nama'               => $comp['nama'],
                'satuan'             => $comp['satuan'] ?? null,
                'is_sub'             => $comp['is_sub'],
                'urutan'             => $comp['urutan'],
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        // ══════════════════════════════════════════════════════
        // 3. DATA
        // ══════════════════════════════════════════════════════

        $wilayahData = [
            'Indonesia' => [
                'Umur Harapan Hidup (UHH) saat Lahir' => [2020=>73.37,2021=>73.46,2022=>73.70,2023=>73.93,2024=>74.15,2025=>74.47],
                'Harapan Lama Sekolah (HLS)' => [2020=>12.98,2021=>13.08,2022=>13.10,2023=>13.15,2024=>13.21,2025=>13.30],
                'Rata-rata Lama Sekolah (RLS)' => [2020=>8.48,2021=>8.54,2022=>8.69,2023=>8.77,2024=>8.85,2025=>9.07],
                'Pengeluaran Riil per Kapita (yang disesuaikan)' => [2020=>11013,2021=>11156,2022=>11479,2023=>11899,2024=>12341,2025=>12802],
            ],
            'Kalimantan Timur' => [
                'Umur Harapan Hidup (UHH) saat Lahir' => [2020=>73.70,2021=>74.01,2022=>74.45,2023=>74.72,2024=>74.94,2025=>75.28],
                'Harapan Lama Sekolah (HLS)' => [2020=>13.72,2021=>13.81,2022=>13.84,2023=>14.02,2024=>14.03,2025=>14.04],
                'Rata-rata Lama Sekolah (RLS)' => [2020=>9.77,2021=>9.84,2022=>9.92,2023=>9.99,2024=>10.02,2025=>10.10],
                'Pengeluaran Riil per Kapita (yang disesuaikan)' => [2020=>11728,2021=>12116,2022=>12641,2023=>13202,2024=>13793,2025=>14254],
            ],
            'Kabupaten Kutai Timur' => [
                'Umur Harapan Hidup (UHH) saat Lahir' => [2021=>74.21,2022=>74.22,2023=>74.33,2024=>74.55,2025=>74.87],
                'Harapan Lama Sekolah (HLS)' => [2021=>12.90,2022=>13.00,2023=>13.01,2024=>13.02,2025=>13.22],
                'Rata-rata Lama Sekolah (RLS)' => [2021=>9.43,2022=>9.44,2023=>9.45,2024=>9.47,2025=>9.48],
                'Pengeluaran Riil per Kapita (yang disesuaikan)' => [2021=>10868,2022=>11322,2023=>11961,2024=>12490,2025=>12755],
            ],
        ];

        foreach ($wilayahData as $wilayah => $komponenData) {
            $stat = Statistic::create([
                'statistic_title_id' => $title->id,
                'judul_data'         => $title->judul_data,
                'wilayah_data'       => $wilayah,
                'indikator_data'     => 'indikator_pembangunan_manusia',
                'status'             => 'published',
            ]);

            $values = [];

            foreach ($komponenData as $komponen => $tahunNilai) {
                foreach ($tahunNilai as $tahun => $nilai) {
                    $values[] = [
                        'statistic_id' => $stat->id,
                        'year'         => $tahun,
                        'value'        => $nilai,
                        'x_label'      => (string)$tahun,
                        'y_label'      => $komponen,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }

            StatisticValue::insert($values);
        }

        $this->command->info('✅ Seeder IPM berhasil di-reset & diisi ulang');
    }
}