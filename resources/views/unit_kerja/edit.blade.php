@extends('layouts.app')
@section('title', 'Edit Unit Kerja')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Unit Kerja</h1>
<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('unit-kerja.update', $unitKerja) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="nama_unit" class="block text-gray-700 font-bold mb-2">Nama Unit:</label>
            <input type="text" name="nama_unit" id="nama_unit" class="shadow border rounded w-full py-2 px-3" value="{{ old('nama_unit', $unitKerja->nama_unit) }}" required>
        </div>
        <div class="mb-4">
            <label for="tipe_unit" class="block text-gray-700 font-bold mb-2">Tipe Unit:</label>
            <select name="tipe_unit" id="tipe_unit" class="shadow border rounded w-full py-2 px-3" required>
                <option value="">Pilih Tipe</option>
                @foreach (['Jurusan', 'Prodi', 'UPT', 'Pusat', 'Lainnya'] as $tipe)
                    <option value="{{ $tipe }}" {{ old('tipe_unit', $unitKerja->tipe_unit) == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center justify-end">
            <a href="{{ route('unit-kerja.index') }}" class="text-gray-600 mr-4">Batal</a>
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Update</button>
        </div>
    </form>
</div>
@endsection