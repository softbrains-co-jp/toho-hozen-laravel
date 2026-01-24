<?php

namespace App\Http\Controllers;

use App\Http\Requests\Report\UpdateRequest;
use App\Models\Maintenance;
use App\Models\MstMember;
use App\Models\MstTrader;
use App\Models\MstUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // ログインユーザ
        $user = Auth::user();

        // 施工業者一覧
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

        $condition = [
            'maintenance_report_date' => $request->input('maintenance_report_date', today()),
            'trader_cd' => $request->input('trader_cd'),
            'construction_content' => $request->input('construction_content'),
            'progress_detail' => $request->input('progress_detail'),
        ];

        // 一般ユーザの場合、施工業者は固定
        if ($user->role == MstUser::ROLE_USER) {
            $condition['trader_cd'] = $user->trader_cd;
        }

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

            if ($trader_cd = $condition['trader_cd']) {
                $query->where('trader_cd', $trader_cd);
            }

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

                if ($maintenance->t_setup_plan_date?->isSameDay($condition['maintenance_report_date'])) {
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

                if ($maintenance->work_plan_date?->isSameDay($condition['maintenance_report_date'])) {
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
                $progress_detail = '';
                if ($row['start_time'] && $row['end_time']) {
                    $progress_detail = '3';
                } elseif ($row['start_time']) {
                    $progress_detail = '2';
                } elseif ($maintenance->status_flg == '1') {
                    $progress_detail = '4';
                } else {
                    $progress_detail = '1';
                }

                if ($condition['progress_detail'] && $condition['progress_detail'] != $progress_detail) {
                    continue;
                }

                $list[] = [
                    'no' => $no,
                    'kddi_cd' => $maintenance->kddi_cd,
                    'toh_cd' => $maintenance->toh_cd,
                    'trader_name' => $maintenance->trader?->name,
                    'branch_name' => $maintenance->branch?->name,
                    'progress_detail' => $progress_detail,
                ] + $row;

                $no++;
            }

        }

        return view('report.index')
            ->with(compact(
                'traders',
                'construction_content_options',
                'progress_detail_options',
                'condition',
                'list'
            ));
    }

    public function post(UpdateRequest $request)
    {
        $list = $request->input('maintenances');

        foreach ($list as $row) {
            $maintenance = Maintenance::where('toh_cd', $row['toh_cd'])
                ->first();

            if ($row['construction_content'] == '現場調査') {
                $this->updateSiteInspection($maintenance, $row);
            } elseif ($row['construction_content'] == '仮工事') {
                $this->updateTemporaryConstruction($maintenance, $row);
            } elseif ($row['construction_content'] == '本工事') {
                $this->updateMainConstruction($maintenance, $row);
            }
        }

        return redirect()->route('report.index', $request->query());

    }

    private function updateSiteInspection($maintenance, $data)
    {
        // ログインユーザ
        $user = Auth::user();
        $member = $this->getLoginMember($user);

        if ($data['old_progress_detail'] == '1' && $data['progress_detail'] == '2') {
            // 「未着手」→「作業中」
            $maintenance->conduct_start_datetime = date('H:i');
            $maintenance->conduct_start_mcd = $member->code;
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        } elseif ($data['old_progress_detail'] == '1' && $data['progress_detail'] == '4') {
            // 「未着手」→「持越」
            $maintenance->conduct_start_datetime = null;
            $maintenance->conduct_start_mcd = null;
            $maintenance->conduct_end_datetime = null;
            $maintenance->conduct_end_mcd = null;
            $maintenance->status_flg = '1';
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        } elseif ($data['old_progress_detail'] == '2' && $data['progress_detail'] == '3') {
            // 「作業中」→「作業終了」
            $maintenance->conduct_end_datetime = date('H:i');
            $maintenance->conduct_end_mcd = $member->code;
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        } elseif ($data['old_progress_detail'] == '2' && $data['progress_detail'] == '4') {
            // 「作業中」→「持越」
            $maintenance->conduct_start_datetime = null;
            $maintenance->conduct_start_mcd = null;
            $maintenance->conduct_end_datetime = null;
            $maintenance->conduct_end_mcd = null;
            $maintenance->status_flg = '1';
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        }
    }

    private function updateTemporaryConstruction($maintenance, $data)
    {
        // ログインユーザ
        $user = Auth::user();
        $member = $this->getLoginMember($user);

        if ($data['old_progress_detail'] == '1' && $data['progress_detail'] == '2') {
            // 「未着手」→「作業中」
            $maintenance->t_setup_start_datetime = date('H:i');
            $maintenance->t_setup_start_mcd = $member->code;
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        } elseif ($data['old_progress_detail'] == '1' && $data['progress_detail'] == '4') {
            // 「未着手」→「持越」
            $maintenance->t_setup_start_datetime = null;
            $maintenance->t_setup_start_mcd = null;
            $maintenance->t_setup_end_datetime = null;
            $maintenance->t_setup_finish_mcd = null;
            $maintenance->status_flg = '1';
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        } elseif ($data['old_progress_detail'] == '2' && $data['progress_detail'] == '3') {
            // 「作業中」→「作業終了」
            $maintenance->t_setup_end_datetime = date('H:i');
            $maintenance->t_setup_finish_mcd = $member->code;
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        } elseif ($data['old_progress_detail'] == '2' && $data['progress_detail'] == '4') {
            // 「作業中」→「持越」
            $maintenance->t_setup_start_datetime = null;
            $maintenance->t_setup_start_mcd = null;
            $maintenance->t_setup_end_datetime = null;
            $maintenance->t_setup_finish_mcd = null;
            $maintenance->status_flg = '1';
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        }
    }

    private function updateMainConstruction($maintenance, $data)
    {
        // ログインユーザ
        $user = Auth::user();
        $member = $this->getLoginMember($user);

        if ($data['old_progress_detail'] == '1' && $data['progress_detail'] == '2') {
            // 「未着手」→「作業中」
            $maintenance->work_start_datetime = date('H:i');
            $maintenance->setup_start_mcd = $member->code;
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        } elseif ($data['old_progress_detail'] == '1' && $data['progress_detail'] == '4') {
            // 「未着手」→「持越」
            $maintenance->work_start_datetime = null;
            $maintenance->setup_start_mcd = null;
            $maintenance->work_end_datetime = null;
            $maintenance->setup_finish_mcd = null;
            $maintenance->status_flg = '1';
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        } elseif ($data['old_progress_detail'] == '2' && $data['progress_detail'] == '3') {
            // 「作業中」→「作業終了」
            $maintenance->work_end_datetime = date('H:i');
            $maintenance->setup_finish_mcd = $member->code;
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        } elseif ($data['old_progress_detail'] == '2' && $data['progress_detail'] == '4') {
            // 「作業中」→「持越」
            $maintenance->work_start_datetime = null;
            $maintenance->setup_start_mcd = null;
            $maintenance->work_end_datetime = null;
            $maintenance->setup_finish_mcd = null;
            $maintenance->status_flg = '1';
            $maintenance->login_id = $user->id;
            $maintenance->edit_datetime = now();
            $maintenance->save();
        }
    }

    private function getLoginMember($user)
    {
        $member = MstMember::where('name', $user->name)
            ->first();

        return $member;
    }
}
