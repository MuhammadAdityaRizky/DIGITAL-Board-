<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Templates\MahasiswaTemplateExport;
use App\Exports\Templates\DosenTemplateExport;
use App\Exports\Templates\LaboratoriumTemplateExport;
use App\Exports\Templates\FakultasTemplateExport;
use App\Exports\Templates\ProdiTemplateExport;
use App\Exports\Templates\KelasTemplateExport;
use App\Exports\Templates\AgendaTemplateExport;
use App\Exports\Templates\AbsensiGlobalTemplateExport;

class TemplateController extends Controller
{
    public function download($type)
    {
        switch ($type) {
            case 'mahasiswa':
                return Excel::download(new MahasiswaTemplateExport, 'Template_Import_Mahasiswa.xlsx');
            case 'dosen':
                return Excel::download(new DosenTemplateExport, 'Template_Import_Dosen.xlsx');
            case 'laboratorium':
                return Excel::download(new LaboratoriumTemplateExport, 'Template_Import_Laboratorium.xlsx');
            case 'fakultas':
                return Excel::download(new FakultasTemplateExport, 'Template_Import_Fakultas.xlsx');
            case 'prodi':
                return Excel::download(new ProdiTemplateExport, 'Template_Import_Prodi.xlsx');
            case 'kelas':
                return Excel::download(new KelasTemplateExport, 'Template_Import_Kelas.xlsx');
            case 'agenda':
                return Excel::download(new AgendaTemplateExport, 'Template_Import_Agenda.xlsx');
            case 'absensi':
                return Excel::download(new AbsensiGlobalTemplateExport, 'Template_Import_Absensi.xlsx');
            default:
                abort(404, 'Template tidak ditemukan.');
        }
    }
}
