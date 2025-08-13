@extends('layouts.app')
@section('title', 'Detail Laporan Realisasi')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Detail Laporan Realisasi</h1>
    <a href="{{ route('realisasi.index') }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Tugas
    </a>
</div>

{{-- BAGIAN 1: INFORMASI INDIKATOR --}}
<div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded">
    <p class="font-bold text-blue-800">{{ $realisasi->pohonKinerja->kode_kinerja }} - {{ $realisasi->pohonKinerja->deskripsi_sasaran }}</p>
    <p class="text-sm text-gray-700 mt-1"><strong>Indikator:</strong> {{ $realisasi->pohonKinerja->indikator }}</p>
    <p class="text-sm text-gray-700 mt-1"><strong>Target:</strong> {{ $realisasi->pohonKinerja->target }} {{ $realisasi->pohonKinerja->satuan }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- BAGIAN 2: LAPORAN YANG ANDA SUBMIT --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Laporan Anda</h2>
            <a href="{{ route('realisasi.edit', $realisasi) }}" class="text-yellow-500 hover:text-yellow-700 text-sm font-semibold">
                <i class="fas fa-edit mr-1"></i> Edit Laporan Ini
            </a>
        </div>
        <div class="space-y-4 text-sm">
            <p><strong>Tahun Laporan:</strong> {{ $realisasi->tahun_laporan }}</p>
            <p><strong>Capaian Realisasi:</strong> <span class="font-bold text-lg">{{ $realisasi->capaian_realisasi }}</span> {{ $realisasi->pohonKinerja->satuan }}</p>
            <p><strong>Anggaran Digunakan:</strong> Rp {{ number_format($realisasi->anggaran_realisasi, 0, ',', '.') }}</p>
            <p><strong>Analisis Progres:</strong><br>{{ $realisasi->analisis_progres ?? '-' }}</p>
            <p><strong>Analisis Kendala:</strong><br>{{ $realisasi->analisis_kendala ?? '-' }}</p>
            <p><strong>Strategi Tindak Lanjut:</strong><br>{{ $realisasi->analisis_strategi ?? '-' }}</p>
            <p><strong>Link Bukti:</strong><br><a href="{{ $realisasi->link_bukti }}" target="_blank" class="text-blue-600 hover:underline">{{ $realisasi->link_bukti ?? '-' }}</a></p>
            <p class="text-xs text-gray-500 mt-2">Laporan disubmit pada: {{ $realisasi->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    {{-- BAGIAN 3: CATATAN EVALUASI --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Catatan Evaluasi</h2>
        <div class="space-y-4">
            @forelse ($realisasi->evaluasiLaporans as $evaluasi)
                <div class="text-sm border-l-4 p-3 rounded-r-lg {{ $evaluasi->user->role === 'evaluator' ? 'border-purple-500 bg-purple-50' : 'border-blue-500 bg-blue-50' }}">
                    <p class="text-gray-800">{{ $evaluasi->catatan }}</p>
                    <p class="text-xs font-semibold text-gray-500 mt-2 text-right">
                        -- {{ $evaluasi->user->name }} ({{ str_replace('_',' ',$evaluasi->user->role) }})
                        <br>
                        {{ $evaluasi->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada catatan evaluasi untuk laporan ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection