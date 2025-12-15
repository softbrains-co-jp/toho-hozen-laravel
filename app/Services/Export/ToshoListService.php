<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

use App\Models\Maintenance;
use App\Models\MstUser;

class ToshoListService
{
    public function makeExcel($from, $to) {
        $from = new Carbon($from);
        $to = new Carbon($to);
        $spreadsheet = IOFactory::load(resource_path('excel/template/tosho-list.xls'));
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
                'apply',
                'checkMember',
            ])
            ->where('kddi_oder_date', '>=', $from)
            ->where('kddi_oder_date', '<=', $to)
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 2; // Excel 行番号調整

        foreach ($maintenances as $m) {
            $sheet->setCellValue([1, $rowNo], $m->toh_cd);
            $sheet->setCellValue([2, $rowNo], $m->apply?->name);
            $sheet->setCellValue([3, $rowNo], $m->add_order_date?->format('Y/m/d'));
            $sheet->setCellValue([4, $rowNo], $m->add_receive_date?->format('Y/m/d'));
            $sheet->setCellValue([5, $rowNo], $m->add_design_receive_date?->format('Y/m/d'));
            $sheet->setCellValue([6, $rowNo], $m->cancel_order_date?->format('Y/m/d'));
            $sheet->setCellValue([7, $rowNo], $m->cancel_report_receive_date?->format('Y/m/d'));
            $sheet->setCellValue([8, $rowNo], $m->cancel_design_receive_date?->format('Y/m/d'));
            $sheet->setCellValue([9, $rowNo], $m->apply_notes);
            $sheet->setCellValue([10, $rowNo], $m->trader?->name);
            $sheet->setCellValue([11, $rowNo], $m->check_date?->format('Y/m/d'));
            $sheet->setCellValue([12, $rowNo], $m->checkMember?->name);
            $sheet->setCellValue([13, $rowNo], $m->check_notes);
            $sheet->setCellValue([14, $rowNo], $m->gemini_order_date?->format('Y/m/d'));
            $sheet->setCellValue([15, $rowNo], $m->kddi_month);

            // 罫線適用
            for ($col = 1; $col <= 15; $col++) {
                $sheet->getStyle([$col, $rowNo])
                    ->applyFromArray($borderStyle);
            }

            $rowNo++;
        }

        return $spreadsheet;
    }
}
