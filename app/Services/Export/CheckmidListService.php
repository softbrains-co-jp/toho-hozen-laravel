<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

use App\Models\Maintenance;
use App\Models\MstUser;

class CheckmidListService
{
    public function makeExcel($checkMcd) {
        $spreadsheet = IOFactory::load(resource_path('excel/template/checkmid-list.xls'));
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
                'trader',
                'branch',
                'checkMember',
            ])
            ->where('check_mcd', $checkMcd)
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 2; // Excel 行番号調整

        foreach ($maintenances as $m) {
            $sheet->setCellValue([1, $rowNo], $m->toh_cd);
            $sheet->setCellValue([2, $rowNo], $m->trader?->name);
            $sheet->setCellValue([3, $rowNo], $m->branch?->name);
            $sheet->setCellValue([4, $rowNo], $m->check_date?->format('Y/m/d'));
            $sheet->setCellValue([5, $rowNo], $m->checkMember?->name);
            $sheet->setCellValue([6, $rowNo], $m->check_notes);

            // 罫線適用
            for ($col = 1; $col <= 6; $col++) {
                $sheet->getStyle([$col, $rowNo])
                    ->applyFromArray($borderStyle);
            }

            $rowNo++;
        }

        return $spreadsheet;
    }
}
