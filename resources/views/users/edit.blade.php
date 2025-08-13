@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit User: {{ $user->name }}</h1>
<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        {{-- ... (Isi form sama seperti create.blade.php, tapi dengan value yang sudah terisi) ... --}}
        {{-- Contoh untuk input nama: --}}
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama:</label>
            <input type="text" name="name" id="name" class="shadow border rounded w-full py-2 px-3" value="{{ old('name', $user->name) }}" required>
        </div>
        {{-- ... Lakukan hal yang sama untuk email, role, dan id_unit_fk ... --}}
        {{-- ... Untuk password, biarkan kosong jika tidak ingin diubah ... --}}
        <p class="text-sm text-gray-600 mb-4">Kosongkan password jika tidak ingin mengubahnya.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="password" class="block text-gray-700 font-bold mb-2">Password Baru:</label>
                <input type="password" name="password" id="password" class="shadow border rounded w-full py-2 px-3">
            </div>
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Konfirmasi Password Baru:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="shadow border rounded w-full py-2 px-3">
            </div>
        </div>
        {{-- ... --}}
        <div class="flex items-center justify-end">
            <a href="{{ route('users.index') }}" class="text-gray-600 mr-4">Batal</a>
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Update</button>
        </div>
    </form>
</div>
@endsection