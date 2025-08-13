
@extends('layouts.app')
@section('title', 'Daftar Tugas Kinerja')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold">Tugas Kinerja Unit Anda</h1>
    <p class="text-gray-600">Berikut adalah daftar Indikator Kinerja yang menjadi tanggung jawab unit Anda.</p>
</div>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full bg-white">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm w-5/12">Indikator Kinerja</th>
                <th class="text-center py-3 px-4 uppercase font-semibold text-sm w-1/12">Target</th>
                <th class="text-center py-3 px-4 uppercase font-semibold text-sm w-2/12">Aksi Tahun Ini ({{ date('Y') }})</th>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm w-2/12">Riwayat Laporan</th>
                <th class="text-center py-3 px-4 uppercase font-semibold text-sm w-2/12">Feedback</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @forelse ($assignedPohonKinerjas as $item)
                @php
                    $currentYear = date('Y');
                    $userUnitId = Auth::user()->id_unit_fk;

                    // Cari laporan khusus untuk TAHUN INI untuk tombol Aksi
                    $realisasiTahunIni = $item->realisasis
                        ->where('id_unit_fk', $userUnitId)
                        ->where('tahun_laporan', $currentYear)
                        ->first();

                    // Cari laporan dari TAHUN-TAHUN SEBELUMNYA untuk Riwayat
                    $realisasiLalu = $item->realisasis
                        ->where('id_unit_fk', $userUnitId)
                        ->where('tahun_laporan', '!=', $currentYear)
                        ->sortByDesc('tahun_laporan');
                    
                    // Cari laporan PALING BARU SECARA KESELURUHAN untuk tombol Feedback
                    $latestRealisasi = $item->realisasis
                        ->where('id_unit_fk', $userUnitId)
                        ->sortByDesc('created_at')
                        ->first();
                @endphp
                <tr class="hover:bg-gray-100 border-b">
                    <td class="py-3 px-4 align-top">
                        <span class="font-bold">{{ $item->kode_kinerja }}</span> - {{ $item->indikator }}
                    </td>
                    <td class="text-center py-3 px-4 align-top">{{ $item->target }} {{ $item->satuan }}</td>

                    {{-- KOLOM AKSI UTAMA UNTUK TAHUN INI --}}
                    <td class="text-center py-3 px-4 align-top">
                        @if ($realisasiTahunIni)
                            <a href="{{ route('realisasi.edit', $realisasiTahunIni) }}"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-xs">
                                Edit Laporan {{ $currentYear }}
                            </a>
                        @else
                            <a href="{{ route('realisasi.create', ['pohonKinerja' => $item, 'tahun' => $currentYear]) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs">
                                Lapor untuk {{ $currentYear }}
                            </a>
                        @endif
                    </td>

                    {{-- KOLOM RIWAYAT LAPORAN TAHUN SEBELUMNYA --}}
                    <td class="py-3 px-4 align-top">
                        @if ($realisasiLalu->isNotEmpty())
                            <ul class="text-xs space-y-1">
                                @foreach ($realisasiLalu as $laporanLalu)
                                    <li class="flex justify-between items-center">
                                        <span>
                                            <strong>{{ $laporanLalu->tahun_laporan }}:</strong>
                                            {{ $laporanLalu->capaian_realisasi }} {{ $item->satuan }}
                                        </span>
                                        <a href="{{ route('realisasi.edit', $laporanLalu) }}"
                                            class="text-blue-500 hover:text-blue-700 ml-2">Edit</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-xs text-gray-500">- Tidak ada riwayat -</span>
                        @endif
                    </td>

                    {{-- KOLOM FEEDBACK --}}
                    <td class="text-center py-3 px-4 align-top">
                        @if ($latestRealisasi)
                            <a href="{{ route('realisasi.show', $latestRealisasi) }}"
                                class="relative bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">
                                Lihat Feedback
                                @if ($latestRealisasi->evaluasiLaporans->count() > 0)
                                    <span class="absolute -top-2 -right-2 flex h-4 w-4">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-white text-xs justify-center items-center">
                                            {{ $latestRealisasi->evaluasiLaporans->count() }}
                                        </span>
                                    </span>
                                @endif
                            </a>
                        @else
                            <span class="text-xs text-gray-400">- Belum ada laporan -</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Tidak ada tugas yang ditugaskan untuk unit Anda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
