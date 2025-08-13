<?php

namespace App\Http\Controllers;

use App\Exports\RealisasiExport;
use App\Models\Instrumen;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    // Menampilkan halaman form filter
    public function index()
    {
        $instrumens = Instrumen::orderBy('tahun', 'desc')->get();
        return view('laporan.index', compact('instrumens'));
    }

    // Memproses permintaan export
    public function export(Request $request)
    {
        $request->validate([
            'id_instrumen' => 'required|exists:instrumens,id_instrumen',
            'tahun' => 'required|digits:4',
        ]);

        $id_instrumen = $request->input('id_instrumen');
        $tahun = $request->input('tahun');

        $fileName = 'laporan_realisasi_' . $tahun . '.xlsx';

        // Panggil class Export dengan parameter filter dan unduh filenya
        return Excel::download(new RealisasiExport($id_instrumen, $tahun), $fileName);
    }
}