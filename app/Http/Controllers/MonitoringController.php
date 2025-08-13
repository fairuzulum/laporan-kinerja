<?php

namespace App\Http\Controllers;

use App\Models\PohonKinerja;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        // Ambil semua PohonKinerja yang MEMILIKI penugasan ke unit kerja.
        // Kita juga eager load relasi unitKerjas dan realisasis agar query lebih efisien.
        $pohonKinerjas = PohonKinerja::has('unitKerjas')
                                    ->with(['unitKerjas' => function ($query) {
                                        $query->orderBy('nama_unit');
                                    }, 'realisasis'])
                                    ->get();

        return view('monitoring.index', compact('pohonKinerjas'));
    }
}