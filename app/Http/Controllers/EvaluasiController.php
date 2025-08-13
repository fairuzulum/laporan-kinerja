<?php

namespace App\Http\Controllers;

use App\Models\EvaluasiLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluasiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_realisasi_fk' => 'required|exists:realisasis,id_realisasi',
            'catatan' => 'required|string',
        ]);

        // Pastikan hanya tim_sakip atau evaluator yang bisa memberi catatan
        $user = Auth::user();
        if ($user->role !== 'tim_sakip' && $user->role !== 'evaluator') {
            abort(403, 'Anda tidak memiliki hak akses untuk memberikan evaluasi.');
        }

        EvaluasiLaporan::create([
            'id_realisasi_fk' => $validated['id_realisasi_fk'],
            'catatan' => $validated['catatan'],
            'id_user_fk' => $user->id,
        ]);

        return back()->with('success', 'Catatan evaluasi berhasil ditambahkan.');
    }

    public function update(Request $request, EvaluasiLaporan $evaluasiLaporan)
    {
        // Authorization: Make sure the user owns this evaluation
        if ($evaluasiLaporan->id_user_fk !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah catatan ini.');
        }

        $validated = $request->validate([
            'catatan' => 'required|string',
        ]);

        $evaluasiLaporan->update($validated);

        return back()->with('success', 'Catatan evaluasi berhasil diperbarui.');
    }

    /**
     * Remove the specified evaluation from storage.
     */
    public function destroy(EvaluasiLaporan $evaluasiLaporan)
    {
        // Authorization: Make sure the user owns this evaluation
        if ($evaluasiLaporan->id_user_fk !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus catatan ini.');
        }

        $evaluasiLaporan->delete();

        return back()->with('success', 'Catatan evaluasi berhasil dihapus.');
    }
}
