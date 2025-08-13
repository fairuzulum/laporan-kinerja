@extends('layouts.app')
@section('title', 'Lapor Realisasi Kinerja')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Form Laporan Realisasi</h1>
    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded">
        <p class="font-bold text-blue-800">{{ $pohonKinerja->kode_kinerja }} - {{ $pohonKinerja->deskripsi_sasaran }}</p>
        <p class="text-sm text-gray-700 mt-1"><strong>Indikator:</strong> {{ $pohonKinerja->indikator }}</p>
        <p class="text-sm text-gray-700 mt-1"><strong>Target:</strong> {{ $pohonKinerja->target }}
            {{ $pohonKinerja->satuan }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('realisasi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_pk_fk" value="{{ $pohonKinerja->id_pk }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tahun_laporan" class="block text-gray-700 font-bold mb-2">Tahun Laporan:</label>
                   <input type="number" name="tahun_laporan" id="tahun_laporan" class="shadow appearance-none border bg-gray-200 rounded w-full py-2 px-3" value="{{ $tahun }}" readonly>
                </div>
                <div>
                    <label for="capaian_realisasi" class="block text-gray-700 font-bold mb-2">Capaian Realisasi
                        (Angka):</label>
                    <input type="number" step="0.01" name="capaian_realisasi" id="capaian_realisasi"
                        class="shadow appearance-none border rounded w-full py-2 px-3" required>
                </div>
            </div>
            <div class="mb-4">
                <label for="analisis_progres" class="block text-gray-700 font-bold mb-2">Analisis Progres:</label>
                <textarea name="analisis_progres" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3"></textarea>
            </div>
            <div class="mb-4">
                <label for="analisis_kendala" class="block text-gray-700 font-bold mb-2">Analisis Kendala:</label>
                <textarea name="analisis_kendala" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3"></textarea>
            </div>
            <div class="mb-4">
                <label for="analisis_strategi" class="block text-gray-700 font-bold mb-2">Strategi Tindak Lanjut:</label>
                <textarea name="analisis_strategi" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3"></textarea>
            </div>
            <div class="mb-4">
                <label for="link_bukti" class="block text-gray-700 font-bold mb-2">Link Bukti (Google Drive, dll):</label>
                <input type="url" name="link_bukti" class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>

            <div class="mb-4">
                <label for="anggaran_realisasi" class="block text-gray-700 font-bold mb-2">Anggaran yang Digunakan
                    (Rp):</label>
                <input type="number" name="anggaran_realisasi" id="anggaran_realisasi"
                    class="shadow appearance-none border rounded w-full py-2 px-3" placeholder="Contoh: 5000000">
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('realisasi.index') }}" class="text-gray-600 mr-4">Batal</a>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Submit
                    Laporan</button>
            </div>
        </form>
    </div>
@endsection
