<?php require 'vendor/autoload.php'; $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('data excel/Format Absensi Perkuliahan_VIII Reg_Angkatan 2022.xlsx'); $worksheet = $spreadsheet->getActiveSheet(); $rows = $worksheet->toArray();
$prodi = '';
$kelas = '';
$angkatan = '';
foreach($rows as $index => $row) {
    foreach($row as $cidx => $cell) {
        if ($cidx == 1 && str_contains(strtoupper((string)$cell), 'SISTEM INFORMASI')) {
            // Wait, I can't hardcode SISTEM INFORMASI. But row 5 has 'SISTEM INFORMASI' or similar. 
        }
    }
}

