<!DOCTYPE html>
<html>
<head>
    <title>Laporan Realisasi</title>
    <style>
        @page { margin: 20px; }
        body { font-family: sans-serif; font-size: 12px; }
        .report-header { text-align: center; margin-bottom: 20px; }
        .report-header h1 { margin: 0; }
        .report-info { margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        .indicator-block {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .indicator-header { background-color: #f2f2f2; padding: 8px; margin-bottom: 10px; }
        .indicator-header h3 { margin: 0; font-size: 14px; }
        .indicator-details table { width: 100%; margin-bottom: 10px; }
        .indicator-details td { padding: 4px; vertical-align: top; }
        .indicator-details td:first-child { font-weight: bold; width: 150px; }
        .analysis-section { margin-top: 10px; }
        .analysis-section h4 {
            margin: 0 0 5px 0;
            font-size: 12px;
            font-weight: bold;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }
        .analysis-section p { margin: 0 0 10px 0; padding-left: 10px; white-space: pre-wrap; word-wrap: break-word; }
    </style>
</head>
<body>
    <div class="report-header">
        <h1>Laporan Realisasi Kinerja</h1>
    </div>

    <div class="report-info">
        <p><strong>Indikator Kinerja:</strong> {{ $pohonKinerja->indikator }}</p>
        <p><strong>Kode IKU:</strong> {{ $pohonKinerja->kode_kinerja }}</p>
        <p><strong>Tahun Laporan:</strong> {{ $tahun }}</p>
    </div>

    @forelse($realisasis as $realisasi)
    <div class="indicator-block">
        <div class="indicator-header">
            {{-- Pemanggilan relasi 'unitKerja' sudah benar --}}
            <h3>Unit Pelapor: {{ $realisasi->unitKerja->nama_unit }}</h3>
        </div>
        <div class="indicator-details">
            <table>
                <tr>
                    <td>Target Kinerja</td>
                    <td>: {{ $pohonKinerja->target }} {{ $pohonKinerja->satuan }}</td>
                </tr>
                <tr>
                    <td>Realisasi Capaian</td>
                    <td>: {{ $realisasi->capaian_realisasi }} {{ $pohonKinerja->satuan }}</td>
                </tr>
                <tr>
                    <td>Anggaran Realisasi</td>
                    <td>: Rp {{ number_format($realisasi->anggaran_realisasi, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Tanggal Lapor</td>
                    <td>: {{ $realisasi->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
                 <tr>
                    <td>Link Bukti</td>
                    <td>: <a href="{{ $realisasi->link_bukti }}">{{ $realisasi->link_bukti }}</a></td>
                </tr>
            </table>
        </div>
        <div class="analysis-section">
            <h4>Analisis Progres dan Kendala (Deskripsi)</h4>
            <p>{!! nl2br(e($realisasi->analisis_progres)) !!}</p>
            <p><strong>Kendala:</strong> {!! nl2br(e($realisasi->analisis_kendala)) !!}</p>
        </div>
        <div class="analysis-section">
            <h4>Strategi Tindak Lanjut</h4>
            <p>{!! nl2br(e($realisasi->analisis_strategi)) !!}</p>
        </div>
    </div>
    @empty
    <p>Tidak ada data laporan realisasi untuk indikator dan tahun yang dipilih.</p>
    @endforelse

</body>
</html>