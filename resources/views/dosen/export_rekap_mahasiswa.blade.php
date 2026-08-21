<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekap Kehadiran Mahasiswa - Digital Board</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #333; margin: 30px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0 0; font-size: 11px; color: #555; }
        .details-table { width: 100%; margin-bottom: 20px; border: none; }
        .details-table td { padding: 4px 0; border: none; font-size: 12px; }
        .details-table td.label { font-weight: bold; width: 15%; }
        .details-table td.value { width: 35%; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.data-table, table.data-table th, table.data-table td { border: 1px solid #333; }
        table.data-table th, table.data-table td { padding: 8px; text-align: left; }
        table.data-table th { background-color: #f2f2f2; font-weight: bold; }
        table.data-table td.center { text-align: center; }
        @media print {
            .no-print { display: none; }
            body { margin: 10px; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background-color: #0d9488; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Cetak Laporan</button>
        <button onclick="window.close()" style="padding: 8px 16px; background-color: #4b5563; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; margin-left: 10px;">Tutup</button>
    </div>

    <div class="header">
        <h1>Laporan Rekapitulasi Kehadiran Mahasiswa</h1>
        <p>Sistem Smart Lab - Digital Display Display Board</p>
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>

    <table class="details-table">
        <tr>
            <td class="label">Dosen:</td>
            <td class="value"><strong>{{ $dosen->nama }}</strong></td>
            <td class="label">Program Studi:</td>
            <td class="value">{{ $dosen->prodi->nama_prodi ?? 'Informatika' }}</td>
        </tr>
        <tr>
            <td class="label">NIP:</td>
            <td class="value">{{ $dosen->nip }}</td>
            <td class="label">Fakultas:</td>
            <td class="value">{{ $dosen->fakultas->nama_fakultas ?? 'Teknik & Ilmu Komputer' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Nama Lengkap</th>
                <th style="width: 120px;">NIM</th>
                <th style="width: 150px;">Program Studi</th>
                <th style="width: 60px;" class="center">Hadir</th>
                <th style="width: 60px;" class="center">Izin</th>
                <th style="width: 60px;" class="center">Alpa</th>
                <th style="width: 90px;" class="center">Total Sesi</th>
                <th style="width: 100px;" class="center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @if($mahasiswas->count() > 0)
                @foreach($mahasiswas as $idx => $mhs)
                    <tr>
                        <td class="center">{{ $idx + 1 }}</td>
                        <td><strong>{{ $mhs->nama_lengkap }}</strong></td>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->prodi->nama_prodi ?? '-' }} ({{ $mhs->kelas }})</td>
                        <td class="center">{{ $mhs->hadir_count }}</td>
                        <td class="center">{{ $mhs->izin_count }}</td>
                        <td class="center">{{ $mhs->alpa_count }}</td>
                        <td class="center">{{ $mhs->total_agenda }}</td>
                        <td class="center"><strong>{{ $mhs->total_agenda > 0 ? round(($mhs->hadir_count / $mhs->total_agenda) * 100, 1) : 0 }}%</strong></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9" style="text-align: center; color: #666; font-style: italic; padding: 20px;">Belum ada data mahasiswa terdaftar.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 60px; float: right; text-align: center; width: 220px; page-break-inside: avoid;">
        <p>Dosen Pengampu,</p>
        <div style="height: 60px;"></div>
        <p><strong>{{ $dosen->nama }}</strong></p>
        <p style="font-size: 10px; color: #555; margin-top: 2px;">NIP. {{ $dosen->nip }}</p>
    </div>

</body>
</html>
