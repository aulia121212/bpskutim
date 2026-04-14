<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ReservasiKonsultasi;
use App\Models\Petugas;
use App\Models\Statistic;
use App\Models\StatisticTitle;

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
        $stats = [
            'total_admin_pelayanan' => User::where('role', User::ROLE_ADMIN_PELAYANAN)->count(),
            'total_admin_statistik' => User::where('role', User::ROLE_ADMIN_STATISTIK)->count(),
            'total_user'            => User::where('role', User::ROLE_USER)->count(),
            'total_reservasi'       => ReservasiKonsultasi::count(),
            'total_statistik'       => Statistic::count(),
        ];

        return view('dashboard.index', compact('stats'));
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