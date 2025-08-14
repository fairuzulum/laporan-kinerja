@extends('layouts.app')
@section('title', 'Download Laporan PDF')

@section('content')
<h1 class="text-2xl font-bold mb-4">Download Laporan Realisasi PDF</h1>
<p class="text-gray-600 mb-6">Pilih indikator kinerja dan tahun untuk mengunduh rekapitulasi laporan realisasi dalam format PDF.</p>

@if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Gagal!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('laporan.export_pdf') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_pk" class="block text-gray-700 font-bold mb-2">Pilih Indikator Kinerja:</label>
                {{-- KOREKSI: 'name' diubah menjadi 'id_pk' --}}
                <select name="id_pk" id="id_pk" class="shadow border rounded w-full py-2 px-3" required>
                    <option value="">-- Pilih Indikator --</option>
                    @foreach($pohonKinerjas as $pohon)
                        {{-- KOREKSI: 'value' diubah menjadi '$pohon->id_pk' dan 'old' disesuaikan --}}
                        <option value="{{ $pohon->id_pk }}" {{ old('id_pk') == $pohon->id_pk ? 'selected' : '' }}>
                            {{ $pohon->kode_kinerja }} - {{ $pohon->indikator }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tahun" class="block text-gray-700 font-bold mb-2">Tahun Laporan:</label>
                <input type="number" name="tahun" id="tahun" class="shadow border rounded w-full py-2 px-3" value="{{ old('tahun', date('Y')) }}" required>
            </div>
        </div>
        <div class="mt-6 text-right">
            <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-file-pdf mr-2"></i> Download Laporan (PDF)
            </button>
        </div>
    </form>
</div>
@endsection