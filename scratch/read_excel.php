<?php
require 'vendor/autoload.php';
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile('c:\\apk\\laragon\\www\\digital board\\data excel\\Format_Form_Agenda_Praktikum.xlsx');
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load('c:\\apk\\laragon\\www\\digital board\\data excel\\Format_Form_Agenda_Praktikum.xlsx');
$worksheet = $spreadsheet->getActiveSheet();
$rows = $worksheet->toArray();

$headerRowIndex = null;
$colIndexMap = [];
foreach ($rows as $idx => $r) {
    $arr = array_map('strval', $r);
    foreach ($arr as $colIdx => $val) {
        $valClean = strtolower(trim($val));
        if (in_array($valClean, ['materi', 'materi praktikum', 'mata kuliah', 'matakuliah', 'judul', 'judul agenda', 'course', 'subject', 'mata kuliah / judul agenda'])) {
            $headerRowIndex = $idx;
            $colIndexMap['materi'] = $colIdx;
        } elseif (in_array($valClean, ['tanggal', 'hari / tanggal', 'hari/tanggal', 'tgl', 'date', 'tanggal praktikum'])) {
            $colIndexMap['tanggal'] = $colIdx;
        } elseif (in_array($valClean, ['waktu', 'jam', 'waktu / jam', 'jam_mulai', 'waktu_masuk', 'time', 'jam mulai'])) {
            $colIndexMap['waktu'] = $colIdx;
        }
    }
    if ($headerRowIndex !== null) break;
}
echo "Header Row: $headerRowIndex\n";
print_r($colIndexMap);

$startIdx = $headerRowIndex + 1;
for ($i = $startIdx; $i < count($rows); $i++) {
    $rowArray = array_map('strval', $rows[$i]);
    $valMateri = isset($colIndexMap['materi']) ? ($rowArray[$colIndexMap['materi']] ?? null) : null;
    $valTanggal = isset($colIndexMap['tanggal']) ? ($rowArray[$colIndexMap['tanggal']] ?? null) : null;
    $valWaktu = isset($colIndexMap['waktu']) ? ($rowArray[$colIndexMap['waktu']] ?? null) : null;
    echo "Row $i: Materi=$valMateri, Tanggal=$valTanggal, Waktu=$valWaktu\n";
}
