@extends('layouts.app')

@section('title', 'Penugasan Unit Kerja')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold">Penugasan Unit Kerja</h1>
    <p class="text-gray-600">Pilih unit kerja yang bertanggung jawab untuk:</p>
    <div class="mt-2 p-4 bg-blue-50 border border-blue-200 rounded">
        <p class="font-bold text-blue-800">{{ $pohonKinerja->kode_kinerja }} - {{ $pohonKinerja->deskripsi_sasaran }}</p>
        <p class="text-sm text-gray-700 mt-1"><strong>Indikator:</strong> {{ $pohonKinerja->indikator }}</p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('pohon-kinerja.assign.sync', $pohonKinerja) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Daftar Unit Kerja:</label>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($allUnits as $unit)
                    <div class="flex items-center p-3 border rounded-lg">
                        <input type="checkbox" name="unit_ids[]" id="unit_{{ $unit->id_unit }}" value="{{ $unit->id_unit }}"
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                               {{-- Cek apakah unit ini sudah di-assign sebelumnya --}}
                               {{ in_array($unit->id_unit, $assignedUnitIds) ? 'checked' : '' }}>
                        <label for="unit_{{ $unit->id_unit }}" class="ml-3 text-sm font-medium text-gray-900">{{ $unit->nama_unit }}</label>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada data unit kerja. Silakan tambah data unit kerja terlebih dahulu.</p>
                @endforelse
            </div>
        </div>

        <div class="flex items-center justify-end mt-6">
            <a href="{{ route('pohon-kinerja.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Kembali</a>
            <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Penugasan
            </button>
        </div>
    </form>
</div>
@endsection