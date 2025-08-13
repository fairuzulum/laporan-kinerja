<?php

namespace App\Http\Controllers;

use App\Models\PohonKinerja;
use App\Models\Realisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RealisasiController extends Controller
{
    // ... method index() tidak berubah ...
    // public function index()
    // {
    //     $user = Auth::user();
    //     $unitKerja = $user->unitKerja;

    //     if (!$unitKerja) {
    //         return view('realisasi.index', ['assignedPohonKinerjas' => collect()]);
    //     }

    //     $assignedPohonKinerjas = $unitKerja->pohonKinerjas()->with('realisasis')->get();

    //     return view('realisasi.index', compact('assignedPohonKinerjas'));
    // }
    // Ganti method index() yang lama dengan ini:
    public function index()
    {
        $user = Auth::user();
        $unitKerja = $user->unitKerja;

        if (!$unitKerja) {
            return view('realisasi.index', ['assignedPohonKinerjas' => collect()]);
        }

        // Tambahkan 'realisasis.evaluasiLaporans' untuk eager loading
        $assignedPohonKinerjas = $unitKerja->pohonKinerjas()
            ->with(['realisasis.evaluasiLaporans'])
            ->get();

        return view('realisasi.index', compact('assignedPohonKinerjas'));
    }

    // ... method create() tidak berubah ...
    public function create(PohonKinerja $pohonKinerja, $tahun)
    {
        $userUnitId = Auth::user()->id_unit_fk;
        if (!$pohonKinerja->unitKerjas()->where('unit_kerjas.id_unit', $userUnitId)->exists()) {
            abort(403, 'Anda tidak memiliki akses untuk melaporkan indikator ini.');
        }

        return view('realisasi.create', compact('pohonKinerja', 'tahun'));
    }


    // Sesuaikan method store()
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pk_fk' => 'required|exists:pohon_kinerja,id_pk',
            'tahun_laporan' => 'required|digits:4',
            'capaian_realisasi' => 'required|numeric',
            'anggaran_realisasi' => 'nullable|numeric', // Tambahkan validasi anggaran
            'analisis_progres' => 'nullable|string',
            'analisis_kendala' => 'nullable|string',
            'analisis_strategi' => 'nullable|string',
            'link_bukti' => 'nullable|url',
        ]);

        Realisasi::create(array_merge($validated, ['id_unit_fk' => Auth::user()->id_unit_fk]));

        return redirect()->route('realisasi.index')->with('success', 'Laporan realisasi berhasil disubmit.');
    }


    // METHOD BARU: edit()
    public function edit(Realisasi $realisasi)
    {
        // Otorisasi: pastikan hanya unit kerja yang bersangkutan yang bisa edit
        if ($realisasi->id_unit_fk !== Auth::user()->id_unit_fk) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah laporan ini.');
        }

        return view('realisasi.edit', compact('realisasi'));
    }

    // METHOD BARU: update()
    public function update(Request $request, Realisasi $realisasi)
    {
        // Otorisasi
        if ($realisasi->id_unit_fk !== Auth::user()->id_unit_fk) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah laporan ini.');
        }

        $validated = $request->validate([
            'tahun_laporan' => 'required|digits:4',
            'capaian_realisasi' => 'required|numeric',
            'anggaran_realisasi' => 'nullable|numeric', // Tambahkan validasi anggaran
            'analisis_progres' => 'nullable|string',
            'analisis_kendala' => 'nullable|string',
            'analisis_strategi' => 'nullable|string',
            'link_bukti' => 'nullable|url',
        ]);

        $realisasi->update($validated);

        return redirect()->route('realisasi.index')->with('success', 'Laporan realisasi berhasil diperbarui.');
    }

    // Tambahkan method baru ini di dalam class RealisasiController

    public function show(Realisasi $realisasi)
    {
        // Otorisasi: Pastikan user yang login adalah pemilik laporan ini
        if ($realisasi->id_unit_fk !== Auth::user()->id_unit_fk) {
            abort(403, 'Anda tidak memiliki akses untuk melihat laporan ini.');
        }

        // Eager load relasi yang dibutuhkan di halaman detail
        $realisasi->load(['pohonKinerja', 'evaluasiLaporans.user']);

        return view('realisasi.show', compact('realisasi'));
    }
}
