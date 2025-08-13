@extends('layouts.app')
@section('title', 'Dashboard Evaluator')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold">Dashboard Evaluasi</h1>
    <p class="text-gray-600">Daftar semua laporan kinerja yang telah disubmit oleh Unit Kerja.</p>
</div>

@include('layouts.partials.alerts')

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full bg-white">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Indikator Kinerja</th>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Unit Pelapor</th>
                <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Tahun</th>
                <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Capaian</th>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tanggal Submit</th>
                <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @forelse ($semuaLaporan as $laporan)
                <tr class="hover:bg-gray-100 border-b">
                    <td class="py-3 px-4">
                        <span class="font-bold">{{ $laporan->pohonKinerja->kode_kinerja }}</span> - {{ $laporan->pohonKinerja->indikator }}
                    </td>
                    <td class="py-3 px-4">{{ $laporan->unitKerja->nama_unit }}</td>
                    <td class="text-center py-3 px-4">{{ $laporan->tahun_laporan }}</td>
                    <td class="text-center py-3 px-4 font-semibold">{{ $laporan->capaian_realisasi }}</td>
                    <td class="text-left py-3 px-4">{{ $laporan->created_at->format('d M Y, H:i') }}</td>
                    <td class="text-center py-3 px-4">
                        <a href="{{ route('pohon-kinerja.show', $laporan->pohonKinerja) }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-1 px-3 rounded text-xs">
                            Lihat & Evaluasi
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-4">Belum ada laporan yang disubmit oleh Unit Kerja manapun.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection