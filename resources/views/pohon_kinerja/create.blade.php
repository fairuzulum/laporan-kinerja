@extends('layouts.app')

@section('title', 'Tambah Data Pohon Kinerja')

@section('content')
<h1 class="text-2xl font-bold mb-4">
    {{-- Judul dinamis tergantung ada induk atau tidak --}}
    @if(isset($induk))
        Menambah Sub-Item untuk: <span class="font-normal text-blue-600">{{ $induk->kode_kinerja }} - {{ $induk->deskripsi_sasaran }}</span>
    @else
        Menambah Sasaran Strategis Baru
    @endif
</h1>

<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('pohon-kinerja.store') }}" method="POST">
        @csrf

        {{-- Input tersembunyi untuk menyimpan ID Induk --}}
        <input type="hidden" name="id_pk_induk" value="{{ $induk->id_pk ?? '' }}">

        <div class="mb-4">
            <label for="id_instrumen_fk" class="block text-gray-700 font-bold mb-2">Instrumen Acuan:</label>
            <select name="id_instrumen_fk" id="id_instrumen_fk" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Pilih Instrumen</option>
                @foreach ($instrumens as $instrumen)
                    {{-- Jika ada induk, otomatis pilih instrumen yang sama --}}
                    <option value="{{ $instrumen->id_instrumen }}" {{ (isset($induk) && $induk->id_instrumen_fk == $instrumen->id_instrumen) ? 'selected' : '' }}>
                        {{ $instrumen->nama_instrumen }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="deskripsi_sasaran" class="block text-gray-700 font-bold mb-2">Deskripsi Sasaran/Program/Kegiatan:</label>
            <textarea name="deskripsi_sasaran" id="deskripsi_sasaran" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required></textarea>
        </div>

        <div class="mb-4">
            <label for="indikator" class="block text-gray-700 font-bold mb-2">Indikator Kinerja:</label>
            <textarea name="indikator" id="indikator" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="target" class="block text-gray-700 font-bold mb-2">Target:</label>
                <input type="number" step="0.01" name="target" id="target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
            <div>
                <label for="satuan" class="block text-gray-700 font-bold mb-2">Satuan:</label>
                <input type="text" name="satuan" id="satuan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
        </div>

        <div class="flex items-center justify-end">
            <a href="{{ route('pohon-kinerja.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection