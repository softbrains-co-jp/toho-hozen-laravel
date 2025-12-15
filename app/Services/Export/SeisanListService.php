<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

use App\Models\Maintenance;
use App\Models\MstUser;

class SeisanListService
{
    public function makeExcel($date) {
        $spreadsheet = IOFactory::load(resource_path('excel/template/seisan-list.xls'));
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
                'setup',
                'status',
                'checkMember',
            ])
            ->where('kddi_month', $date)
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 2; // Excel 行番号調整

        foreach ($maintenances as $m) {
            $sheet->setCellValue([1, $rowNo], $m->toh_cd);
            $sheet->setCellValue([2, $rowNo], $m->work_address);
            $sheet->setCellValue([3, $rowNo], $m->kddi_oder_date?->format('Y/m/d'));
            $sheet->setCellValue([4, $rowNo], $m->trader?->name);
            $sheet->setCellValue([5, $rowNo], $m->branch?->name);
            $sheet->setCellValue([6, $rowNo], $m->setup?->name);
            $sheet->setCellValue([7, $rowNo], $m->status?->name);
            $sheet->setCellValue([8, $rowNo], $m->check_date?->format('Y/m/d'));
            $sheet->setCellValue([9, $rowNo], $m->checkMember?->name);
            $sheet->setCellValue([10, $rowNo], $m->check_notes);
            $sheet->setCellValue([11, $rowNo], $m->complete_report_date?->format('Y/m/d'));
            $sheet->setCellValue([12, $rowNo], $m->complete_stop_flg === '1' ? '待ち' : '');

            // 罫線適用（1〜12列）
            for ($col = 1; $col <= 12; $col++) {
                $sheet->getStyle([$col, $rowNo])
                    ->applyFromArray($borderStyle);
            }

            $rowNo++;
        }

        return $spreadsheet;
    }
}
