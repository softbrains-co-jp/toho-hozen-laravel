<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

use App\Models\Maintenance;
use App\Models\MstUser;

class ChokkinListService
{
    public function makeExcel($from, $to, $user) {
        $from = new Carbon($from);
        $to = new Carbon($to);
        $traderPrefix = $user->role == MstUser::ROLE_USER ? substr($user->login_id, 0, 3) : null;

        $spreadsheet = IOFactory::load(resource_path('excel/template/chokkin-list.xls'));
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('C3', $from->format('Y/m/d'));
        $sheet->setCellValue('D3', $to->format('Y/m/d'));

        $maintenances = Maintenance::with(['branch', 'trader'])
            ->where(function ($q) use ($from, $to) {
                $q->whereBetween('term_end_date', [$from, $to])
                    ->orWhereBetween('term2_end_date', [$from, $to])
                    ->orWhereBetween('t_term_end_date', [$from, $to])
                    ->orWhereBetween('t_term2_end_date', [$from, $to]);
            })
            ->when($traderPrefix, fn($q) => $q->where('trader_cd', 'like', $traderPrefix . '%'))
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 5; // Excel 行番号調整

        foreach ($maintenances as $m) {
            [$content, $kariDate, $honDate] = $this->getWorkPeriods($m, $from, $to);

            // 工事内容がなければスキップ
            if ($content === '') {
                continue;
            }

            $sheet->setCellValue([1, $rowNo], $rowNo);
            $sheet->setCellValue([2, $rowNo], $m->kddi_cd);
            $sheet->setCellValue([3, $rowNo], $content);
            $sheet->setCellValue([4, $rowNo], $kariDate);
            $sheet->setCellValue([5, $rowNo], $honDate);
            $sheet->setCellValue([6, $rowNo], $m->trader?->name);
            $sheet->setCellValue([7, $rowNo], $m->branch?->name);

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
