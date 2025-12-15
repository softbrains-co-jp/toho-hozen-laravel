<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

use App\Models\Maintenance;
use App\Models\MstUser;

class ShunkouListService
{
    public function makeExcel() {
        $spreadsheet = IOFactory::load(resource_path('excel/template/shunkou-list.xls'));
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('H3', now()->format('Y/m/d'));

        $maintenances = Maintenance::with(['branch', 'trader', 'status'])
            ->where('status_cd', '07') // 写真提出待ち
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 5;

        foreach ($maintenances as $m) {
            $sheet->setCellValue([1, $rowNo], $rowNo - 4);
            $sheet->setCellValue([2, $rowNo], $m->kddi_cd);
            $sheet->setCellValue([3, $rowNo], $m->kddi_oder_date?->format('Y/m/d'));
            $sheet->setCellValue([4, $rowNo], $m->conduct_action_date?->format('Y/m/d'));
            $sheet->setCellValue([5, $rowNo], $m->t_setup_action_date?->format('Y/m/d'));
            $sheet->setCellValue([6, $rowNo], $m->work_action_date?->format('Y/m/d'));
            $sheet->setCellValue([7, $rowNo], $m->trader?->name);
            $sheet->setCellValue([8, $rowNo], $m->branch?->name);
            $sheet->setCellValue([9, $rowNo], $m->status?->name);

            $rowNo++;
        }

        return $spreadsheet;
    }
}
