<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Carbon\Carbon;

use App\Models\Maintenance;
use App\Models\MstUser;

class IsetsuListService
{
    public function makeExcel($date) {
        $date = new Carbon($date);

        $spreadsheet = IOFactory::load(resource_path('excel/template/isetsu-list.xlsx'));
        $sheet = $spreadsheet->getActiveSheet();

        $maintenances = Maintenance::query()
            ->with([
                'trader'
            ])
            ->where(function ($q) use ($date) {
                $q->whereDate('conduct_plan_date', $date)
                    ->orWhereDate('t_setup_plan_date', $date)
                    ->orWhereDate('work_plan_date', $date);
            })
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 5; // Excel 行番号調整

        foreach ($maintenances as $m) {
            if (substr($m->toh_cd, 0, 1) !== 'S') continue;

            $shubetsu = '';
            $houkoku = '';

            $num = intval(substr($m->toh_cd, 7, 4));
            if ($num < 2000) {
                $shubetsu = 'TE';
                $houkoku = '不要';
            } elseif ($num >= 3000 && $num < 8000) {
                $shubetsu = 'HK';
                $houkoku = '不要';
            }

            $content = '';
            if ($m->conduct_plan_date == $date) $content = '現場調査';
            if ($m->t_setup_plan_date == $date) $content = '仮改修';
            if ($m->work_plan_date == $date) $content = '本改修';


            $sheet->setCellValue([1, $rowNo], $rowNo - 4);
            $sheet->setCellValueExplicit([2, $rowNo], substr($m->toh_cd, 0, 3), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit([3, $rowNo], substr($m->toh_cd, 4, 2), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit([4, $rowNo], substr($m->toh_cd, 7, 4), DataType::TYPE_STRING);
            $sheet->setCellValue([5, $rowNo], $shubetsu);
            $sheet->setCellValue([6, $rowNo], $content);

            if ($content === '仮改修') {
                $sheet->setCellValue([7, $rowNo], $m->t_setup_plan_date ? date('Y/m/d', strtotime($m->t_setup_plan_date)) : '');
                $sheet->setCellValue([8, $rowNo], '');
                $sheet->setCellValue([9, $rowNo], $houkoku);
            } else { // 本改修 or 現場調査
                $dateVal = $m->work_plan_date ?: $m->conduct_plan_date;
                $sheet->setCellValue([11, $rowNo], $dateVal ? date('Y/m/d', strtotime($dateVal)) : '');
                $sheet->setCellValue([12, $rowNo], '');
                $sheet->setCellValue([13, $rowNo], $houkoku);
            }

            $sheet->setCellValueExplicit([16, $rowNo], $m->toh_cd, DataType::TYPE_STRING);

            $rowNo++;
        }

        return $spreadsheet;
    }

    /**
     * 仮工期・本工期判定
     */
    private function getWorkPeriods($m, Carbon $from, Carbon $to): array
    {
        $kariDate = '';
        $honDate = '';
        $content = '';

        // 仮工期
        if (!$m->t_setup_action_date) {
            $kariEnd = $m->t_term2_end_date ?? $m->t_term_end_date;
            if ($kariEnd && $kariEnd->between($from, $to)) {
                $kariDate = $kariEnd->format('Y/m/d');
            }
        }

        // 本工期
        if (!$m->work_action_date) {
            $honEnd = $m->term2_end_date ?? $m->term_end_date;
            if ($honEnd && $honEnd->between($from, $to)) {
                $honDate = $honEnd->format('Y/m/d');
            }
        }

        // 工事内容判定
        if ($kariDate && $honDate) {
            $content = '仮・本工事';
        } elseif (!$kariDate && $honDate) {
            $content = '本工事';
        } elseif ($kariDate && !$honDate) {
            $content = '仮工事';
        }

        return [$content, $kariDate, $honDate];
    }
}
