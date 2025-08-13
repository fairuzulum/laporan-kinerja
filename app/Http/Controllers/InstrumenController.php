<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use Illuminate\Http\Request;

class InstrumenController extends Controller
{
    public function index()
    {
        $instrumens = Instrumen::latest()->get();
        return view('instrumen.index', compact('instrumens'));
    }

    public function create()
    {
        return view('instrumen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instrumen' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+5),
        ]);

        Instrumen::create($request->all());

        return redirect()->route('instrumen.index')->with('success', 'Instrumen berhasil ditambahkan.');
    }

    public function show(Instrumen $instrumen)
    {
        // Tidak digunakan untuk saat ini
        return redirect()->route('instrumen.index');
    }

    public function edit(Instrumen $instrumen)
    {
        return view('instrumen.edit', compact('instrumen'));
    }

    public function update(Request $request, Instrumen $instrumen)
    {
        $request->validate([
            'nama_instrumen' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+5),
        ]);

        $instrumen->update($request->all());

        return redirect()->route('instrumen.index')->with('success', 'Instrumen berhasil diperbarui.');
    }

    public function destroy(Instrumen $instrumen)
    {
        // PENTING: Cek apakah instrumen ini sedang digunakan
        if ($instrumen->pohonKinerjas()->exists()) {
            return redirect()->route('instrumen.index')->with('error', 'Gagal! Instrumen ini masih digunakan oleh Pohon Kinerja.');
        }

        $instrumen->delete();
        return redirect()->route('instrumen.index')->with('success', 'Instrumen berhasil dihapus.');
    }
}