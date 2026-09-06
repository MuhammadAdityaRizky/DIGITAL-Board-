<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AgendaImport;

class TestImport extends Command
{
    protected $signature = 'test:import';
    protected $description = 'Test import agenda';

    public function handle()
    {
        $file = 'c:\\apk\\laragon\\www\\digital board\\data excel\\Format_Form_Agenda_Praktikum.xlsx';
        $import = new AgendaImport();
        
        try {
            Excel::import($import, $file);
            $this->info("Imported count: " . $import->importedCount);
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
