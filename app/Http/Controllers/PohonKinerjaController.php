<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\PohonKinerja;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class PohonKinerjaController extends Controller
{
    /**
     * Menampilkan halaman utama Pohon Kinerja.
     */
    public function index()
    {
        // 1. Ambil data dari database menggunakan Model
        // Kita hanya ambil data level teratas (induknya NULL)
        $pohonKinerjas = PohonKinerja::whereNull('id_pk_induk')
            ->orderBy('kode_kinerja')
            ->get();

        // 2. Kirim data ke view
        return view('pohon_kinerja.index', [
            'pohonKinerjas' => $pohonKinerjas
        ]);
    }

    public function create(Request $request)
    {
        $induk = null;
        if ($request->has('induk')) {
            $induk = PohonKinerja::find($request->query('induk'));
        }

        $instrumens = Instrumen::orderBy('tahun', 'desc')->get();

        return view('pohon_kinerja.create', [
            'induk' => $induk,
            'instrumens' => $instrumens,
        ]);
    }

    // Method untuk menyimpan data
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'id_pk_induk' => 'nullable|exists:pohon_kinerja,id_pk',
            'id_instrumen_fk' => 'required|exists:instrumens,id_instrumen',
            'deskripsi_sasaran' => 'required|string',
            'indikator' => 'required|string',
            'target' => 'required|numeric',
            'satuan' => 'required|string|max:100',
        ]);

        // 2. Logika Membuat Kode Kinerja
        $kodeBaru = '';
        if (!empty($validated['id_pk_induk'])) {
            $induk = PohonKinerja::find($validated['id_pk_induk']);
            $jumlahAnak = $induk->anak()->count();
            $kodeBaru = $induk->kode_kinerja . '.' . ($jumlahAnak + 1);
        } else {
            $jumlahAnakLevelAtas = PohonKinerja::whereNull('id_pk_induk')
                ->where('id_instrumen_fk', $validated['id_instrumen_fk'])
                ->count();
            $kodeBaru = $jumlahAnakLevelAtas + 1;
        }

        // 3. Simpan Data ke Database
        PohonKinerja::create([
            'id_pk_induk' => $validated['id_pk_induk'],
            'id_instrumen_fk' => $validated['id_instrumen_fk'],
            'kode_kinerja' => $kodeBaru,
            'deskripsi_sasaran' => $validated['deskripsi_sasaran'],
            'indikator' => $validated['indikator'],
            'target' => $validated['target'],
            'satuan' => $validated['satuan'],
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('pohon-kinerja.index')->with('success', 'Data Pohon Kinerja berhasil ditambahkan!');
    }

    public function edit(PohonKinerja $pohonKinerja)
    {
        return view('pohon_kinerja.edit', [
            'pohonKinerja' => $pohonKinerja,
        ]);
    }

    // Method untuk memproses update
    public function update(Request $request, PohonKinerja $pohonKinerja)
    {
        // 1. Validasi Input (mirip dengan store)
        $validated = $request->validate([
            'deskripsi_sasaran' => 'required|string',
            'indikator' => 'required|string',
            'target' => 'required|numeric',
            'satuan' => 'required|string|max:100',
        ]);

        // 2. Update data di database
        // Kita tidak mengubah kode_kinerja atau induk saat edit
        $pohonKinerja->update($validated);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('pohon-kinerja.index')->with('success', 'Data berhasil diperbarui!');
    }

    // Method untuk menghapus data
    public function destroy(PohonKinerja $pohonKinerja)
    {
        // Hapus data dari database
        // Laravel otomatis akan menghapus semua data anak karena aturan 'onDelete(cascade)'
        $pohonKinerja->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('pohon-kinerja.index')->with('success', 'Data beserta seluruh sub-itemnya berhasil dihapus!');
    }

    // Method untuk menampilkan halaman form assignment
    public function showAssignForm(PohonKinerja $pohonKinerja)
    {
        // 1. Ambil semua unit kerja yang ada
        $allUnits = UnitKerja::orderBy('nama_unit')->get();

        // 2. Ambil ID dari unit kerja yang SUDAH ditugaskan ke pohon kinerja ini
        $assignedUnitIds = $pohonKinerja->unitKerjas()->pluck('unit_kerjas.id_unit')->toArray();

        return view('pohon_kinerja.assign', compact('pohonKinerja', 'allUnits', 'assignedUnitIds'));
    }

    // Method untuk memproses dan menyimpan assignment
    public function syncAssignments(Request $request, PohonKinerja $pohonKinerja)
    {
        // Method sync() adalah cara Eloquent yang sangat elegan.
        // Ia akan secara otomatis:
        // 1. Menghapus semua relasi lama yang tidak ada di array baru.
        // 2. Menambahkan semua relasi baru yang ada di array.
        // 3. Mempertahankan relasi yang sudah ada.
        // Jika tidak ada checkbox yang dipilih, $request->input('unit_ids', []) akan menjadi array kosong,
        // dan sync() akan menghapus semua penugasan.
        $pohonKinerja->unitKerjas()->sync($request->input('unit_ids', []));

        return redirect()->route('pohon-kinerja.index')->with('success', 'Penugasan unit kerja berhasil diperbarui!');
    }

    public function show(PohonKinerja $pohonKinerja)
    {
        // Eager load semua relasi yang akan ditampilkan di halaman detail
        // untuk menghindari N+1 query problem dan membuat performa lebih baik.
        $pohonKinerja->load(['induk', 'anak', 'unitKerjas', 'realisasis.unitKerja']);

        return view('pohon_kinerja.show', compact('pohonKinerja'));
    }
}
