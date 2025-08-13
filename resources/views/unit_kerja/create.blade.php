@extends('layouts.app')
@section('title', 'Tambah Unit Kerja Baru')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Unit Kerja Baru</h1>
<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('unit-kerja.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama_unit" class="block text-gray-700 font-bold mb-2">Nama Unit:</label>
            <input type="text" name="nama_unit" id="nama_unit" class="shadow border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label for="tipe_unit" class="block text-gray-700 font-bold mb-2">Tipe Unit:</label>
            <select name="tipe_unit" id="tipe_unit" class="shadow border rounded w-full py-2 px-3" required>
                <option value="">Pilih Tipe</option>
                <option value="Jurusan">Jurusan</option>
                <option value="Prodi">Prodi</option>
                <option value="UPT">UPT</option>
                <option value="Pusat">Pusat</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
        <div class="flex items-center justify-end">
            <a href="{{ route('unit-kerja.index') }}" class="text-gray-600 mr-4">Batal</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection