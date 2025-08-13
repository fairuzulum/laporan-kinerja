@extends('layouts.app')

@section('title', 'Dashboard Tim SAKIP')

@section('content')
<h1 class="text-2xl font-bold mb-4">Dashboard Unit Kerja</h1>

{{-- Bagian Ringkasan Atas --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-blue-100 p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-blue-800">Total Indikator Kinerja</h2>
        <p class="text-3xl font-bold text-blue-900 mt-2">{{ $totalIndikator }}</p>
    </div>
    <div class="bg-green-100 p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-green-800">Total Unit Kerja</h2>
        <p class="text-3xl font-bold text-green-900 mt-2">{{ $totalUnitKerja }}</p>
    </div>
    <div class="bg-yellow-100 p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-yellow-800">Tahun Kinerja</h2>
        <p class="text-3xl font-bold text-yellow-900 mt-2">{{ date('Y') }}</p>
    </div>
</div>


@endsection