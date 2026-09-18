<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI PRESENSI MAHASISWA - UNIVERSITAS IBN KHALDUN BOGOR</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 6mm 8mm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9.5px;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
        }
        .no-print {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 9999;
            background: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            gap: 8px;
        }
        .btn-print {
            padding: 6px 14px;
            background-color: #0f766e;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
            cursor: pointer;
        }
        .btn-close {
            padding: 6px 14px;
            background-color: #475569;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
            cursor: pointer;
        }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
            .page-break { page-break-after: always; }
        }
        .wrapper {
            width: 100%;
            page-break-inside: avoid;
            margin-bottom: 20px;
        }
        
        /* HEADER ACUAN PERSIS FOTO UIKA */
        .header-container {
            width: 100%;
            position: relative;
            margin-bottom: 6px;
        }
        .header-logo-right {
            position: absolute;
            top: 0;
            right: 0;
            width: 55px;
            height: auto;
        }
        .header-center-text {
            text-align: center;
            width: 100%;
        }
        .univ-title {
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin: 0;
            text-transform: uppercase;
        }
        .univ-address {
            font-size: 9.5px;
            color: #222;
            margin: 1px 0;
        }
        .univ-contact {
            font-size: 8.5px;
            color: #444;
            margin: 0 0 4px 0;
        }
        .doc-main-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 3px 0 1px 0;
            letter-spacing: 0.5px;
        }
        .doc-prodi-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        .doc-ta-title {
            font-size: 10.5px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 1px 0 4px 0;
        }

        /* METADATA BAR */
        .meta-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
            font-size: 9.5px;
        }
        .meta-container td {
            padding: 2px 0;
            vertical-align: bottom;
        }

        /* MAIN TABLE GRID */
        .grid-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-top: 2px;
        }
        .grid-table th, .grid-table td {
            border: 1px solid #000;
            padding: 3px 2px;
            text-align: center;
            vertical-align: middle;
        }
        .grid-table th {
            background-color: #f8fafc;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5px;
        }
        
        .th-no { width: 24px; }
        .th-nim { width: 90px; }
        .th-nama { text-align: left !important; padding-left: 5px !important; min-width: 170px; }
        .th-tm { width: 36px; font-size: 8px; }

        .cell-no { font-family: 'Courier New', Courier, monospace; font-size: 9px; }
        .cell-nim { font-family: 'Courier New', Courier, monospace; font-size: 9px; white-space: nowrap; }
        .cell-nama {
            text-align: left !important;
            padding-left: 5px !important;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
        }
        .cell-tm {
            font-size: 10px;
            font-weight: bold;
            height: 20px;
        }

        /* ATTENDANCE MARKS */
        .mark-hadir { color: #000; font-weight: bold; font-size: 11px; }
        .mark-terlambat { color: #000; font-weight: bold; }
        .mark-izin { color: #000; font-weight: bold; }
        .mark-sakit { color: #000; font-weight: bold; }
        .mark-alpa { color: #000; font-weight: bold; }

        .date-row td {
            font-size: 8px;
            height: 14px;
            color: #000;
            background-color: #fff;
            font-weight: 600;
        }

        /* FOOTER SIGNATURE */
        .footer-table {
            width: 100%;
            margin-top: 12px;
            border-collapse: collapse;
            page-break-inside: avoid;
            font-size: 9.5px;
        }
        .footer-table td {
            vertical-align: top;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Lembar Presensi ({{ count($courseReports) }} Matkul A4)</button>
        <button class="btn-close" onclick="window.close()">Tutup</button>
    </div>

    @if(count($courseReports) > 0)
        @foreach($courseReports as $index => $report)
            <div class="wrapper {{ $index < count($courseReports) - 1 ? 'page-break' : '' }}">
                
                <!-- HEADER ACUAN RESMI UIKA BOGOR (LAYOUT 3 KOLOM SEIMBANG - TEKS 100% CENTER) -->
                <div class="header-container" style="width: 100%; margin-bottom: 8px;">
                    <table style="width: 100%; border-collapse: collapse; border: none; margin: 0; padding: 0;">
                        <tr style="border: none;">
                            <!-- KOLOM KIRI: LOGO UIKA (60px) -->
                            <td style="width: 65px; vertical-align: top; border: none; padding: 0; text-align: left;">
                                <img src="https://commons.wikimedia.org/wiki/Special:FilePath/LOGO_UIKA_Terbaru2.png" 
                                     alt="Logo UIKA" 
                                     style="width: 55px; height: 55px; object-fit: contain;" 
                                     onerror="this.onerror=null; this.src='https://uika-bogor.ac.id/media/gambar/uika_logo.png'; this.onerror=function(){ this.style.display='none'; this.nextElementSibling.style.display='block'; };">
                                <svg style="display: none; width: 50px; height: 50px;" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <polygon points="50,4 95,33 78,92 22,92 5,33" fill="#15803d" stroke="#facc15" stroke-width="4"/>
                                    <circle cx="50" cy="48" r="30" fill="none" stroke="#facc15" stroke-width="3"/>
                                    <text x="50" y="44" font-family="Arial, sans-serif" font-weight="900" font-size="15" fill="#ffffff" text-anchor="middle">UIKA</text>
                                    <text x="50" y="60" font-family="Arial, sans-serif" font-weight="bold" font-size="10" fill="#facc15" text-anchor="middle">BOGOR</text>
                                </svg>
                            </td>

                            <!-- KOLOM TENGAH: TEKS KOP SURAT (TEK TEGAS & PRESISI DITENGAH) -->
                            <td style="vertical-align: top; border: none; padding: 0; text-align: center;">
                                <div class="univ-title" style="font-size: 15px; font-weight: bold; font-style: normal !important; text-transform: uppercase; letter-spacing: 0.5px; color: #000; margin-bottom: 2px;">UNIVERSITAS IBN KHALDUN BOGOR</div>
                                <div class="univ-address" style="font-size: 9.5px; font-style: normal !important; color: #000; margin-bottom: 2px;">Jl. KH Sholeh Iskandar KM 2 Kedung Badak Bogor</div>
                                <div class="univ-contact" style="font-size: 8.5px; font-style: normal !important; color: #111; margin-bottom: 4px;">Website: uika-bogor.ac.id | e-Mail: mail@uika-bogor.ac.id / Telepon: 0251-8356884</div>
                            </td>

                            <!-- KOLOM KANAN: PENYEIMBANG KOSONG (65px SAJA AGAR TEKS TENGAH DITENGAH PERSIS) -->
                            <td style="width: 65px; vertical-align: top; border: none; padding: 0;"></td>
                        </tr>
                    </table>
                    
                    <!-- GARIS KOP HORIZONTAL TEGAS (PERSIS FOTO DOKUMEN ASLI) -->
                    <div style="border-bottom: 2px solid #000; margin: 6px 0 8px 0; width: 100%;"></div>

                    <!-- JUDUL PRESENSI & PRODI -->
                    <div style="text-align: center; font-style: normal !important;">
                        <div class="doc-main-title" style="font-size: 13px; font-weight: bold; font-style: normal !important; text-transform: uppercase; margin: 2px 0 1px 0; letter-spacing: 0.5px; color: #000;">ISI PRESENSI MAHASISWA</div>
                        <div class="doc-prodi-title" style="font-size: 11px; font-weight: bold; font-style: normal !important; text-transform: uppercase; color: #000;">{{ $report['mainAgenda']->dosen->prodi->nama_prodi ?? 'SISTEM INFORMASI' }}</div>
                        <div class="doc-ta-title" style="font-size: 10.5px; font-weight: bold; font-style: normal !important; text-transform: uppercase; margin-top: 1px; color: #000;">{{ $report['mainAgenda']->tahun_akademik ?? '2025 GENAP' }}</div>
                    </div>
                </div>

                <!-- METADATA TANPA KOTAK / UNBOXED (PERSIS FOTO) -->
                <table style="width: 100%; table-layout: fixed; border-collapse: collapse; margin-bottom: 4px; font-size: 9.5px; border: none;">
                    <tr>
                        <td style="border: none; padding: 2px 0; text-align: left; font-size: 9.5px;">
                            Mata kuliah : <strong>{{ $report['mataKuliah'] }}</strong>
                        </td>
                        <td style="border: none; padding: 2px 0; text-align: right; font-size: 9.5px;">
                            Semester/Kelas : <strong>{{ $report['kelas'] ?: 'II Reg' }}</strong>
                        </td>
                    </tr>
                    @if($report['mainAgenda'] && $report['mainAgenda']->dosen)
                    <tr>
                        <td colspan="2" style="border: none; padding: 1px 0; text-align: left; font-size: 8.5px; color: #333;">
                            Dosen: {{ $report['mainAgenda']->dosen->nama }}
                        </td>
                    </tr>
                    @endif
                </table>

                <!-- TABEL MATRIKS PRESENSI 16 TATAP MUKA (BORDER HANYA PADA TABEL INI) -->
                <table class="grid-table">
                    <thead>
                        <tr>
                            <th rowspan="3" class="th-no">No</th>
                            <th rowspan="3" class="th-nim">NIM/NPM</th>
                            <th rowspan="3" class="th-nama">NAMA</th>
                            <th colspan="16">TATAP MUKA</th>
                        </tr>
                        <tr>
                            @for($i = 1; $i <= 16; $i++)
                                <th class="th-tm">
                                    @if($i == 8)
                                        8 (UTS)
                                    @elseif($i == 16)
                                        16 (UAS)
                                    @else
                                        {{ $i }}
                                    @endif
                                </th>
                            @endfor
                        </tr>
                        <tr class="date-row">
                            @for($i = 1; $i <= 16; $i++)
                                <td>
                                    @if(!empty($report['sessions'][$i]['tanggal']))
                                        {{ date('d/m', strtotime($report['sessions'][$i]['tanggal'])) }}
                                    @else
                                        &nbsp;
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($report['students']) > 0)
                            <tr>
                                <td colspan="19" style="text-align: left; padding-left: 6px; font-weight: bold; background-color: #f1f5f9; font-size: 8.5px; text-transform: uppercase;">
                                    Peserta Reguler
                                </td>
                            </tr>
                            @foreach($report['students'] as $idx => $mhs)
                                <tr>
                                    <td class="cell-no">{{ $idx + 1 }}</td>
                                    <td class="cell-nim">{{ $mhs->nim }}</td>
                                    <td class="cell-nama">{{ $mhs->nama_lengkap }}</td>
                                    
                                    @for($i = 1; $i <= 16; $i++)
                                        @php
                                            $rec = $report['matrix'][$mhs->id][$i] ?? null;
                                        @endphp
                                        <td class="cell-tm">
                                            @if($rec)
                                                @php
                                                    $st = strtolower($rec->status_kehadiran);
                                                @endphp
                                                @if($st === 'hadir')
                                                    <span class="mark-hadir" title="Hadir ({{ date('H:i', strtotime($rec->waktu_masuk)) }})">✓</span>
                                                @elseif($st === 'terlambat')
                                                    <span class="mark-terlambat" title="Terlambat ({{ date('H:i', strtotime($rec->waktu_masuk)) }})">T</span>
                                                @elseif($st === 'izin')
                                                    <span class="mark-izin" title="Izin">I</span>
                                                @elseif($st === 'sakit')
                                                    <span class="mark-sakit" title="Sakit">S</span>
                                                @else
                                                    <span class="mark-alpa" title="Alpa">A</span>
                                                @endif
                                            @else
                                                &nbsp;
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="19" style="text-align: center; color: #666; font-style: italic; padding: 15px;">
                                    Belum ada data mahasiswa terdaftar pada mata kuliah ini.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- FOOTER TANDA TANGAN (BOGOR & DOSEN) -->
                <table class="footer-table">
                    <tr>
                        <td style="width: 65%;"></td>
                        <td style="width: 35%;">
                            Bogor, {{ date('d F Y') }}<br>
                            <strong>Dosen Pengampu / Penanggung Jawab</strong>
                            <div style="height: 45px;"></div>
                            <strong><u>{{ $report['mainAgenda']->dosen->nama ?? auth()->user()->username }}</u></strong><br>
                            <span style="font-size: 8.5px; color: #333;">NIP/NIDN: {{ $report['mainAgenda']->dosen->nip ?? '-' }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    @else
        <div style="text-align: center; margin-top: 100px; color: #666; font-style: italic;">
            Tidak ada data mata kuliah yang dipilih untuk dicetak.
        </div>
    @endif

</body>
</html>
