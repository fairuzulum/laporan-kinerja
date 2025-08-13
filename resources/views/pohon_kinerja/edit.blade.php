{{-- Ganti semua isi file dengan ini --}}
@extends('layouts.app')

@section('title', 'Edit Data Pohon Kinerja')

@section('content')
<h1 class="text-2xl font-bold mb-4">
    Edit Data: <span class="font-normal text-blue-600">{{ $pohonKinerja->kode_kinerja }} - {{ $pohonKinerja->deskripsi_sasaran }}</span>
</h1>

<div class="bg-white p-6 rounded-lg shadow-md">
    {{-- Ubah action ke route 'update' dan method ke 'PUT' --}}
    <form action="{{ route('pohon-kinerja.update', $pohonKinerja->id_pk) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Kita tidak mengizinkan perubahan induk atau instrumen untuk menjaga integritas kode --}}
        <div class="mb-4">
            <label for="instrumen" class="block text-gray-700 font-bold mb-2">Instrumen Acuan:</label>
            <input type="text" value="{{ $pohonKinerja->instrumen->nama_instrumen }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 bg-gray-200" disabled>
        </div>
        
        @if($pohonKinerja->induk)
        <div class="mb-4">
            <label for="induk" class="block text-gray-700 font-bold mb-2">Item Induk:</label>
            <input type="text" value="{{ $pohonKinerja->induk->kode_kinerja }} - {{ $pohonKinerja->induk->deskripsi_sasaran }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 bg-gray-200" disabled>
        </div>
        @endif

        <div class="mb-4">
            <label for="deskripsi_sasaran" class="block text-gray-700 font-bold mb-2">Deskripsi Sasaran/Program/Kegiatan:</label>
            {{-- old() digunakan untuk menjaga input jika validasi gagal --}}
            <textarea name="deskripsi_sasaran" id="deskripsi_sasaran" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>{{ old('deskripsi_sasaran', $pohonKinerja->deskripsi_sasaran) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="indikator" class="block text-gray-700 font-bold mb-2">Indikator Kinerja:</label>
            <textarea name="indikator" id="indikator" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>{{ old('indikator', $pohonKinerja->indikator) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="target" class="block text-gray-700 font-bold mb-2">Target:</label>
                <input type="number" step="0.01" name="target" id="target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" value="{{ old('target', $pohonKinerja->target) }}" required>
            </div>
            <div>
                <label for="satuan" class="block text-gray-700 font-bold mb-2">Satuan:</label>
                <input type="text" name="satuan" id="satuan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" value="{{ old('satuan', $pohonKinerja->satuan) }}" required>
            </div>
        </div>

        <div class="flex items-center justify-end">
            <a href="{{ route('pohon-kinerja.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Data
            </button>
        </div>
    </form>
</div>
@endsection