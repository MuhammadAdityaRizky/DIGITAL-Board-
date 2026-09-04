<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$data = Maatwebsite\Excel\Facades\Excel::toArray(new class implements Maatwebsite\Excel\Concerns\ToArray {
    public function array(array $array): void {}
}, 'data excel/Format_Form_Agenda_Praktikum.xlsx');

echo json_encode(array_slice($data[0], 0, 15), JSON_PRETTY_PRINT);
