<?php
require 'vendor/autoload.php';
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile('c:\\apk\\laragon\\www\\digital board\\data excel\\Bikin yg ada coretan nya absen.xlsx');
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load('c:\\apk\\laragon\\www\\digital board\\data excel\\Bikin yg ada coretan nya absen.xlsx');
$worksheet = $spreadsheet->getActiveSheet();
$rows = $worksheet->toArray();

for ($i = 0; $i < min(15, count($rows)); $i++) {
    echo "Row $i: " . json_encode($rows[$i]) . "\n";
}
