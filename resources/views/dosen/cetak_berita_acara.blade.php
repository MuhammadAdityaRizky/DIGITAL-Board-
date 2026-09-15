@php
    $items = $items ?? collect([['agenda' => $agenda, 'details' => $details]]);
    $totalItems = $totalItems ?? $items->count();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Praktikum - {{ $agenda->mata_kuliah }} {{ $totalItems > 1 ? "({$totalItems} Pertemuan)" : '' }}</title>
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
            color: #0f172a;
            font-size: 13px;
            line-height: 1.5;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Toolbar / Navigation on Screen */
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

        /* Container Document */
        .document-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 28px;
            padding: 30px 15px;
        }

        /* A4 Page Styling */
        .a4-sheet {
            width: 210mm;
            min-height: 297mm;
            background: #ffffff;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            padding: 16mm 18mm 14mm 18mm;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        /* Watermark */
        .watermark-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            user-select: none;
            z-index: 1;
            text-align: center;
            white-space: nowrap;
        }

        .watermark-text {
            font-size: 42px;
            font-weight: 900;
            color: rgba(15, 23, 42, 0.05);
            letter-spacing: 12px;
            text-transform: uppercase;
        }

        .content-layer {
            position: relative;
            z-index: 2;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Header / Kop Surat */
        .header-kop {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 22px;
            padding-bottom: 8px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo-uika {
            width: 76px;
            height: 76px;
            object-fit: contain;
        }

        .logo-placeholder {
            width: 74px;
            height: 74px;
            border-radius: 50%;
            background: #15803d;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 13px;
            border: 3px double #facc15;
            text-align: center;
            line-height: 1.1;
        }

        .header-texts {
            display: flex;
            flex-direction: column;
        }

        .header-title-1 {
            font-size: 18px;
            font-weight: 800;
            color: #0284c7;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .header-title-2 {
            font-size: 16px;
            font-weight: 800;
            color: #15803d;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            line-height: 1.3;
            margin-bottom: 4px;
        }

        .header-prodi-line {
            font-size: 9.5px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            line-height: 1.4;
        }

        .header-code-box {
            border: 1.5px solid #334155;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
            white-space: nowrap;
            letter-spacing: 0.5px;
            margin-top: 5px;
        }

        /* Title Berita Acara */
        .doc-title-wrapper {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 28px;
        }

        .doc-title {
            font-size: 17px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0f172a;
            display: inline-block;
            border-bottom: 1.5px solid #0f172a;
            padding-bottom: 2px;
        }

        /* Kalimat Pengantar */
        .intro-text {
            font-size: 13.5px;
            color: #0f172a;
            line-height: 1.6;
            margin-bottom: 24px;
            text-align: justify;
        }

        /* Form Details Table */
        .form-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 16px;
            margin-bottom: 40px;
        }

        .form-table tr {
            vertical-align: top;
        }

        .form-label {
            width: 210px;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            padding-right: 12px;
            white-space: nowrap;
        }

        .form-colon {
            width: 15px;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            text-align: center;
        }

        .form-value-cell {
            padding-left: 8px;
        }

        .dotted-line-box {
            border-bottom: 1.5px dotted #475569;
            min-height: 22px;
            font-size: 13px;
            color: #0f172a;
            font-weight: 500;
            padding-bottom: 2px;
            width: 100%;
            display: block;
        }

        .dotted-multiline {
            width: 100%;
            line-height: 28px;
            background-image: linear-gradient(to bottom, transparent 26px, #64748b 27px, transparent 28px);
            background-size: 100% 28px;
            background-repeat: repeat-y;
            min-height: 56px;
            font-size: 13px;
            color: #0f172a;
            font-weight: 500;
            padding-top: 2px;
        }

        /* Signatures Section */
        .signatures-section {
            margin-top: auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            text-align: center;
            margin-bottom: 35px;
        }

        .sig-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .sig-title {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 60px;
        }

        .sig-space {
            height: 60px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sig-name {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 1px solid #94a3b8;
            padding: 0 8px 2px 8px;
            display: inline-block;
            min-width: 140px;
        }

        /* Footer Strip */
        .footer-banner {
            width: calc(100% + 36mm);
            margin-left: -18mm;
            margin-right: -18mm;
            margin-bottom: -14mm;
            background-color: #005fa3;
            color: #ffffff;
            padding: 6px 18mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        .footer-address {
            color: #f8fafc;
            opacity: 0.95;
        }

        .footer-url {
            color: #ffffff;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.4px;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print-toolbar {
                display: none !important;
            }

            .document-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                display: block !important;
            }

            .a4-sheet {
                box-shadow: none !important;
                width: 100% !important;
                height: 297mm !important;
                min-height: 297mm !important;
                max-height: 297mm !important;
                margin: 0 !important;
                padding: 14mm 16mm 10mm 16mm !important;
                page-break-after: always !important;
                break-after: page !important;
            }

            .a4-sheet:last-child {
                page-break-after: avoid !important;
                break-after: avoid !important;
            }

            .footer-banner {
                width: calc(100% + 32mm) !important;
                margin-left: -16mm !important;
                margin-right: -16mm !important;
                margin-bottom: -10mm !important;
                padding: 6px 16mm !important;
                background-color: #005fa3 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Screen Toolbar -->
    <div class="no-print-toolbar">
        <div class="title">
            <i class="fa-solid fa-file-contract text-sky-400"></i>
            <span>Berita Acara Praktikum (FTS-LAB-P03-F-01)</span>
            @if($totalItems > 1)
                <span style="font-size: 12px; font-weight: 500; opacity: 0.85; margin-left: 8px;">
                    • {{ $totalItems }} Pertemuan
                </span>
            @endif
        </div>
        <div class="actions">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fa-solid fa-print"></i> Cetak / Unduh PDF ({{ $totalItems > 1 ? $totalItems . ' Halaman A4' : 'A4' }})
            </button>
            <button onclick="window.close()" class="btn-action btn-close">
                <i class="fa-solid fa-xmark"></i> Tutup
            </button>
        </div>
    </div>

    <!-- Main Document Container -->
    <div class="document-wrapper">
        @foreach($items as $index => $item)
            @php
                $agenda = $item['agenda'];
                $details = $item['details'];
            @endphp
            <div class="a4-sheet">

                <!-- Watermark Background -->
                <div class="watermark-container">
                    <div class="watermark-text">I M A N . I L M U . A M A L</div>
                </div>

                <!-- Content Layer -->
                <div class="content-layer">
                    
                    <!-- Kop Surat Resmi -->
                    <div class="header-kop">
                        <div class="header-left">
                            <img src="https://commons.wikimedia.org/wiki/Special:FilePath/LOGO_UIKA_Terbaru2.png" 
                                 alt="Logo UIKA" 
                                 class="logo-uika"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="logo-placeholder" style="display: none;">
                            <span>UIKA<br>BOGOR</span>
                        </div>
                        <div class="header-texts">
                            <div class="header-title-1">FAKULTAS TEKNIK &amp; SAINS</div>
                            <div class="header-title-2">UNIVERSITAS IBN KHALDUN BOGOR</div>
                            <div class="header-prodi-line">SIPIL . MESIN . ELEKTRO . INFORMATIKA . ILMU LINGKUNGAN</div>
                            <div class="header-prodi-line">SISTEM INFORMASI . REKAYASA PERTANIAN DAN BIOSISTEM</div>
                        </div>
                    </div>
                    <div class="header-code-box">
                        FTS-LAB-P03-F-01
                    </div>
                </div>

                <!-- Judul Dokumen -->
                <div class="doc-title-wrapper">
                    <h1 class="doc-title">BERITA ACARA PRAKTIKUM</h1>
                </div>

                <!-- Teks Pengantar Pelaksanaan -->
                <div class="intro-text">
                    Telah Dilaksanakan Praktikum <strong>{{ $agenda->mata_kuliah }}</strong> Semester <strong>{{ $agenda->semester ?? 'IV' }}</strong> TA <strong>{{ $details['tahun_ajaran'] ?? '2025/2026' }}</strong>
                </div>

                <!-- Tabel Isian Formulir -->
                <table class="form-table">
                    <tr>
                        <td class="form-label">Hari / Tanggal</td>
                        <td class="form-colon">:</td>
                        <td class="form-value-cell">
                            <span class="dotted-line-box">{{ $details['hari_tanggal_indo'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Waktu / Durasi</td>
                        <td class="form-colon">:</td>
                        <td class="form-value-cell">
                            <span class="dotted-line-box">{{ $details['waktu_durasi'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Program Studi / Semester</td>
                        <td class="form-colon">:</td>
                        <td class="form-value-cell">
                            <span class="dotted-line-box">{{ $details['prodi_semester_kelas'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Materi</td>
                        <td class="form-colon">:</td>
                        <td class="form-value-cell">
                            <div class="dotted-multiline">
                                {{ $details['materi'] ?: '-' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Catatan</td>
                        <td class="form-colon">:</td>
                        <td class="form-value-cell">
                            <div class="dotted-multiline">
                                {{ $details['catatan'] ?: '-' }}
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- Tiga Kolom Tanda Tangan -->
                <div class="signatures-section">
                    <!-- 1. Laboran -->
                    <div class="sig-box">
                        <div class="sig-title">Laboran</div>
                        <div class="sig-space"></div>
                        <div class="sig-name">{{ $details['laboran'] }}</div>
                    </div>

                    <!-- 2. Asisten Praktikum -->
                    <div class="sig-box">
                        <div class="sig-title">Asissten Praktikum</div>
                        <div class="sig-space"></div>
                        <div class="sig-name">{{ $details['asisten'] }}</div>
                    </div>

                    <!-- 3. Dosen / Instruktur -->
                    <div class="sig-box">
                        <div class="sig-title">Dosen / Instruktur</div>
                        <div class="sig-space"></div>
                        <div class="sig-name">{{ $details['dosen'] }}</div>
                    </div>
                </div>

            </div>

            <!-- Footer Strip Biru FT UIKA -->
            <div class="footer-banner">
                <span class="footer-address">
                    Ibn Khaldun Bogor : Jalan KH. Sholeh Iskandar KM. 2, Tanah Sareal, Kedung Badak, Bogor, Jawa Barat 16164
                </span>
                <span class="footer-url">
                    www.ft.uika-bogor.ac.id
                </span>
            </div>

        </div>
        @endforeach
    </div>

</body>
</html>
