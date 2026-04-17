<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Models\PopupOverlay;
use App\Models\Publikasi;


class HomeController extends Controller
{
    public function index()
{
    $statistics = Statistic::with('values')
        ->where('status', 'published')
        ->latest()->take(6)->get();

    // $popups = PopupOverlay::whereDate('tanggal_mulai', '<=', today())
    //     ->whereDate('tanggal_akhir', '>=', today())
    //     ->get();

    $activePopup = \App\Models\PopupOverlay::where('tanggal_mulai', '<=', today())
                     ->where('tanggal_akhir', '>=', today())
                     ->latest()->first();
        
    $publikasi = Publikasi::first();

    return view('home', compact('statistics', 'activePopup', 'publikasi'));
}

// HomeController.php
public function dataStatistik()
{
    $statistics = Statistic::with('values')
        ->where('status', 'published')
        ->when(request('indikator'), fn($q) => $q->where('indikator_data', request('indikator')))
        ->latest()->get();

    return view('data-statistik', compact('statistics'));
}



}
