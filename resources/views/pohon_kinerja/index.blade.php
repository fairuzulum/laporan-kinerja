@extends('layouts.app')

{{-- Set Judul Halaman --}}
@section('title', 'Kelola Pohon Kinerja')

{{-- Set Konten Halaman --}}
@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="mb-4">
        <h1 class="text-2xl font-bold">Pohon Kinerja Utama</h1>
        <p class="text-gray-600">Daftar sasaran strategis tingkat institusi.</p>
    </div>

    {{-- Tombol Aksi (untuk nanti) --}}
    <div class="mb-4 flex space-x-2">
        <a href="{{ route('pohon-kinerja.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> Tambah Sasaran Baru
        </a>
        {{-- TOMBOL BARU --}}
        <a href="{{ route('instrumen.index') }}"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-cogs mr-2"></i> Kelola Instrumen
        </a>
    </div>

    {{-- Tabel Data --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">Kode</th>
                    <th class="w-4/12 text-left py-3 px-4 uppercase font-semibold text-sm">Deskripsi Sasaran</th>
                    <th class="w-4/12 text-left py-3 px-4 uppercase font-semibold text-sm">Indikator</th>
                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">Target</th>
                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">Satuan</th>
                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
            <tbody class="text-gray-700">
                @forelse ($pohonKinerjas as $item)
                    {{-- Panggil komponen untuk setiap item level atas --}}
                    <x-pohon-kinerja-item :item="$item" :level="0" />
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Tidak ada data untuk ditampilkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
