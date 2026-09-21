<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realisasi Praktikum - {{ $agenda->mata_kuliah }} ({{ $semesterKelas }})</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            background-color: #f1f5f9;
            color: #000000;
            font-size: 11px;
            line-height: 1.35;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Screen Toolbar */
        .no-print-toolbar {
            background-color: #0f172a;
            color: #f8fafc;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .no-print-toolbar .title {
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .no-print-toolbar .actions {
            display: flex;
            gap: 12px;
        }

        .btn-action {
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-print {
            background-color: #0284c7;
            color: #ffffff;
        }
        .btn-print:hover {
            background-color: #0369a1;
        }

        .btn-close {
            background-color: #334155;
            color: #ffffff;
        }
        .btn-close:hover {
            background-color: #475569;
        }

        /* Document Wrapper */
        .document-wrapper {
            display: flex;
            justify-content: center;
            padding: 24px 15px;
        }

        /* A4 Landscape Page Layout (297mm x 210mm) */
        .a4-sheet {
            width: 297mm;
            min-height: 210mm;
            background: #ffffff;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            padding: 10mm 15mm 8mm 15mm;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Header Lembar */
        .doc-header {
            text-align: center;
            margin-bottom: 12px;
        }

        .doc-title-main {
            font-size: 15px;
            font-weight: 900;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1px;
            color: #000;
        }

        .doc-title-sub {
            font-size: 12.5px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1px;
            color: #000;
        }

        .doc-title-inst {
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #000;
        }

        /* Metadata Grid */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 11px;
            line-height: 1.45;
        }

        .meta-table td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .meta-label {
            font-weight: 700;
            color: #000;
            white-space: nowrap;
        }

        .meta-sep {
            width: 12px;
            text-align: center;
            font-weight: 700;
        }

        .meta-val {
            font-weight: 600;
            color: #000;
        }

        /* Table Realisasi Praktikum */
        .realisasi-table {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            margin-bottom: 10px;
            font-size: 11px;
        }

        .realisasi-table th {
            border: 1px solid #000;
            background-color: #dbeafe; /* Subtle light blue header matching official physical form */
            font-weight: 800;
            text-align: center;
            padding: 6px 6px;
            font-size: 11px;
            color: #000;
            letter-spacing: 0.2px;
        }

        .realisasi-table td {
            border: 1px solid #000;
            padding: 5px 6px;
            vertical-align: middle;
            color: #000;
        }

        .col-no {
            width: 35px;
            text-align: center;
            font-weight: 700;
        }

        .col-tgl {
            width: 160px;
            text-align: center;
            font-weight: 600;
            white-space: nowrap;
        }

        .col-waktu {
            width: 115px;
            text-align: center;
            font-weight: 600;
            white-space: nowrap;
        }

        .col-materi {
            font-weight: 500;
            line-height: 1.35;
            padding-left: 8px;
            padding-right: 8px;
            word-break: break-word;
        }

        .col-paraf {
            width: 110px;
            text-align: center;
        }

        .col-paraf-prodi {
            width: 135px;
            text-align: center;
        }

        .paraf-space {
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Note & Footer */
        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            margin-top: 4px;
        }

        .note-box {
            width: 100%;
            font-size: 9.5px;
            line-height: 1.45;
            color: #000;
        }

        .note-title {
            font-weight: 800;
            margin-bottom: 1px;
        }

        .note-list {
            padding-left: 16px;
            margin: 0;
            font-weight: 500;
        }

        .note-list li {
            margin-bottom: 1px;
        }

        /* Print Media Styles (Landscape A4) */
        @media print {
            body {
                background: #ffffff;
                margin: 0;
                padding: 0;
            }

            .no-print-toolbar {
                display: none !important;
            }

            .document-wrapper {
                padding: 0;
                margin: 0;
            }

            .a4-sheet {
                box-shadow: none;
                width: 100%;
                min-height: 100vh;
                margin: 0;
                padding: 8mm 14mm 6mm 14mm;
                page-break-after: avoid;
            }

            .realisasi-table th {
                background-color: #dbeafe !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            @page {
                size: A4 landscape;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Non-print Toolbar -->
    <div class="no-print-toolbar">
        <div class="title">
            <i class="fa-solid fa-file-signature text-sky-400"></i>
            <span>Lembar Realisasi Praktikum Resmi (Landscape) — FT UIKA BOGOR</span>
        </div>
        <div class="actions">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fa-solid fa-print"></i> Cetak / Unduh PDF (A4 Landscape)
            </button>
            <button onclick="window.close()" class="btn-action btn-close">
                <i class="fa-solid fa-xmark"></i> Tutup
            </button>
        </div>
    </div>

    <!-- Document Page Container -->
    <div class="document-wrapper">
        <div class="a4-sheet">

            <div>
                <!-- 1. Header Dokumen Resmi -->
                <div class="doc-header">
                    <h1 class="doc-title-main">REALISASI PRAKTIKUM</h1>
                    <h2 class="doc-title-sub">{{ $semesterTeks }} TA. {{ $tahunAjaran }}</h2>
                    <h3 class="doc-title-inst">FAKULTAS TEKNIK - UNIVERSITAS IBN KHALDUN BOGOR</h3>
                </div>

                <!-- 2. Metadata Mata Kuliah & Dosen Pengampu -->
                <table class="meta-table">
                    <tr>
                        <td style="width: 58%;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td class="meta-label" style="width: 175px;">Nama Dosen / Dosen Pengampu</td>
                                    <td class="meta-sep">:</td>
                                    <td class="meta-val">{{ $dosenDisplay }}</td>
                                </tr>
                                <tr>
                                    <td class="meta-label">Nama Mata Kuliah</td>
                                    <td class="meta-sep">:</td>
                                    <td class="meta-val">{{ $agenda->mata_kuliah }}</td>
                                </tr>
                                <tr>
                                    <td class="meta-label">Kode Mata Kuliah</td>
                                    <td class="meta-sep">:</td>
                                    <td class="meta-val">{{ $kodeMatkul }}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 42%;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td class="meta-label" style="width: 110px;">Jumlah SKS</td>
                                    <td class="meta-sep">:</td>
                                    <td class="meta-val">{{ $sks }}</td>
                                </tr>
                                <tr>
                                    <td class="meta-label">Program Studi</td>
                                    <td class="meta-sep">:</td>
                                    <td class="meta-val">{{ $prodi }}</td>
                                </tr>
                                <tr>
                                    <td class="meta-label">Semester / Kelas</td>
                                    <td class="meta-sep">:</td>
                                    <td class="meta-val">{{ $semesterKelas }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- 3. Tabel Baris Realisasi Pertemuan -->
                @php
                    $dayNames = [
                        'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
                    ];

                    $totalRows = max(8, $agendas->count());
                    if ($agendas->count() > 8 && $agendas->count() <= 16) {
                        $totalRows = max(14, $agendas->count());
                    }
                @endphp

                <table class="realisasi-table">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th class="col-tgl">Hari / Tanggal</th>
                            <th class="col-waktu">Waktu</th>
                            <th class="col-materi">Materi Praktikum</th>
                            <th class="col-paraf">Paraf Dosen</th>
                            <th class="col-paraf-prodi">Paraf Program Studi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < $totalRows; $i++)
                            @php
                                $item = $agendas->get($i);
                                $hariTanggalStr = '';
                                $waktuStr = '';
                                $materiStr = '';

                                if ($item) {
                                    $cDate = \Carbon\Carbon::parse($item->tanggal);
                                    $hariEn = $cDate->format('l');
                                    $hariId = $dayNames[$hariEn] ?? $hariEn;
                                    // Format persis seperti di lembar fisik: "Senin / 23 - 02 - 2026"
                                    $hariTanggalStr = $hariId . ' / ' . $cDate->format('d - m - Y');

                                    // Format waktu: "14.00 - 15.30"
                                    $start = substr($item->jam_mulai, 0, 5);
                                    $end = substr($item->jam_selesai, 0, 5);
                                    $waktuStr = str_replace(':', '.', $start) . ' - ' . str_replace(':', '.', $end);

                                    $materiStr = $item->materi_realisasi ?: ($item->catatan ?: '');
                                }
                            @endphp
                            <tr>
                                <td class="col-no">{{ $i + 1 }}</td>
                                <td class="col-tgl">{{ $hariTanggalStr ?: '' }}</td>
                                <td class="col-waktu">{{ $waktuStr ?: '' }}</td>
                                <td class="col-materi">
                                    {{ $materiStr ?: '' }}
                                </td>
                                <td class="col-paraf">
                                    <div class="paraf-space">
                                        {{-- Ruang kosong untuk tanda paraf dosen fisik --}}
                                    </div>
                                </td>
                                <td class="col-paraf-prodi">
                                    <div class="paraf-space">
                                        {{-- Ruang kosong untuk tanda paraf program studi fisik --}}
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- 4. Note Kaki (Tanpa Cap) -->
            <div class="footer-container">
                <div class="note-box">
                    <div class="note-title">NOTE :</div>
                    <ol class="note-list">
                        <li>Peserta wajib hadir saat pelaksanaan praktikum</li>
                        <li>Apabila jadwal praktikum berbenturan dengan jadwal UTS maka kegiatan praktikum diteruskan setelah UTS selesai</li>
                        <li>Di akhir pelaksanaan praktikum peserta diwajibkan membuat laporan kegiatan pelaksanaan praktikum dan dikumpulkan maksimal 7 hari setelah pelaksanaan praktikum selesai</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
