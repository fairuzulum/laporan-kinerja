@extends('layouts.app')

@section('title', 'Detail Pohon Kinerja')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Detail Pohon Kinerja</h1>
        {{-- tombol back berbeda jika rolenya tim_sakip dan evaluator --}}
        {{-- <a href="{{ route('pohon-kinerja.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a> --}}
        @if (Auth::user()->role === 'tim_sakip') 
            <a href="{{ route('pohon-kinerja.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
        @elseif (Auth::user()->role === 'evaluator') 
            <a href="{{ route('evaluator.dashboard') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard Evaluator
            </a>
        @endif
    </div>

    {{-- KARTU INFO UTAMA --}}
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Utama</h2>
        <div class="grid grid-cols-2 gap-4">
            <div><strong class="text-gray-600">Kode:</strong> {{ $pohonKinerja->kode_kinerja }}</div>
            <div><strong class="text-gray-600">Target:</strong> {{ $pohonKinerja->target }} {{ $pohonKinerja->satuan }}</div>
        </div>
        <div class="mt-4">
            <p><strong class="text-gray-600">Deskripsi Sasaran:</strong></p>
            <p>{{ $pohonKinerja->deskripsi_sasaran }}</p>
        </div>
        <div class="mt-4">
            <p><strong class="text-gray-600">Indikator:</strong></p>
            <p>{{ $pohonKinerja->indikator }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- KARTU RELASI (INDUK & ANAK) --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Relasi Hierarki</h2>
            @if ($pohonKinerja->induk)
                <p class="mb-2"><strong class="text-gray-600">Induk:</strong> <a
                        href="{{ route('pohon-kinerja.show', $pohonKinerja->induk) }}"
                        class="text-blue-600 hover:underline">{{ $pohonKinerja->induk->kode_kinerja }} -
                        {{ $pohonKinerja->induk->deskripsi_sasaran }}</a></p>
            @endif
            <div>
                <p><strong class="text-gray-600">Sub-Item (Anak):</strong></p>
                <ul class="list-disc list-inside mt-2">
                    @forelse($pohonKinerja->anak as $anak)
                        <li><a href="{{ route('pohon-kinerja.show', $anak) }}"
                                class="text-blue-600 hover:underline">{{ $anak->kode_kinerja }} -
                                {{ $anak->deskripsi_sasaran }}</a></li>
                    @empty
                        <li>Tidak ada sub-item.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- KARTU UNIT PENANGGUNG JAWAB --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Unit Penanggung Jawab</h2>
            <ul class="list-disc list-inside">
                @forelse($pohonKinerja->unitKerjas as $unit)
                    <li>{{ $unit->nama_unit }}</li>
                @empty
                    <li>Belum ada unit yang ditugaskan.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- TABEL HISTORI LAPORAN REALISASI --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Histori Laporan Realisasi</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-2 px-3">Unit Pelapor</th>
                        <th class="text-center py-2 px-3">Tahun</th>
                        <th class="text-center py-2 px-3">Capaian</th>
                        <th class="text-left py-2 px-3">Tanggal Lapor</th>
                    </tr>
                </thead>

                {{-- In resources/views/pohon_kinerja/show.blade.php --}}
                <tbody>
                    @forelse ($pohonKinerja->realisasis->sortByDesc('created_at') as $realisasi)
                        <tr class="border-t">
                            <td class="p-3 align-top">{{ $realisasi->unitKerja->nama_unit }}</td>
                            <td class="p-3 align-top text-center">{{ $realisasi->tahun_laporan }}</td>
                            <td class="p-3 align-top text-center font-bold">{{ $realisasi->capaian_realisasi }}</td>
                            <td class="p-3 align-top text-sm text-gray-600">
                                {{ $realisasi->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td colspan="4" class="p-4">
                                <div class="space-y-3">
                                    <p class="font-semibold text-sm text-gray-700">Catatan Evaluasi:</p>
                                    @forelse($realisasi->evaluasiLaporans as $evaluasi)
                                        <div id="evaluasi-{{ $evaluasi->id_evaluasi }}"
                                            class="text-xs border-l-2 pl-3 {{ $evaluasi->user->role === 'evaluator' ? 'border-purple-500' : 'border-blue-500' }}">
                                            {{-- View Mode --}}
                                            <div class="view-mode">
                                                <p>{{ $evaluasi->catatan }}</p>
                                                <div class="flex items-center justify-between mt-1">
                                                    <p class="font-semibold text-gray-500">-- {{ $evaluasi->user->name }}
                                                        ({{ str_replace('_', ' ', $evaluasi->user->role) }})
                                                    </p>
                                                    {{-- Show Edit/Delete only if the logged in user is the owner --}}
                                                    @if (Auth::id() == $evaluasi->id_user_fk)
                                                        <div class="flex items-center space-x-2">
                                                            <button onclick="toggleEdit({{ $evaluasi->id_evaluasi }})"
                                                                class="text-yellow-600 hover:text-yellow-800">Edit</button>
                                                            <form action="{{ route('evaluasi.destroy', $evaluasi) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Hapus catatan ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-red-600 hover:text-red-800">Hapus</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- Edit Mode (Hidden by default) --}}
                                            <div class="edit-mode hidden">
                                                <form action="{{ route('evaluasi.update', $evaluasi) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="catatan" rows="2" class="w-full text-sm border rounded p-2">{{ $evaluasi->catatan }}</textarea>
                                                    <div class="flex items-center space-x-2 mt-1">
                                                        <button type="submit"
                                                            class="bg-yellow-500 text-white text-xs font-bold py-1 px-3 rounded hover:bg-yellow-600">Update</button>
                                                        <button type="button"
                                                            onclick="toggleEdit({{ $evaluasi->id_evaluasi }})"
                                                            class="text-gray-600 text-xs">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-xs text-gray-500">Belum ada catatan.</p>
                                    @endforelse
                                </div>

                                @if (Auth::user()->role === 'tim_sakip' || Auth::user()->role === 'evaluator')
                                    <form action="{{ route('evaluasi.store') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="id_realisasi_fk"
                                            value="{{ $realisasi->id_realisasi }}">
                                        <textarea name="catatan" rows="2" class="w-full text-sm border rounded p-2"
                                            placeholder="Tulis catatan Anda di sini..."></textarea>
                                        <button type="submit"
                                            class="bg-blue-500 text-white text-xs font-bold py-1 px-3 rounded mt-2 hover:bg-blue-700">Submit
                                            Catatan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">Belum ada laporan realisasi yang
                                disubmit.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
            function toggleEdit(id) {
                const container = document.getElementById(`evaluasi-${id}`);
                const viewMode = container.querySelector('.view-mode');
                const editMode = container.querySelector('.edit-mode');

                viewMode.classList.toggle('hidden');
                editMode.classList.toggle('hidden');
            }
        </script>
    @endpush
@endsection
