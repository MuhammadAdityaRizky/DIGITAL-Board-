<?php
$files = glob('app/Exports/Templates/*.php');

foreach($files as $file) {
    if (strpos($file, 'MahasiswaTemplateExport') !== false) {
        $content = file_get_contents($file);
        $content = preg_replace('/\$prodis = Prodi::pluck\(\'nama_prodi\'\)->toArray\(\);\s*if \(\!empty\(\$prodis\)\) \{.*?\}/s', 
            '$prodis = Prodi::pluck(\'nama_prodi\')->toArray();
                if (!empty($prodis)) {
                    $row = 1;
                    foreach($prodis as $p) {
                        $event->sheet->getDelegate()->setCellValue(\'AA\' . $row, $p);
                        $row++;
                    }
                    $event->sheet->getDelegate()->getColumnDimension(\'AA\')->setVisible(false);

                    $validation = $event->sheet->getDelegate()->getCell(\'E2\')->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle(\'Prodi tidak valid\');
                    $validation->setError(\'Harap pilih Prodi dari daftar dropdown.\');
                    $validation->setPromptTitle(\'Pilih Prodi\');
                    $validation->setPrompt(\'Pilih nama Prodi dari daftar.\');
                    $validation->setFormula1(\'=$AA$1:$AA$\' . ($row - 1));

                    $event->sheet->getDelegate()->setDataValidation(\'E2:E1000\', $validation);
                }', $content);
        file_put_contents($file, $content);
    }
}
