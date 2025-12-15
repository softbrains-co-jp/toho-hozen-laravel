<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

use App\Models\Maintenance;
use App\Models\MstUser;

class NippouKddiService
{
    public function makeExcel($date) {
        $date = new Carbon($date);
        $spreadsheet = IOFactory::load(resource_path('excel/template/nippou-kddi.xls'));
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('J2', $date->format('Y/m/d'));

        $maintenances = Maintenance::with(['trader'])
            ->whereDate('work_plan_date', $date)
            ->orWhereDate('conduct_plan_date', $date)
            ->orWhereDate('t_setup_plan_date', $date)
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 5;

        foreach ($maintenances as $m) {
            $kubun = $this->getKubun($m->toh_cd);
            $yoteibi = $this->getYoteibi($m, $date);
            $stopTime = $this->getStopTime($m);
            $ampm = $this->getAmpm($m);
            $hancho = $this->getHancho($m);
            $stopCircuitFlg = $m->stop_circuit_flg === '01' ? '有' : ($m->stop_circuit_flg === '02' ? '無' : '');
            $mcOpenFlg = $m->mc_open_flg === '01' ? '有' : ($m->mc_open_flg === '02' ? '無' : '');
            $workAddress = $this->cleanWorkAddress($m->work_address);

            $sheet->setCellValue([2, $rowNo], $rowNo-4);
            $sheet->setCellValue([3, $rowNo], $kubun);
            $sheet->setCellValue([4, $rowNo], $yoteibi?->format('Y/m/d'));
            $sheet->setCellValue([5, $rowNo], $stopCircuitFlg);
            $sheet->setCellValue([6, $rowNo], $stopTime);
            $sheet->setCellValue([7, $rowNo], $m->toh_cd);
            $sheet->setCellValue([8, $rowNo], $ampm);
            $sheet->setCellValue([9, $rowNo], $hancho);
            $sheet->setCellValue([10, $rowNo], '東邦電気工業');
            $sheet->setCellValue([11, $rowNo], $m->trader?->name);
            $sheet->setCellValue([12, $rowNo], $workAddress);
            $sheet->setCellValue([13, $rowNo], $mcOpenFlg);
            $sheet->setCellValue([14, $rowNo], $m->pole_cd);

            $rowNo++;
        }

        return $spreadsheet;
    }

    private function getKubun(string $tohCd): string
    {
        if (str_starts_with($tohCd, 'S')) return '移設';
        if (str_starts_with($tohCd, 'KY')) return '拠移';
        return '';
    }

    private function getYoteibi($m, Carbon $date): ?Carbon
    {
        foreach (['conduct_plan_date', 't_setup_plan_date', 'work_plan_date'] as $field) {
            if ($m->$field) return Carbon::parse($m->$field);
        }
        return null;
    }

    private function getStopTime($m): string
    {
        return $m->stop_gepon_time ?: $m->stop_100m_time ?: '';
    }

    private function getAmpm($m): string
    {
        $ampm = [
            'AM' => '午前',
            'PM' => '午後',
        ];

        $time_cd =  $m->work_plan_time_cd ?: $m->t_setup_plan_time_cd ?: $m->conduct_time_cd ?: '';

        return $ampm[$time_cd] ?? '';
    }

    private function getHancho($m): string
    {
        return $m->setup_member_name ?: $m->t_setup_member_name ?: $m->conduct_member_name ?: '';
    }

    private function cleanWorkAddress(?string $address): string
    {
        if (!$address) return '';
        return str_replace('\\', '', $address); // delete_yen 相当
    }
}
