<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use Illuminate\Http\Request;

class EvaluatorController extends Controller
{
    public function dashboard()
    {
        // Ambil semua laporan realisasi, urutkan dari yang terbaru
        // Eager load relasi untuk efisiensi
        $semuaLaporan = Realisasi::with(['pohonKinerja', 'unitKerja'])
                                ->latest()
                                ->get();

        return view('evaluator.dashboard', compact('semuaLaporan'));
    }
}