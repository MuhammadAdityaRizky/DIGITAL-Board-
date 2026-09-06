<?php
require 'vendor/autoload.php';
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile('c:\\apk\\laragon\\www\\digital board\\data excel\\Format_Form_Agenda_Praktikum.xlsx');
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load('c:\\apk\\laragon\\www\\digital board\\data excel\\Format_Form_Agenda_Praktikum.xlsx');
$worksheet = $spreadsheet->getActiveSheet();
$rows = $worksheet->toArray();

$headerRowIndex = 2;
$colIndexMap = [
    'materi' => 3,
    'tanggal' => 11,
    'waktu' => 12
];

function findDosenByName($name) {
    return false; // stub
}

$startIdx = $headerRowIndex + 1;
for ($i = $startIdx; $i < count($rows); $i++) {
    $rowArray = array_map('strval', $rows[$i]);
    $valMateri = $rowArray[$colIndexMap['materi']] ?? null;
    $valTanggal = $rowArray[$colIndexMap['tanggal']] ?? null;
    $valWaktu = $rowArray[$colIndexMap['waktu']] ?? null;

    $metaMataKuliah = null;
    $finalMataKuliah = $metaMataKuliah;
    if ($valMateri) {
        if ($metaMataKuliah && stripos($valMateri, $metaMataKuliah) === false) {
            $finalMataKuliah = $metaMataKuliah . ' (' . $valMateri . ')';
        } elseif (!$metaMataKuliah) {
            $finalMataKuliah = $valMateri;
        }
    }

    if (!$finalMataKuliah || findDosenByName($finalMataKuliah)) {
        echo "Row $i skipped: empty finalMataKuliah or matches dosen\n";
        continue;
    }

    echo "Row $i processed successfully! finalMataKuliah=$finalMataKuliah\n";
}
