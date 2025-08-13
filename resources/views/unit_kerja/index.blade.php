@extends('layouts.app')
@section('title', 'Manajemen Unit Kerja')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen Unit Kerja</h1>
        <a href="{{ route('unit-kerja.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> Tambah Unit Baru
        </a>
    </div>

    @include('layouts.partials.alerts')

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama Unit</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tipe Unit</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($unitKerjas as $unit)
                    <tr class="hover:bg-gray-100 border-b">
                        <td class="py-3 px-4">{{ $unit->nama_unit }}</td>
                        <td class="py-3 px-4">{{ $unit->tipe_unit }}</td>
                        <td class="py-3 px-4 flex items-center space-x-3">
                            <a href="{{ route('unit-kerja.edit', $unit) }}" class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('unit-kerja.destroy', $unit) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus unit ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-4">Tidak ada data unit kerja.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection