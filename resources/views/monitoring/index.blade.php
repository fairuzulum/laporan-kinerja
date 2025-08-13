@extends('layouts.app')

@section('title', 'Monitoring Laporan Realisasi')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold">Monitoring Laporan Realisasi</h1>
    <p class="text-gray-600">Melihat status submit laporan dari setiap unit kerja penanggung jawab.</p>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full bg-white">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Kode IKU</th>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Indikator Kinerja</th>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Unit Penanggung Jawab</th>
                <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Status Laporan</th>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Laporan Terakhir</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @forelse ($pohonKinerjas as $item)
                {{-- Kita lakukan nested loop: loop IKU, lalu loop setiap unit yg ditugaskan ke IKU tsb --}}
                @foreach ($item->unitKerjas as $unit)
                    <tr class="hover:bg-gray-100 border-b">
                        <td class="py-3 px-4">{{ $item->kode_kinerja }}</td>
                        <td class="py-3 px-4">{{ $item->indikator }}</td>
                        <td class="py-3 px-4 font-semibold">{{ $unit->nama_unit }}</td>
                        
                        @php
                            // Cek apakah ada laporan realisasi dari unit ini untuk IKU ini
                            $laporan = $item->realisasis
                                        ->where('id_unit_fk', $unit->id_unit)
                                        ->sortByDesc('created_at')
                                        ->first();
                        @endphp

                        <td class="text-center py-3 px-4">
                            @if ($laporan)
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">
                                    Sudah Submit
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">
                                    Belum Submit
                                </span>
                            @endif
                        </td>
                        <td class="text-left py-3 px-4 text-sm text-gray-500">
                            {{ $laporan ? $laporan->created_at->format('d M Y, H:i') : '-' }}
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Tidak ada data penugasan untuk dimonitor.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection