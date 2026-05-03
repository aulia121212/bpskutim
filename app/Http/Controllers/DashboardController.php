<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ReservasiKonsultasi;
use App\Models\Petugas;
use App\Models\Statistic;
use App\Models\StatisticTitle;
use Carbon\Carbon;
use App\Models\RiwayatKonsultasi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return match ($user->role) {
            User::ROLE_SUPER_ADMIN     => $this->superAdminDashboard(),
            User::ROLE_ADMIN_PELAYANAN => $this->adminPelayananDashboard(),
            User::ROLE_ADMIN_STATISTIK => $this->adminStatistikDashboard(),
            default                    => redirect()->route('home'),
        };
    }

    // ──────────────────────────────────────────────────────────────────
    // SUPER ADMIN
    // ──────────────────────────────────────────────────────────────────
   private function superAdminDashboard()
    {
        $now = Carbon::now();
 
        $totalAdmin     = User::whereIn('role', [
            User::ROLE_SUPER_ADMIN,
            User::ROLE_ADMIN_PELAYANAN,
            User::ROLE_ADMIN_STATISTIK,
        ])->count();
        $totalPetugas   = Petugas::count();
        $totalUser      = User::where('role', User::ROLE_USER)->count();
 
        // Statistik — pakai kolom 'status' sesuai DB
        $totalStatistik = Statistic::count();
        $dipublikasikan = Statistic::where('status', 'published')->count();
        $draftStatistik = Statistic::whereIn('status', ['draft', 'review'])->count();
 
        // Reservasi
        $totalReservasi = ReservasiKonsultasi::count();
        $menunggu       = ReservasiKonsultasi::whereHas('riwayatTerbaru', fn($q) =>
            $q->where('status_pengajuan', 'diajukan')
        )->count();
        $selesaiBulanIni = RiwayatKonsultasi::where('status_pengajuan', 'selesai')
            ->whereMonth('updated_at', $now->month)
            ->whereYear('updated_at', $now->year)
            ->count();
 
        // Grafik reservasi per bulan (12 bulan terakhir)
        $grafikReservasi = collect(range(11, 0))->map(function ($i) use ($now) {
            $bulan = $now->copy()->subMonths($i);
            return [
                'label' => $bulan->translatedFormat('M Y'),
                'count' => ReservasiKonsultasi::whereYear('created_at', $bulan->year)
                    ->whereMonth('created_at', $bulan->month)->count(),
            ];
        });
 
        // Grafik data statistik per bulan
        $grafikStatistik = collect(range(11, 0))->map(function ($i) use ($now) {
            $bulan = $now->copy()->subMonths($i);
            return [
                'label' => $bulan->translatedFormat('M Y'),
                'count' => Statistic::whereYear('updated_at', $bulan->year)
                    ->whereMonth('updated_at', $bulan->month)->count(),
            ];
        });
 
        // Reservasi terbaru (5)
        $reservasiTerbaru = ReservasiKonsultasi::with(['user', 'petugas', 'riwayatTerbaru'])
            ->latest('created_at')->limit(5)->get();
 
        // Data statistik terbaru (5)
        $dataTerbaru = Statistic::with('statisticTitle')->latest()->limit(5)->get();
 
        // Distribusi status reservasi
        $distribusiStatus = [
            'diajukan'    => ReservasiKonsultasi::whereHas('riwayatTerbaru', fn($q) => $q->where('status_pengajuan', 'diajukan'))->count(),
            'dijadwalkan' => ReservasiKonsultasi::whereHas('riwayatTerbaru', fn($q) => $q->where('status_pengajuan', 'dijadwalkan'))->count(),
            'selesai'     => ReservasiKonsultasi::whereHas('riwayatTerbaru', fn($q) => $q->where('status_pengajuan', 'selesai'))->count(),
            'dibatalkan'  => ReservasiKonsultasi::whereHas('riwayatTerbaru', fn($q) => $q->where('status_pengajuan', 'dibatalkan'))->count(),
        ];
 
        return view('dashboard.index', compact(
            'totalAdmin', 'totalPetugas', 'totalUser',
            'totalStatistik', 'dipublikasikan', 'draftStatistik',
            'totalReservasi', 'menunggu', 'selesaiBulanIni',
            'grafikReservasi', 'grafikStatistik',
            'reservasiTerbaru', 'dataTerbaru', 'distribusiStatus'
        ));
    }

    // ──────────────────────────────────────────────────────────────────
    // ADMIN PELAYANAN
    // ──────────────────────────────────────────────────────────────────
    private function adminPelayananDashboard()
    {
        // Status reservasi bukan kolom langsung — ada di riwayat_konsultasi
        // via accessor $reservasi->status → riwayatTerbaru->status_pengajuan
        // Kita load semua + riwayatTerbaru lalu filter di collection
        $semuaReservasi = ReservasiKonsultasi::with('riwayatTerbaru')->get();

        $menungguTindak  = $semuaReservasi->filter(
            fn($r) => in_array($r->status, ['diajukan', 'pending'])
        )->count();

        $selesaiBulanIni = $semuaReservasi->filter(
            fn($r) => $r->status === 'selesai'
                   && optional($r->riwayatTerbaru->updated_at)->month === now()->month
                   && optional($r->riwayatTerbaru->updated_at)->year  === now()->year
        )->count();

        $stats = [
            'total_petugas'     => Petugas::count(),
            'reservasi_masuk'   => $semuaReservasi->count(),
            'menunggu_tindak'   => $menungguTindak,
            'selesai_bulan_ini' => $selesaiBulanIni,
        ];

        // 5 reservasi terbaru — load user & riwayat terbaru untuk tampil di tabel
        $reservasiTerbaru = ReservasiKonsultasi::with(['user', 'riwayatTerbaru'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Model Jadwal belum ada di project — kirim collection kosong dulu
        // Uncomment setelah model Jadwal tersedia:
        // $jadwalHariIni = \App\Models\Jadwal::whereDate('tanggal', today())
        //     ->with('petugas')->get();
        $jadwalHariIni = collect();

        return view('dashboard.admin_pelayanan', compact(
            'stats',
            'reservasiTerbaru',
            'jadwalHariIni'
        ));
    }

    // ──────────────────────────────────────────────────────────────────
    // ADMIN STATISTIK
    // ──────────────────────────────────────────────────────────────────
    private function adminStatistikDashboard()
    {
        // Kolom 'status' di tabel statistics — sesuaikan nilai string-nya
        // dengan yang ada di database (cek migration/seeder kamu)
        $totalData      = Statistic::count();
        $dipublikasikan = Statistic::where('status', 'published')->count();
        $draftReview    = Statistic::whereIn('status', ['draft', 'review'])->count();
        $totalJudul     = StatisticTitle::count();

        $stats = [
            'total_data'     => $totalData,
            'dipublikasikan' => $dipublikasikan,
            'draft_review'   => $draftReview,
            'total_judul'    => $totalJudul,
        ];

        // 5 data statistik terbaru beserta relasi kategori/judulnya
        $dataTerbaru = Statistic::with('statisticTitle')
            ->latest()
            ->take(5)
            ->get();

        // Jumlah data per StatisticTitle — pakai relasi statistics() di StatisticTitle
        $dataPerKategori = StatisticTitle::withCount('statistics')->get();

        return view('dashboard.admin_statistik', compact(
            'stats',
            'dataTerbaru',
            'dataPerKategori'
        ));
    }

    // ──────────────────────────────────────────────────────────────────
    // ANALYTICS
    // ──────────────────────────────────────────────────────────────────
    public function analytics()
    {
        return view('dashboard.analytics');
    }
}