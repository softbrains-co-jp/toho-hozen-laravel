<?php

namespace App\Services\Export;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

use App\Models\Maintenance;
use App\Models\MstUser;

class CheckListService
{
    public function makeExcel($date) {
        $date = new Carbon($date);
        $spreadsheet = IOFactory::load(resource_path('excel/template/check-list.xls'));
        $sheet = $spreadsheet->getActiveSheet();

        // ヘッダ設定（列番号は 1 から始める）
        $headers = [
            'KDDI管理番号','KDDI依頼日','工事付託日','支社','作業内容','指示内容','現場住所',
            '本工期（自）','本工期（至）','本工期備考','本工期（自）変更後','本工期（至）変更後','仮工期備考',
            '仮工期（至）','仮移設実施日','作業予定日','作業実施日','施工業者','回線停止有無','停止予定日',
            '工事完了報告日','竣工報告日','電線設備変更依頼書送信日','竣工備考','備考','仮移設予定日',
            '現場調査予定日','現場調査実施日','竣工処理待ち','KDDI精算月','契約種別','停止番号1',
            '停止番号2','停止番号3','停止番号4','停止番号5','停止実施日','作業開始時間','作業終了時間',
            '本移設終了受信者','KDDI確認依頼日','KDDI報告内容','竣工図書受領日','KDDI報告種別','TOH管理番号',
            '建柱確認日1','建柱確認日2','建柱確認日3','依頼種別','仮移設作業開始時間','仮移設作業終了時間',
            '工事進捗ステータス','チェック日','チェック者','チェック内容','仮移設終了受信者','関連番号'
        ];

        foreach ($headers as $col => $header) {
            $sheet->setCellValue([$col + 1, 1], $header);
        }

        $maintenances = Maintenance::with([
                'branch',
                'trader',
                'status',
                'request',
                'tSetupFinishMember',
                'setupFinishMember',
                'checkMember'
            ])
            ->where('check_date', $date)
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 2;

        foreach ($maintenances as $m) {
            $sheet->setCellValue([1, $rowNo], $m->kddi_cd);
            $sheet->setCellValue([2, $rowNo], $m->kddi_oder_date);
            $sheet->setCellValue([3, $rowNo], $m->commit_date);
            $sheet->setCellValue([4, $rowNo], $m->branch?->name);
            $sheet->setCellValue([5, $rowNo], $m->work_notes);
            $sheet->setCellValue([6, $rowNo], $m->order_notes);
            $sheet->setCellValue([7, $rowNo], $m->work_address);
            $sheet->setCellValue([8, $rowNo], $m->term_start_date?->format('Y/m/d'));
            $sheet->setCellValue([9, $rowNo], $m->term_end_date?->format('Y/m/d'));
            $sheet->setCellValue([10, $rowNo], $m->term_notes);
            $sheet->setCellValue([11, $rowNo], $m->term2_start_date?->format('Y/m/d'));
            $sheet->setCellValue([12, $rowNo], $m->term2_end_date?->format('Y/m/d'));
            $sheet->setCellValue([13, $rowNo], $m->t_term_notes);
            $sheet->setCellValue([14, $rowNo], $m->t_term_end_date?->format('Y/m/d'));
            $sheet->setCellValue([15, $rowNo], $m->t_setup_action_date?->format('Y/m/d'));
            $sheet->setCellValue([16, $rowNo], $m->work_plan_date?->format('Y/m/d'));
            $sheet->setCellValue([17, $rowNo], $m->work_action_date?->format('Y/m/d'));
            $sheet->setCellValue([18, $rowNo], $m->trader?->name);
            $sheet->setCellValue([19, $rowNo], $m->stop_circuit_flg);
            $sheet->setCellValue([20, $rowNo], $m->stop_plan_date?->format('Y/m/d'));
            $sheet->setCellValue([21, $rowNo], $m->report_date?->format('Y/m/d'));
            $sheet->setCellValue([22, $rowNo], $m->complete_report_date?->format('Y/m/d'));
            $sheet->setCellValue([23, $rowNo], $m->wire_change_order_date?->format('Y/m/d'));
            $sheet->setCellValue([24, $rowNo], $m->complete_notes);
            $sheet->setCellValue([25, $rowNo], $m->notes);
            $sheet->setCellValue([26, $rowNo], $m->t_setup_plan_date?->format('Y/m/d'));
            $sheet->setCellValue([27, $rowNo], $m->conduct_plan_date?->format('Y/m/d'));
            $sheet->setCellValue([28, $rowNo], $m->conduct_action_date?->format('Y/m/d'));
            $sheet->setCellValue([29, $rowNo], $m->complete_stop_flg);
            $sheet->setCellValue([30, $rowNo], $m->kddi_month);
            $sheet->setCellValue([31, $rowNo], $m->contract_type);
            $sheet->setCellValue([32, $rowNo], $m->stop_no1);
            $sheet->setCellValue([33, $rowNo], $m->stop_no2);
            $sheet->setCellValue([34, $rowNo], $m->stop_no3);
            $sheet->setCellValue([35, $rowNo], $m->stop_no4);
            $sheet->setCellValue([36, $rowNo], $m->stop_no5);
            $sheet->setCellValue([37, $rowNo], $m->stop_action_date?->format('Y/m/d'));
            $sheet->setCellValue([38, $rowNo], $m->work_start_datetime);
            $sheet->setCellValue([39, $rowNo], $m->work_end_datetime);
            $sheet->setCellValue([40, $rowNo], $m->setupFinishMember?->name);
            $sheet->setCellValue([41, $rowNo], $m->kddi_check_date);
            $sheet->setCellValue([42, $rowNo], $m->kddi_report_notes);
            $sheet->setCellValue([43, $rowNo], $m->complete_design_receive_date?->format('Y/m/d'));
            $sheet->setCellValue([44, $rowNo], $m->kddi_report_type);
            $sheet->setCellValue([45, $rowNo], $m->toh_cd);
            $sheet->setCellValue([46, $rowNo], $m->check1_date?->format('Y/m/d'));
            $sheet->setCellValue([47, $rowNo], $m->check2_date?->format('Y/m/d'));
            $sheet->setCellValue([48, $rowNo], $m->check3_date?->format('Y/m/d'));
            $sheet->setCellValue([49, $rowNo], $m->request?->name);
            $sheet->setCellValue([50, $rowNo], $m->t_setup_start_datetime);
            $sheet->setCellValue([51, $rowNo], $m->t_setup_end_datetime);
            $sheet->setCellValue([52, $rowNo], $m->status?->name);
            $sheet->setCellValue([53, $rowNo], $m->check_date?->format('Y/m/d'));
            $sheet->setCellValue([54, $rowNo], $m->checkMember?->name);
            $sheet->setCellValue([55, $rowNo], $m->check_notes);
            $sheet->setCellValue([56, $rowNo], $m->tSetupFinishMember?->name);
            $sheet->setCellValue([57, $rowNo], $m->relation_cd);

            $rowNo++;
        }

        return $spreadsheet;
    }
}
