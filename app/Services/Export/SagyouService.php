<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Maintenance;

class SagyouService
{
    public function makeExcel($date) {
        /** ============================
         * Excel テンプレート読み込み
         * ============================ */
        $spreadsheet = IOFactory::load(
            resource_path('excel/template/sagyou.xls')
        );
        $sheet = $spreadsheet->getActiveSheet();

        // 日付セット
        $sheet->setCellValue('G3', date('Y/m/d', strtotime($date)));

        /** ============================
         * データ取得（Eloquent）
         * ============================ */
        $maintenances = Maintenance::with([
                'trader',
                'kddiReportType',
                'conductStartMember',
                'conductEndMember',
                'tSetupStartMember',
                'tSetupFinishMember',
                'setupStartMember',
                'setupFinishMember',
            ])
            ->where(function ($q) use ($date) {
                $q->whereDate('work_plan_date', $date)
                ->orWhereDate('conduct_plan_date', $date)
                ->orWhereDate('t_setup_plan_date', $date);
            })
            ->orderBy('toh_cd')
            ->get();

        /** ============================
         * Excel 出力
         * ============================ */
        $rowNo = 5; // i + 4
        $i = 1;

        foreach ($maintenances as $m) {

            $content = '';
            $startTime = '';
            $startMember = '';
            $endTime = '';
            $endMember = '';

            // 現場調査
            if ($m->conduct_plan_date?->isSameDay($date)) {
                $content = '現場調査';
                $startTime = $m->conduct_start_datetime;
                $startMember = optional($m->conductStartMember)->name;
                $endTime = $m->conduct_end_datetime;
                $endMember = optional($m->conductEndMember)->name;
            }

            // 仮工事
            if ($m->t_setup_plan_date?->isSameDay($date)) {
                $content = '仮工事';
                $startTime = $m->t_setup_start_datetime;
                $startMember = optional($m->tSetupStartMember)->name;
                $endTime = $m->t_setup_end_datetime;
                $endMember = optional($m->tSetupFinishMember)->name;
            }

            // 本工事
            if ($m->work_plan_date?->isSameDay($date)) {
                $content = '本工事';
                $startTime = $m->work_start_datetime;
                $startMember = optional($m->setupStartMember)->name;
                $endTime = $m->work_end_datetime;
                $endMember = optional($m->setupFinishMember)->name;
            }

            // Excel 1899 ゴミ削除
            $startTime = str_replace('1899/12/30 ', '', (string)$startTime);
            $endTime   = str_replace('1899/12/30 ', '', (string)$endTime);

            // 書き込み
            $sheet->setCellValue([1, $rowNo], $i);
            $sheet->setCellValue([2, $rowNo], $m->kddi_cd);
            $sheet->setCellValue([3, $rowNo], $content);
            $sheet->setCellValue([4, $rowNo], $m->notes);
            $sheet->setCellValue([8, $rowNo], $startTime);
            $sheet->setCellValue([9, $rowNo], $startMember);
            $sheet->setCellValue([10, $rowNo], $endTime);
            $sheet->setCellValue([11, $rowNo], $endMember);
            $sheet->setCellValue([12, $rowNo], $m->trader?->name);
            $sheet->setCellValue([13, $rowNo], $m->kddiReportType?->name);

            $rowNo++;
            $i++;
        }

        return $spreadsheet;
    }
}
