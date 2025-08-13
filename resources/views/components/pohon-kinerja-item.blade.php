{{-- File ini MEREPRESENTASIKAN SATU BARIS di dalam tabel --}}
<tr class="hover:bg-gray-100">
    {{-- Kode Kinerja --}}
    <td class="text-left py-3 px-4">
        <strong>{{ $item->kode_kinerja }}</strong>
    </td>

    {{-- Deskripsi Sasaran dengan Indentasi --}}
    <td class="text-left py-3 px-4" style="padding-left: {{ $level * 25 + 16 }}px;">
        <i class="fas fa-level-up-alt fa-rotate-90 text-gray-400 mr-2"></i>
        {{ $item->deskripsi_sasaran }}
    </td>

    {{-- Kolom lainnya --}}
    <td class="text-left py-3 px-4">{{ $item->indikator }}</td>
    <td class="text-left py-3 px-4">{{ $item->target }}</td>
    <td class="text-left py-3 px-4">{{ $item->satuan }}</td>
    <td class="text-left py-3 px-4">
        <a href="{{ route('pohon-kinerja.show', $item) }}" class="text-blue-500 hover:text-blue-700 text-sm"
            title="Lihat Detail">
            <i class="fas fa-eye"></i> Detail
        </a>
        <br>
        <hr>
        {{-- TOMBOL EDIT BARU --}}
        <a href="{{ route('pohon-kinerja.edit', $item) }}" class="text-yellow-500 hover:text-yellow-700 text-sm mr-2">
            <i class="fas fa-edit"></i> Edit
        </a>
        <br>
        <hr>
        {{-- TOMBOL TAMBAH SUB-ITEM --}}
        <a href="{{ route('pohon-kinerja.create', ['induk' => $item->id_pk]) }}"
            class="text-green-500 hover:text-green-700 text-sm">
            <i class="fas fa-plus"></i> Sub
        </a>
        <br>
        <hr>
        {{-- TOMBOL ASSIGN BARU --}}
        <a href="{{ route('pohon-kinerja.assign.show', $item) }}" class="text-purple-500 hover:text-purple-700 text-sm"
            title="Assign Unit Kerja">
            <i class="fas fa-users-cog"></i> Assign
        </a>
        <br>
        <hr>
        <form action="{{ route('pohon-kinerja.destroy', $item) }}" method="POST"
            onsubmit="return confirm('Anda yakin ingin menghapus item ini? SEMUA sub-item di bawahnya juga akan terhapus secara permanen!');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>
    </td>
</tr>

{{-- ======================================================= --}}
{{-- BAGIAN REKURSIF: Panggil kembali komponen ini untuk setiap anak --}}
{{-- ======================================================= --}}
@if ($item->anak->isNotEmpty())
    @foreach ($item->anak as $child)
        <x-pohon-kinerja-item :item="$child" :level="$level + 1" />
    @endforeach
@endif
