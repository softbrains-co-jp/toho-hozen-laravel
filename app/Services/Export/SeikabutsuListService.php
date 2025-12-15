<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

use App\Models\Maintenance;
use App\Models\MstUser;

class SeikabutsuListService
{
    public function makeExcel($tohCds) {
        $spreadsheet = IOFactory::load(resource_path('excel/template/seikabutsu-list.xls'));
        $sheet = $spreadsheet->getActiveSheet();

        // 罫線スタイル
        $borderStyle = [
            'borders' => [
                'top'    => ['borderStyle' => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left'   => ['borderStyle' => Border::BORDER_THIN],
                'right'  => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];

        // データ取得（Eloquent）
        $maintenances = Maintenance::query()
            ->with([
                'status',
            ])
            ->whereIn('toh_cd', $tohCds)
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 2; // Excel 行番号調整

        foreach ($maintenances as $m) {
            $sheet->setCellValue([1, $rowNo], $m->toh_cd);
            $sheet->setCellValue([2, $rowNo], $m->kddi_oder_date?->format('Y/m/d'));
            $sheet->setCellValue([3, $rowNo], $m->status?->name);
            $sheet->setCellValue([4, $rowNo], $m->conduct_receive_date?->format('Y/m/d'));
            $sheet->setCellValue([5, $rowNo], $m->t_work_receive_date?->format('Y/m/d'));
            $sheet->setCellValue([6, $rowNo], $m->complete_design_receive_date?->format('Y/m/d'));
            $sheet->setCellValue([7, $rowNo], $m->complete_report_date?->format('Y/m/d'));
            $sheet->setCellValue([8, $rowNo], $m->complete_notes);
            $sheet->setCellValue([9, $rowNo], $m->kddi_month);

            // 罫線適用
            for ($col = 1; $col <= 9; $col++) {
                $sheet->getStyle([$col, $rowNo])
                    ->applyFromArray($borderStyle);
            }

            $rowNo++;
        }

        return $spreadsheet;
    }
}
