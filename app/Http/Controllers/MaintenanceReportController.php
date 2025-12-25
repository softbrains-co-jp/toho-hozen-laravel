<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Exclusion;
use App\Models\MstTrader;
use App\Models\Maintenance;


class MaintenanceReportController extends Controller
{
    public function index(Request $request)
    {
        // ログインユーザ
        $user = Auth::user();

        $traders = MstTrader::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        // 工事内容オプション
        $construction_content_options = [
            '1' => '現場調査',
            '2' => '仮工事',
            '3' => '本工事',
        ];

        // 	進捗詳細オプション
        $progress_detail_options = [
            '1' => '未着手',
            '2' => '作業中',
            '3' => '作業終了',
            '4' => '持越',
        ];

        $status_options = [
            '1' => '見着手',
            '2' => '作業中',
            '3' => '作業終了',
            '4' => '持越',
        ];

        $condition = [
            'maintenance_report_date' => $request->input('maintenance_report_date', today()),
            'construction_content' => $request->input('construction_content'),
        ];

        $list = [];
        if ($request->input('action') == 'list') {
            $query = Maintenance::query()
                ->with([
                    'kddiReportType',
                    'conductStartMember',
                    'conductEndMember',
                    'tSetupStartMember',
                    'tSetupFinishMember',
                    'setupStartMember',
                    'setupFinishMember',
                    'trader',
                    'branch',
                ]);

            if ($maintenance_report_date = $condition['maintenance_report_date']) {
                $query->where(function ($query) use ($maintenance_report_date) {
                    $query->where('work_plan_date', $maintenance_report_date)
                        ->orWhere('conduct_plan_date', $maintenance_report_date)
                        ->orWhere('t_setup_plan_date', $maintenance_report_date);
                });
            }

            $maintenances = $query->orderBy('toh_cd')
                ->get();

            $no = 1;
            foreach ($maintenances as $maintenance) {
                $row = [];
                // 現場調査
                if ($maintenance->conduct_plan_date?->isSameDay($condition['maintenance_report_date'])) {
                    if ($condition['construction_content'] && $condition['construction_content'] != '1') continue;

                    $row = [
                        'construction_content' => '現場調査',
                        'member_name' => $maintenance->conduct_member_name,
                        'time_cd' => $maintenance->conduct_time_cd,
                        'start_time' => $maintenance->conduct_start_datetime,
                        'start_member' => $maintenance->conductStartMember?->name,
                        'end_time' => $maintenance->conduct_end_datetime,
                        'end_member' => $maintenance->conductEndMember?->name,
                    ];
                }
                elseif ($maintenance->t_setup_plan_date?->isSameDay($condition['maintenance_report_date'])) {
                    if ($condition['construction_content'] && $condition['construction_content'] != '2') continue;

                    $row = [
                        'construction_content' => '仮工事',
                        'member_name' => $maintenance->t_setup_member_name,
                        'time_cd' => $maintenance->t_setup_plan_time_cd,
                        'start_time' => $maintenance->t_setup_start_datetime,
                        'start_member' => $maintenance->tSetupStartMember?->name,
                        'end_time' => $maintenance->t_setup_end_datetime,
                        'end_member' => $maintenance->tSetupFinishMember?->name,
                    ];
                }
                elseif ($maintenance->work_plan_date?->isSameDay($condition['maintenance_report_date'])) {
                    if ($condition['construction_content'] && $condition['construction_content'] != '3') continue;

                    $row = [
                        'construction_content' => '本工事',
                        'member_name' => $maintenance->setup_member_name,
                        'time_cd' => $maintenance->work_plan_time_cd,
                        'start_time' => $maintenance->work_start_datetime,
                        'start_member' => $maintenance->setupStartMember?->name,
                        'end_time' => $maintenance->work_end_datetime,
                        'end_member' => $maintenance->setupFinishMember?->name,
                    ];
                }

                // 各行のステータスを設定
                $status = '';


                $list[] = [
                    'no' => $no,
                    'kddi_cd' => $maintenance->kddi_cd,
                    'toh_cd' => $maintenance->toh_cd,
                    'trader_name' => $maintenance->trader?->name,
                    'branch_name' => $maintenance->branch?->name,
                ] + $row;

                $no++;
            }

        }

        return view('maintenance-report.index')
            ->with(compact(
                'traders',
                'construction_content_options',
                'progress_detail_options',
                'status_options',
                'condition',
                'list'
            ));
    }

    public function delete(Request $request)
    {
        $toh_cd = $request->input('toh_cd');
        $data = Exclusion::where('toh_cd', $toh_cd);
        if (!$data) {
            abort(404);
        }
        $data->delete();

        return redirect()->route('exclusion.index')->with('success', "データを削除しました。");
    }
}
