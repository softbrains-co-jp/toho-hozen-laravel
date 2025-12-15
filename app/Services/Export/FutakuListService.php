<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Maintenance;
use App\Models\MstUser;

class FutakuListService
{
    public function makeExcel($from, $to, $user) {
        // Excel 読み込み（Excel95 = Xls）
        $spreadsheet = IOFactory::load(resource_path('excel/template/futaku-list.xls'));
        $sheet = $spreadsheet->getActiveSheet();

        // セルに日付セット
        $sheet->setCellValue('C4', date('Y/m/d', strtotime($from)));
        $sheet->setCellValue('D4', date('Y/m/d', strtotime($to)));

        $maintenances = Maintenance::with([
                'branch',
                'trader'
            ])
            ->where(function ($q) use ($from, $to) {
                $q->whereBetween('conduct_commit_date', [$from, $to])
                ->orWhereBetween('commit_date', [$from, $to]);
            })
            ->when($user->role == MstUser::ROLE_USER, function ($q) use ($user) {
                $q->where('trader_cd', substr($user->login_id, 0, 3));
            })
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 6;

        foreach ($maintenances as $maintenance) {
            $sheet->setCellValue([2, $rowNo], $maintenance->kddi_cd);
            $sheet->setCellValue([3, $rowNo], $maintenance->conduct_commit_date?->format('Y/m/d'));
            $sheet->setCellValue([4, $rowNo], $maintenance->commit_date?->format('Y/m/d'));
            $sheet->setCellValue([5, $rowNo], $maintenance->trader?->name);
            $sheet->setCellValue([6, $rowNo], $maintenance->branch?->name);

            $rowNo++;
        }

        return $spreadsheet;
    }
}
