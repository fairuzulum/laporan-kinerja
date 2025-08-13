@extends('layouts.app')
@section('title', 'Manajemen User')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen User</h1>
        <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> Tambah User Baru
        </a>
    </div>

    @include('layouts.partials.alerts')

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Role</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Unit Kerja</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-100 border-b">
                        <td class="py-3 px-4">{{ $user->name }}</td>
                        <td class="py-3 px-4">{{ $user->email }}</td>
                        <td class="py-3 px-4"><span class="capitalize">{{ str_replace('_', ' ', $user->role) }}</span></td>
                        <td class="py-3 px-4">{{ $user->unitKerja->nama_unit ?? '-' }}</td>
                        <td class="py-3 px-4 flex items-center space-x-3">
                            <a href="{{ route('users.edit', $user) }}" class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                            @if(Auth::id() !== $user->id)
                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4">Tidak ada data user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection