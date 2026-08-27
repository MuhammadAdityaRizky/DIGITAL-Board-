<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kehadiran Mahasiswa - Digital Board</title>
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
        .badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; border: 1px solid #333; }
        .badge-hadir { background-color: #e2f0d9; }
        .badge-terlambat { background-color: #fff2cc; }
        .badge-izin { background-color: #ddebf7; }
        .badge-alpa { background-color: #fce4d6; }
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
        <h1>Laporan Kehadiran Mahasiswa</h1>
        <p>Sistem Smart Lab - Digital Display Display Board</p>
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>

    <table class="details-table">
        <tr>
            <td class="label">Mata Kuliah:</td>
            <td class="value"><strong>{{ $agenda->mata_kuliah }}</strong></td>
            <td class="label">Tanggal:</td>
            <td class="value">{{ date('d M Y', strtotime($agenda->tanggal)) }}</td>
        </tr>
        <tr>
            <td class="label">Kelas / Semester:</td>
            <td class="value">{{ $agenda->kelas }} / Semester {{ $agenda->semester ?? '1' }}</td>
            <td class="label">Waktu:</td>
            <td class="value">{{ substr($agenda->jam_mulai,0,5) }} - {{ substr($agenda->jam_selesai,0,5) }} WIB</td>
        </tr>
        <tr>
            <td class="label">Dosen:</td>
            <td class="value"><strong>{{ $agenda->dosen->nama }}</strong></td>
            <td class="label">Laboratorium:</td>
            <td class="value">{{ $agenda->lab->nama_lab }} ({{ $agenda->lab->lokasi }})</td>
        </tr>
        <tr>
            <td class="label">Fakultas:</td>
            <td class="value">{{ $agenda->fakultas }}</td>
            <td class="label">Program Studi:</td>
            <td class="value">{{ $agenda->jurusan }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Nama Lengkap</th>
                <th style="width: 150px;">NIM</th>
                <th style="width: 150px;">Waktu Absensi</th>
                <th style="width: 120px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @if($agenda->absensi->count() > 0)
                @foreach($agenda->absensi as $idx => $abs)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td><strong>{{ $abs->mahasiswa->nama_lengkap }}</strong></td>
                        <td>{{ $abs->mahasiswa->nim }}</td>
                        <td>{{ date('H:i:s', strtotime($abs->waktu_masuk)) }} WIB</td>
                        <td>
                            @if(strtolower($abs->status_kehadiran) === 'hadir')
                                <span class="badge badge-hadir">Hadir</span>
                            @elseif(strtolower($abs->status_kehadiran) === 'terlambat')
                                <span class="badge badge-terlambat">Terlambat</span>
                            @elseif(strtolower($abs->status_kehadiran) === 'izin' || strtolower($abs->status_kehadiran) === 'sakit')
                                <span class="badge badge-izin">{{ $abs->status_kehadiran }}</span>
                            @else
                                <span class="badge badge-alpa">Alpa</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center; color: #666; font-style: italic; padding: 20px;">Belum ada absensi tercatat pada agenda kelas ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 60px; float: right; text-align: center; width: 220px; page-break-inside: avoid;">
        <p>Dosen Pengampu,</p>
        <div style="height: 60px;"></div>
        <p><strong>{{ $agenda->dosen->nama }}</strong></p>
        <p style="font-size: 10px; color: #555; margin-top: 2px;">NIP. {{ $agenda->dosen->nip }}</p>
    </div>

</body>
</html>
