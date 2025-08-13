<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unitKerjas = UnitKerja::latest()->get();
        return view('unit_kerja.index', compact('unitKerjas'));
    }

    public function create()
    {
        return view('unit_kerja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255|unique:unit_kerjas,nama_unit',
            'tipe_unit' => 'required|string|max:50',
        ]);

        UnitKerja::create($request->all());

        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    public function show(UnitKerja $unitKerja)
    {
        return redirect()->route('unit-kerja.index');
    }

    public function edit(UnitKerja $unitKerja)
    {
        return view('unit_kerja.edit', compact('unitKerja'));
    }

    public function update(Request $request, UnitKerja $unitKerja)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255|unique:unit_kerjas,nama_unit,' . $unitKerja->id_unit . ',id_unit',
            'tipe_unit' => 'required|string|max:50',
        ]);

        $unitKerja->update($request->all());

        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil diperbarui.');
    }

    public function destroy(UnitKerja $unitKerja)
    {
        // PENTING: Cek relasi sebelum menghapus
        if ($unitKerja->pohonKinerjas()->exists() || $unitKerja->users()->exists()) {
            return back()->with('error', 'Gagal! Unit Kerja ini masih terhubung dengan data Pohon Kinerja atau User.');
        }

        $unitKerja->delete();
        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil dihapus.');
    }
}