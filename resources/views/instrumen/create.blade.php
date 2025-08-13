@extends('layouts.app')

@section('title', 'Tambah Instrumen Baru')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Instrumen Baru</h1>

<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('instrumen.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama_instrumen" class="block text-gray-700 font-bold mb-2">Nama Instrumen:</label>
            <input type="text" name="nama_instrumen" id="nama_instrumen" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        <div class="mb-4">
            <label for="tahun" class="block text-gray-700 font-bold mb-2">Tahun:</label>
            <input type="number" name="tahun" id="tahun" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: 2025" required>
        </div>
        <div class="flex items-center justify-end">
            <a href="{{ route('instrumen.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection