<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\Import\DailyReportRequest;
use App\Http\Requests\Import\RelocationReceptionRequest;
use App\Imports\DailyReportImport;
use App\Imports\RelocationReception\RelocationReceptionImport;
use App\Models\Maintenance;
use App\Models\MstBranch;

class ImportController extends Controller
{
    public function index(Request $request)
    {
        return view('import.index');
    }

    public function importDailyReport(DailyReportRequest $request) {
        $import = new DailyReportImport();

        // ログインユーザ
        $user = Auth::user();

        $files = $request->file('daily_reports');

        $import_log = [];
        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $import_log[$fileName] = [];

            Excel::import($import, $file);

            // dump($import->dailyReports);

            $row = 5;
            $isCanImport = true;
            foreach ($import->dailyReports as $dailyReport) {
                $toh_cd = mb_convert_kana($dailyReport['toh_cd'], "a");

                // 付託番号
                $maintenance = Maintenance::where('toh_cd', $toh_cd)
                    ->first();
                if (!$maintenance) {
                    $import_log[$fileName][] = "{$row}行目 付託番号が存在しません（{$dailyReport['toh_cd']}）";
                    $isCanImport = false;
                }

                if (empty($dailyReport['conduct_plan_date'])) {
                    $import_log[$fileName][] = "{$row}行目 予定日が空です";
                    $isCanImport = false;
                }

                // 午前／午後区分
                if ($dailyReport['conduct_time_cd'] == '午前') {
                    $dailyReport['conduct_time_cd'] = 'AM';
                }
                elseif ($dailyReport['conduct_time_cd'] == '午後') {
                    $dailyReport['conduct_time_cd'] = 'PM';
                }
                elseif (empty($dailyReport['conduct_time_cd'])) {
                    $import_log[$fileName][] = "{$row}行目 午前／午後区分が空です";
                    $isCanImport = false;
                }
                else {
                    $import_log[$fileName][] = "{$row}行目 午前／午後区分が正しくありません（{$dailyReport['conduct_time_cd']}）";
                    $isCanImport = false;
                }

                if (empty($dailyReport['conduct_member_name'])) {
                    $import_log[$fileName][] = "{$row}行目 作業班長が空です";
                    $isCanImport = false;
                }


                // 完了区分が空でない場合
                if ($dailyReport['completion_flag']) {
                    // 開始時間
                    if (empty($dailyReport['start_time'])) {
                        $import_log[$fileName][] = "{$row}行目 開始時間が空です";
                        $isCanImport = false;
                    }
                    elseif (!$this->isValidTime($dailyReport['start_time'])) {
                        $import_log[$fileName][] = "{$row}行目 開始時間が正しくありません（{$dailyReport['start_time']}）";
                        $isCanImport = false;
                    }

                    // 終了時間
                    if (empty($dailyReport['end_time'])) {
                        $import_log[$fileName][] = "{$row}行目 終了時間が空です";
                        $isCanImport = false;
                    }
                    elseif (!$this->isValidTime($dailyReport['end_time'])) {
                        $import_log[$fileName][] = "{$row}行目 終了時間が正しくありません（{$dailyReport['end_time']}）";
                        $isCanImport = false;
                    }

                    // 対応履歴先頭に「◎予定日　紙枚数　備考」を設定
                    $historyNotes = "◎" . $dailyReport['conduct_plan_date'];
                    $historyNotes .= ($dailyReport['number_of_pages'] != "") ? " " . $dailyReport['number_of_pages'] : "";
                    $historyNotes .= ($dailyReport['remarks'] != "") ? " " . $dailyReport['remarks'] : "";

                    if ($isCanImport) {
                        if ($dailyReport['construction_type'] == "現場調査") {
                            $maintenance->conduct_plan_date = $dailyReport['conduct_plan_date'];
                            $maintenance->conduct_time_cd = $dailyReport['conduct_time_cd'];
                            $maintenance->conduct_member_name = $dailyReport['conduct_member_name'];
                            $maintenance->conduct_start_datetime = $dailyReport['start_time'];
                            $maintenance->conduct_end_datetime = $dailyReport['end_time'];
                            $maintenance->history_notes = $historyNotes . $maintenance->history_notes;
                            $maintenance->status_flg = null;
                            $maintenance->login_id = $user->id;
                            $maintenance->edit_datetime = now();
                            $maintenance->save();
                        }
                        elseif ($dailyReport['construction_type'] == "仮工事") {
                            $maintenance->t_setup_plan_date = $dailyReport['conduct_plan_date'];
                            $maintenance->t_setup_plan_time_cd = $dailyReport['conduct_time_cd'];
                            $maintenance->t_setup_member_name = $dailyReport['conduct_member_name'];
                            $maintenance->t_setup_start_datetime = $dailyReport['start_time'];
                            $maintenance->t_setup_end_datetime = $dailyReport['end_time'];
                            $maintenance->history_notes = $historyNotes . $maintenance->history_notes;
                            $maintenance->status_flg = null;
                            $maintenance->login_id = $user->id;
                            $maintenance->edit_datetime = now();
                            $maintenance->save();
                        }
                        elseif ($dailyReport['construction_type'] == "本工事") {
                            $maintenance->work_plan_date = $dailyReport['conduct_plan_date'];
                            $maintenance->work_plan_time_cd = $dailyReport['conduct_time_cd'];
                            $maintenance->setup_member_name = $dailyReport['conduct_member_name'];
                            $maintenance->work_start_datetime = $dailyReport['start_time'];
                            $maintenance->work_end_datetime = $dailyReport['end_time'];
                            $maintenance->history_notes = $historyNotes . $maintenance->history_notes;
                            $maintenance->status_flg = null;
                            $maintenance->login_id = $user->id;
                            $maintenance->edit_datetime = now();
                            $maintenance->save();
                        }
                        else {
                            $import_log[$fileName][] = "{$row}行目 工事区分が正しくありません（{$dailyReport['construction_type']}）";
                            $isCanImport = false;
                        }
                    }
                }
                else {
                    // 対応履歴先頭に「◎紙枚数」を設定
                    $historyNotes = ($dailyReport['number_of_pages'] != "") ? "◎" . $dailyReport['number_of_pages'] : "";

                    if ($isCanImport) {
                        if ($dailyReport['construction_type'] == "現場調査") {
                            $maintenance->conduct_plan_date = $dailyReport['conduct_plan_date'];
                            $maintenance->conduct_time_cd = $dailyReport['conduct_time_cd'];
                            $maintenance->conduct_member_name = $dailyReport['conduct_member_name'];
                            $maintenance->history_notes = $historyNotes . $maintenance->history_notes;
                            $maintenance->status_flg = null;
                            $maintenance->login_id = $user->id;
                            $maintenance->edit_datetime = now();
                            $maintenance->save();
                        }
                        elseif ($dailyReport['construction_type'] == "仮工事") {
                            $maintenance->t_setup_plan_date = $dailyReport['conduct_plan_date'];
                            $maintenance->t_setup_plan_time_cd = $dailyReport['conduct_time_cd'];
                            $maintenance->t_setup_member_name = $dailyReport['conduct_member_name'];
                            $maintenance->history_notes = $historyNotes . $maintenance->history_notes;
                            $maintenance->status_flg = null;
                            $maintenance->login_id = $user->id;
                            $maintenance->edit_datetime = now();
                            $maintenance->save();
                        }
                        elseif ($dailyReport['construction_type'] == "本工事") {
                            $maintenance->work_plan_date = $dailyReport['conduct_plan_date'];
                            $maintenance->work_plan_time_cd = $dailyReport['conduct_time_cd'];
                            $maintenance->setup_member_name = $dailyReport['conduct_member_name'];
                            $maintenance->history_notes = $historyNotes . $maintenance->history_notes;
                            $maintenance->status_flg = null;
                            $maintenance->login_id = $user->id;
                            $maintenance->edit_datetime = now();
                            $maintenance->save();
                        }
                        else {
                            $import_log[$fileName][] = "{$row}行目 工事区分が正しくありません（{$dailyReport['construction_type']}）";
                            $isCanImport = false;
                        }
                    }
                }

                if ($isCanImport) {
                    $import_log[$fileName][] = "{$row}行目 取り込み成功（{$dailyReport['toh_cd']}）";
                }

                $row++;
            }
        }

        return redirect()
            ->route('import.index')
            ->with(compact('import_log'))
            ->with('success', "取り込みが完了しました。");
    }

    public function importRelocationReception(RelocationReceptionRequest $request) {
        $import = new RelocationReceptionImport();

        // ログインユーザ
        $user = Auth::user();

        $files = $request->file('relocation_receptions');

        $relocationImportLog = [];
        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $relocationImportLog[$fileName] = [];
            $isCanImport = true;

            Excel::import($import, $file);

            $relocationReception  = $import->relocationReception;

            $branch = MstBranch::where('name', $relocationReception['branch_cd'])
                ->first();
            if (!$branch) {
                $relocationImportLog[$fileName][] = "支社が正しくありません（{$relocationReception['branch_cd']}）";
                // $isCanImport = false;
            }

            $maintenance = Maintenance::where('toh_cd', $relocationReception['toh_cd'])
                ->first();
            if ($maintenance) {
                $relocationImportLog[$fileName][] = "すでに取込済みです。（{$relocationReception['toh_cd']}）";
                $isCanImport = false;
            }

            if (strlen($relocationReception['toh_cd']) != 11 && strlen($relocationReception['toh_cd']) != 10) {
                $relocationImportLog[$fileName][] = "管理番号が正しくありません。（{$relocationReception['toh_cd']}）";
                $isCanImport = false;
            }

            if ($isCanImport) {
                $maintenance = Maintenance::create([
                    'kddi_cd' => $relocationReception['kddi_cd'],
                    'toh_cd' => $relocationReception['toh_cd'],
                    'relation_cd' => $relocationReception['relation_cd'],
                    'branch_cd' => $branch?->code,
                    'work_address' => $relocationReception['work_address'],
                    'work_notes' => $relocationReception['work_notes'],
                    'order_notes' => $relocationReception['order_notes'],
                    'pole_cd' => $relocationReception['pole_cd'],
                    'term_start_date' => $relocationReception['term_start_date'],
                    'term_end_date' => $relocationReception['term_end_date'],
                    't_term_start_date' => $relocationReception['t_term_start_date'],
                    't_term_end_date' => $relocationReception['t_term_end_date'],
                    'kddi_oder_date' => $relocationReception['kddi_oder_date'],
                    'stop_circuit_flg' => '02',
                    'mc_open_flg' => '02',
                    'login_id' => $user->login_id,
                    'add_datetime' => now(),
                    'edit_datetime' => now(),
                ]);
                $relocationImportLog[$fileName][] = "取り込みを行いました。（{$relocationReception['toh_cd']}）";
            }
        }

        return redirect()
            ->route('import.index')
            ->with(compact('relocationImportLog'))
            ->with('success', "取り込みが完了しました。");
    }


    protected function isValidDate($value, $format = 'Y-m-d')
    {
        $date = \DateTime::createFromFormat($format, $value);
        return $date && $date->format($format) === $value;
    }

    protected function isValidTime($value, $format = 'H:i')
    {
        $time = \DateTime::createFromFormat($format, $value);
        return $time && $time->format($format) === $value;
    }
}
