<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Absensi - Digital Board</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #333; margin: 30px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 5px 0 0 0; font-size: 12px; color: #666; }
        .agenda-block { margin-top: 30px; border: 1px solid #ccc; border-radius: 6px; padding: 15px; background-color: #fafafa; page-break-inside: avoid; }
        .agenda-title { font-size: 14px; font-weight: bold; margin: 0 0 5px 0; color: #000; }
        .agenda-meta { font-size: 11px; color: #555; margin: 0 0 10px 0; }
        table { w-full; border-collapse: collapse; width: 100%; margin-top: 10px; background-color: #fff; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
        .badge-hadir { background-color: #d1e7dd; color: #0f5132; }
        .badge-terlambat { background-color: #fff3cd; color: #664d03; }
        .badge-izin { background-color: #cff4fc; color: #055160; }
        .badge-alpa { background-color: #f8d7da; color: #842029; }
        @media print {
            .no-print { display: none; }
            body { margin: 10px; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background-color: #0f5132; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Cetak Laporan</button>
        <button onclick="window.close()" style="padding: 8px 16px; background-color: #666; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; margin-left: 10px;">Tutup</button>
    </div>

    <div class="header">
        <h1>LAPORAN KEHADIRAN MAHASISWA (PER AGENDA)</h1>
        <p>Sistem Manajemen Cerdas Laboratorium - DIGITAL Board</p>
        @if(request('start_date') && request('end_date'))
            <p><strong>Periode: {{ date('d M Y', strtotime(request('start_date'))) }} s/d {{ date('d M Y', strtotime(request('end_date'))) }}</strong></p>
        @endif
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>

    @if(count($agendas) > 0)
        @foreach($agendas as $ag)
            <div class="agenda-block">
                <div class="agenda-title">{{ $ag->mata_kuliah }} - Kelas {{ $ag->kelas ?: '-' }}</div>
                <div class="agenda-meta">
                    Dosen: <strong>{{ $ag->dosen->nama }}</strong> | Lab: <strong>{{ $ag->lab->nama_lab }}</strong> | Tanggal: <strong>{{ date('d M Y', strtotime($ag->tanggal)) }} ({{ substr($ag->jam_mulai,0,5) }}-{{ substr($ag->jam_selesai,0,5) }} WIB)</strong>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Waktu Masuk</th>
                            <th>Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($ag->absensi->count() > 0)
                            @foreach($ag->absensi as $idx => $abs)
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
                                <td colspan="5" style="text-align: center; color: #888; font-style: italic;">Belum ada mahasiswa yang melakukan absensi pada sesi ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @endforeach
    @else
        <p style="text-align: center; margin-top: 50px; font-style: italic; color: #666;">Tidak ada data agenda perkuliahan untuk periode ini.</p>
    @endif

    <div style="margin-top: 50px; float: right; text-align: center; width: 200px; page-break-inside: avoid;">
        <p>Petugas Laboratorium</p>
        <div style="height: 60px;"></div>
        <p><strong>{{ auth()->user()->username }}</strong></p>
        <p style="font-size: 10px; color: #666;">Administrator</p>
    </div>

</body>
</html>




