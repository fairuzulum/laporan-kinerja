@extends('layouts.app')
@section('title', 'Tambah User Baru')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah User Baru</h1>
<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama:</label>
            <input type="text" name="name" id="name" class="shadow border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
            <input type="email" name="email" id="email" class="shadow border rounded w-full py-2 px-3" required>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
                <input type="password" name="password" id="password" class="shadow border rounded w-full py-2 px-3" required>
            </div>
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Konfirmasi Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="shadow border rounded w-full py-2 px-3" required>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="role" class="block text-gray-700 font-bold mb-2">Role:</label>
                <select name="role" id="role" class="shadow border rounded w-full py-2 px-3" required>
                    <option value="unit_kerja">Unit Kerja</option>
                    <option value="tim_sakip">Tim SAKIP</option>
                    <option value="evaluator">Evaluator</option>
                </select>
            </div>
            <div>
                <label for="id_unit_fk" class="block text-gray-700 font-bold mb-2">Unit Kerja (Jika role Unit Kerja):</label>
                <select name="id_unit_fk" id="id_unit_fk" class="shadow border rounded w-full py-2 px-3">
                    <option value="">Tidak ada</option>
                    @foreach($unitKerjas as $unit)
                    <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex items-center justify-end">
            <a href="{{ route('users.index') }}" class="text-gray-600 mr-4">Batal</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection