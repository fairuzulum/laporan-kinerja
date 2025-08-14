<?php

namespace App\Http\Controllers;

use App\Exports\RealisasiExport;
use App\Models\Instrumen;
use App\Models\PohonKinerja;
use App\Models\Realisasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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

    public function indexPdf()
    {
        $pohonKinerjas = PohonKinerja::orderBy('kode_kinerja', 'asc')->get();
        return view('laporan.index_pdf', compact('pohonKinerjas'));
    }

    /**
     * Memproses permintaan export PDF dengan logika yang disesuaikan dengan model.
     */
    public function exportPdf(Request $request)
    {
        // KOREKSI: Validasi diubah ke 'id_pk' sesuai dengan primary key di model PohonKinerja
        $request->validate([
            'id_pk' => 'required|exists:pohon_kinerja,id_pk', 
            'tahun' => 'required|digits:4',
        ]);

        $id_pohon_kinerja = $request->input('id_pk');
        $tahun = $request->input('tahun');

        // Mengambil data Pohon Kinerja berdasarkan primary key 'id_pk'
        $pohonKinerja = PohonKinerja::find($id_pohon_kinerja);

        // KOREKSI: Query diubah menggunakan foreign key 'id_pk_fk' sesuai relasi di model Realisasi
        $realisasis = Realisasi::query()
            ->with('unitKerja') // Relasi 'unitKerja' sudah benar
            ->where('id_pk_fk', $id_pohon_kinerja) 
            ->where('tahun_laporan', $tahun)
            ->get();

        // Cek jika data realisasi tidak ditemukan
        if ($realisasis->isEmpty()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tidak ada data realisasi yang ditemukan untuk indikator dan tahun yang dipilih.');
        }

        // Kirim data ke view dan render PDF
        $pdf = PDF::loadView('laporan.pdf', compact('realisasis', 'tahun', 'pohonKinerja'));
        
        // Membuat nama file yang dinamis
        $fileName = 'laporan_realisasi_' . str_replace('/', '-', $pohonKinerja->kode_kinerja) . '_' . $tahun . '.pdf';

        return $pdf->download($fileName);
    }
}