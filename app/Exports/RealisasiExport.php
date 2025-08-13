<?php

namespace App\Exports;

use App\Models\Realisasi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RealisasiExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $id_instrumen;
    protected $tahun;

    public function __construct(int $id_instrumen, int $tahun)
    {
        $this->id_instrumen = $id_instrumen;
        $this->tahun = $tahun;
    }

    /**
     * Mendefinisikan query untuk mengambil data dari database.
     */
    public function query()
    {
        return Realisasi::query()
            ->with(['pohonKinerja', 'unitKerja']) // Eager load relasi
            ->where('tahun_laporan', $this->tahun)
            ->whereHas('pohonKinerja', function ($query) {
                $query->where('id_instrumen_fk', $this->id_instrumen);
            });
    }

    /**
     * Mendefinisikan header kolom di file Excel.
     */
    public function headings(): array
    {
        return [
            'Kode IKU',
            'Indikator Kinerja',
            'Target',
            'Satuan',
            'Unit Pelapor',
            'Tahun Laporan',
            'Capaian Realisasi',
            'Analisis Progres',
            'Analisis Kendala',
            'Strategi Tindak Lanjut',
            'Link Bukti',
            'Anggaran',
            'Tanggal Submit',
        ];
    }

    /**
     * Memetakan setiap baris data ke format array yang diinginkan.
     * @param Realisasi $realisasi
     */
    public function map($realisasi): array
    {
        return [
            $realisasi->pohonKinerja->kode_kinerja,
            $realisasi->pohonKinerja->indikator,
            $realisasi->pohonKinerja->target,
            $realisasi->pohonKinerja->satuan,
            $realisasi->unitKerja->nama_unit,
            $realisasi->tahun_laporan,
            $realisasi->capaian_realisasi,
            $realisasi->analisis_progres,
            $realisasi->analisis_kendala,
            $realisasi->analisis_strategi,
            $realisasi->link_bukti,
            $realisasi->anggaran_realisasi,
            $realisasi->created_at->format('d-m-Y H:i:s'),
        ];
    }
}