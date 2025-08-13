<?php

namespace App\Http\Controllers;

use App\Models\PohonKinerja;
use App\Models\Realisasi;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'tim_sakip') {
            return redirect()->route('dashboard.tim_sakip');
        } elseif ($user->role === 'unit_kerja') {
            return redirect()->route('dashboard.unit_kerja');
        } elseif ($user->role === 'evaluator') {
            return redirect()->route('dashboard.evaluator');
        }
        return view('dashboard.index');
    }

    public function evaluator()
    {
        // Ambil data untuk ringkasan di bagian atas dashboard
        $totalIndikator = PohonKinerja::count();
        $totalUnitKerja = UnitKerja::count();

        // Ambil semua laporan realisasi, urutkan dari yang terbaru
        $semuaLaporan = Realisasi::with(['pohonKinerja', 'unitKerja'])
                                ->latest()
                                ->get();

        return view('dashboard.evaluator', compact(
            'totalIndikator',
            'totalUnitKerja',
            'semuaLaporan'
        ));
    }

    public function timSakip()
    {
        // Ambil data untuk ringkasan di bagian atas dashboard
        $totalIndikator = PohonKinerja::count();
        $totalUnitKerja = UnitKerja::count();

        // Ambil hanya item Pohon Kinerja level teratas (Sasaran Strategis)
        // Kita gunakan with() untuk Eager Loading, ini membuat query lebih efisien
        $sasaranStrategis = PohonKinerja::whereNull('id_pk_induk')
            ->with('realisasis') // Muat semua realisasi terkait
            ->orderBy('kode_kinerja')
            ->get();

        return view('dashboard.tim_sakip', compact(
            'totalIndikator',
            'totalUnitKerja',
            'sasaranStrategis'
        ));
    }

    public function unitKerja()
    {
        // Ambil data untuk ringkasan di bagian atas dashboard
        $totalIndikator = PohonKinerja::count();
        $totalUnitKerja = UnitKerja::count();

        // Ambil hanya item Pohon Kinerja level teratas (Sasaran Strategis)
        // Kita gunakan with() untuk Eager Loading, ini membuat query lebih efisien
        $sasaranStrategis = PohonKinerja::whereNull('id_pk_induk')
            ->with('realisasis') // Muat semua realisasi terkait
            ->orderBy('kode_kinerja')
            ->get();

        return view('dashboard.unit_kerja', compact(
            'totalIndikator',
            'totalUnitKerja',
            'sasaranStrategis'
        ));
    }

    public function editProfile()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }
            // Simpan foto baru
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profile updated!');
    }
}
