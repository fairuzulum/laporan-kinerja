@extends('layouts.app')

@section('title', 'Kelola Instrumen')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Kelola Instrumen</h1>
        <a href="{{ route('pohon-kinerja.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>


    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('instrumen.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> Tambah Instrumen Baru
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama Instrumen</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tahun</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($instrumens as $instrumen)
                    <tr class="hover:bg-gray-100">
                        <td class="text-left py-3 px-4">{{ $instrumen->nama_instrumen }}</td>
                        <td class="text-left py-3 px-4">{{ $instrumen->tahun }}</td>
                        <td class="text-left py-3 px-4 flex items-center space-x-2">
                            <a href="{{ route('instrumen.edit', $instrumen) }}"
                                class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('instrumen.destroy', $instrumen) }}" method="POST"
                                onsubmit="return confirm('Anda yakin ingin menghapus instrumen ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">Tidak ada data instrumen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
