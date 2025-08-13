@extends('layouts.app')
@section('title', 'Download Laporan')

@section('content')
<h1 class="text-2xl font-bold mb-4">Download Laporan Realisasi</h1>
<p class="text-gray-600 mb-6">Pilih instrumen dan tahun untuk mengunduh rekapitulasi laporan realisasi dalam format Excel.</p>

<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('laporan.export') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_instrumen" class="block text-gray-700 font-bold mb-2">Pilih Instrumen:</label>
                <select name="id_instrumen" id="id_instrumen" class="shadow border rounded w-full py-2 px-3" required>
                    <option value="">-- Pilih Instrumen --</option>
                    @foreach($instrumens as $instrumen)
                        <option value="{{ $instrumen->id_instrumen }}">{{ $instrumen->nama_instrumen }} ({{ $instrumen->tahun }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tahun" class="block text-gray-700 font-bold mb-2">Tahun Laporan:</label>
                <input type="number" name="tahun" id="tahun" class="shadow border rounded w-full py-2 px-3" value="{{ date('Y') }}" required>
            </div>
        </div>
        <div class="mt-6 text-right">
            <button type="submit" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-file-excel mr-2"></i> Download Laporan (Excel)
            </button>
        </div>
    </form>
</div>
@endsection