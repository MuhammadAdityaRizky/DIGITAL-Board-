<?php
require "vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;

$dir = __DIR__ . "/data excel";
$files = glob($dir . "/Format Absensi*.xlsx");

$out = fopen($dir . "/import_mahasiswa_gabungan.csv", "w");
fputcsv($out, ["NIM", "Nama", "Prodi", "Kelas", "Angkatan"]);

$count = 0;
foreach ($files as $file) {
    $angkatan = "";
    if (preg_match("/Angkatan\s+(\d{4})/i", $file, $m)) {
        $angkatan = $m[1];
    }
    
    $kelas_raw = "";
    if (preg_match("/Perkuliahan_(.+?)_Angkatan/i", basename($file), $m)) {
        $kelas_raw = trim($m[1]);
    }
    
    // Remove Roman numerals like III, V, VII, VIII
    $kelas = preg_replace("/^(I{1,3}|IV|V|VI{1,3}|IX|X|XI|XII)\s+/i", "", $kelas_raw);
    
    // Normalize names
    if (strtoupper($kelas) === "REG") $kelas = "Reguler";
    if (strtoupper($kelas) === "KAR") $kelas = "Karyawan";
    if (strtoupper($kelas) === "REG A") $kelas = "Reguler A";
    if (strtoupper($kelas) === "REG B") $kelas = "Reguler B";
    if (strtoupper($kelas) === "REG C") $kelas = "Reguler C";
    if (strtoupper($kelas) === "KAR A") $kelas = "Karyawan A";
    if (strtoupper($kelas) === "KAR B") $kelas = "Karyawan B";
    
    echo "Processing " . basename($file) . " -> Kelas mapped to: " . $kelas . "\n";
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();
    
    $prodi = $rows[5][1] ?? "";
    
    foreach ($rows as $index => $row) {
        if ($index < 13) continue;
        
        $nim = trim((string)($row[2] ?? ""));
        $nama = trim((string)($row[3] ?? ""));
        
        if (empty($nim) || empty($nama)) continue;
        
        $nim = str_replace(" ", "", $nim);
        if (!is_numeric($nim)) continue;
        
        fputcsv($out, [$nim, $nama, $prodi, $kelas, $angkatan]);
        $count++;
    }
}
fclose($out);
echo "Selesai! $count mahasiswa berhasil diekstrak ke import_mahasiswa_gabungan.csv\n";

