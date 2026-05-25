<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    public const TIME_CDS = [
        'AM' => '午前',
        'PM' => '午後',
        'AP' => '終日',
    ];

    public const COLUMN_LABELS = [
        'kddi_cd' => 'KDDI管理番号',
        'branch_cd' => '支社',
        'work_notes' => '作業内容',
        'order_notes' => '指示内容',
        'work_address' => '現場住所',
        'trader_cd' => '施工業者',
        'notes' => '備考',
        'kddi_month' => 'KDDI精算月',
        'contract_type' => '契約種別',
        'toh_cd' => 'TOH管理番号',
        'request_cd' => '依頼種別',
        'status_cd' => '工事進捗ステータス',
        'check_date' => 'チェック日',
        'check_mcd' => 'チェック者',
        'check_notes' => 'チェック内容',
        'relation_cd' => '関連番号',
        'pole_cd' => '電柱番号',
        'setup_cd' => '移設種別',
        'road_cd' => '道路種別',
        'term_start_date' => '本工期（自）',
        'term_end_date' => '本工期（至）',
        'term_notes' => '本工期備考',
        'term2_start_date' => '本工期（自）変更後',
        'term2_end_date' => '本工期（至）変更後',
        't_term_notes' => '仮工期備考',
        't_term_end_date' => '仮工期（至）',
        't_term_start_date' => '仮工期（自）',
        't_term2_start_date' => '仮工期変更後（自）',
        't_term2_end_date' => '仮工期変更後（至）',
        'kddi_oder_date' => 'KDDI依頼日',
        'commit_date' => '工事付託日',
        't_setup_action_date' => '仮移設実施日',
        'work_plan_date' => '作業予定日',
        'work_action_date' => '作業実施日',
        'report_date' => '工事完了報告日',
        't_setup_plan_date' => '仮移設予定日',
        'conduct_plan_date' => '現場調査予定日',
        'conduct_action_date' => '現場調査実施日',
        'work_start_datetime' => '作業開始時間',
        'work_end_datetime' => '作業終了時間',
        'setup_finish_mcd' => '本移設終了受信者',
        'kddi_check_date' => 'KDDI確認依頼日',
        'kddi_report_notes' => 'KDDI報告内容',
        'kddi_report_type' => 'KDDI報告種別',
        'check1_date' => '建柱確認日1',
        'check2_date' => '建柱確認日2',
        'check3_date' => '建柱確認日3',
        't_setup_start_datetime' => '仮移設作業開始時間',
        't_setup_end_datetime' => '仮移設作業終了時間',
        't_setup_finish_mcd' => '仮移設終了受信者',
        'conduct_commit_date' => '調査付託日',
        'conduct_report_date' => '調査報告日',
        'work_report_date' => '工事報告日',
        'conduct_member_name' => '調査作業員名',
        'conduct_start_datetime' => '調査作業開始時間',
        'conduct_end_datetime' => '調査作業終了時間',
        'conduct_start_mcd' => '調査開始受信者',
        'conduct_end_mcd' => '調査終了受信者',
        't_setup_start_mcd' => '仮移設開始受信者',
        't_setup_member_name' => '仮移設作業員名',
        'setup_member_name' => '本移設作業員名',
        'setup_start_mcd' => '本移設開始受信者',
        't_setup_plan_time_cd' => '仮移設予定時間',
        'work_plan_time_cd' => '作業予定時間',
        'conduct_time_cd' => '現場調査予定時間',
        'stop_circuit_flg' => '回線停止有無',
        'stop_plan_date' => '停止予定日',
        'stop_no1' => '停止番号1',
        'stop_no2' => '停止番号2',
        'stop_no3' => '停止番号3',
        'stop_no4' => '停止番号4',
        'stop_no5' => '停止番号5',
        'stop_no6' => '停止番号6',
        'stop_no7' => '停止番号7',
        'stop_no8' => '停止番号8',
        'stop_no9' => '停止番号9',
        'stop_no10' => '停止番号10',
        'stop_action_date' => '停止実施日',
        'stop_100m_time' => '100M停止時間',
        'stop_gepon_time' => 'GE-PON停止時間',
        'mc_open_flg' => 'マルチM/C開閉有無',
        'mc_pole_cd' => 'マルチM/C電柱番号',
        'apply_type' => '申請種別',
        'add_design_receive_date' => '追加申請図面受領日',
        'add_order_date' => '追加申請依頼日',
        'add_receive_date' => '追加申請回答日',
        'complete_order_date' => '竣工報告依頼日',
        'complete_receive_date' => '竣工届受理日',
        'cancel_design_receive_date' => '解除申請図面受領日',
        'cancel_order_date' => '解除申請依頼日',
        'cancel_report_receive_date' => '解除竣工届受領日',
        'apply_notes' => '申請備考',
        'complete_report_date' => '竣工報告日',
        'wire_change_order_date' => '電線設備変更依頼書送信日',
        'complete_notes' => '竣工備考',
        'complete_stop_flg' => '竣工処理待ち',
        'complete_design_receive_date' => '竣工図書受領日',
        'conduct_receive_date' => '調査報告書受領日',
        't_work_receive_date' => '仮工事報告書受領日',
        'gemini_order_date' => 'GEMINI修正依頼日',
        'object_drop_number' => '対象ドロップ条数（条）',
        'straight_kit_number' => '直線接続キット数（個）',
        'single_drop_meter' => '単独架設ドロップ（ｍ）',
        'bundle_drop_meter' => '一束化架設ドロップ（ｍ）',
        'messen_meter' => 'メッセン新設（ｍ）',
        'spahan_meter' => 'スパハン新設（ｍ）',
        'add_mahon_number' => '新設間本数（間本）',
        'single_drop_removal_meter' => '単独撤去ドロップ（ｍ）',
        'bundle_drop_removal_meter' => '一束化撤去ドロップ（ｍ）',
        'messen_removal_meter' => 'メッセン撤去（ｍ）',
        'spahan_removal_meter' => 'スパハン撤去（ｍ）',
        'delete_mahon_number' => '撤去間本数（間本）',
        'a_pole_number' => 'A装柱新設（個）',
        'de_pole_number' => 'D,E装柱新設（個）',
        'f07_pole_number' => 'F０．７装柱新設（個）',
        'f09_pole_number' => 'F０．９装柱新設（個）',
        'f12_pole_number' => 'F１．２装柱新設（個）',
        'f14_pole_number' => 'F１．４装柱新設（個）',
        'band_number' => '自在バンド新設（個）',
        'ade_pole_removal_number' => 'A,D,E装柱撤去（個）',
        'f_pole_removal_number' => 'F装柱撤去（個）',
        'protect_pipe_number' => '建築防護管取付（本）',
        'protect_cover_number' => '防護カバー取付（本）',
        'bird_single_meter' => '鳥害対策単独用取付（ｍ）',
        'bird_messen_meter' => '鳥害対策メッセン用取付（ｍ）',
        'port_change_number' => 'ポート変更（ポート）',
        'protect_pipe_removal_number' => '建築防護管取外（本）',
        'protect_cover_removal_number' => '防護カバー取外（本）',
        'bird_single_removal_number' => '鳥害対策単独用取外（ｍ）',
        'bird_messen_removal_number' => '鳥害対策メッセン用取外（ｍ）',
        'house_keep_number' => '宅内引留取付（箇所）',
        'house_keep_removal_number' => '宅内引留取外（箇所）',
        'calc_notes' => '集計備考',
        'band_removal_number' => '自在バンド撤去（個）',
        'connecter_number' => 'コネクタースリーブ数（個）',
        'login_id' => 'ログインID',
        'history_notes' => '対応履歴',
        'stop_notes' => '停止備考',
    ];

    public const HIDDEN_QUERY_COLUMNS = [
        'add_datetime',
        'edit_datetime',
        'status_flg',
    ];

    protected $table = 'maintenance';

    // タイムスタンプ無効化
    public $timestamps = false;

    // プライマリーキーが存在しない場合
    protected $primaryKey = 'toh_cd';

    // Eloquent に自動増分を無効化させる
    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
            'check_date' => 'date:Y/m/d',
            't_term_start_date' => 'date:Y/m/d',
            't_term_end_date' => 'date:Y/m/d',
            't_term2_start_date' => 'date:Y/m/d',
            't_term2_end_date' => 'date:Y/m/d',
            'term_start_date' => 'date:Y/m/d',
            'term_end_date' => 'date:Y/m/d',
            'term2_start_date' => 'date:Y/m/d',
            'term2_end_date' => 'date:Y/m/d',
            'kddi_oder_date' => 'date:Y/m/d',
            'report_date' => 'date:Y/m/d',
            'work_report_date' => 'date:Y/m/d',
            'conduct_commit_date' => 'date:Y/m/d',
            'conduct_plan_date' => 'date:Y/m/d',
            'conduct_action_date' => 'date:Y/m/d',
            'conduct_report_date' => 'date:Y/m/d',
            'check1_date' => 'date:Y/m/d',
            'check2_date' => 'date:Y/m/d',
            'check3_date' => 'date:Y/m/d',
            't_setup_plan_date' => 'date:Y/m/d',
            't_setup_action_date' => 'date:Y/m/d',
            'commit_date' => 'date:Y/m/d',
            'work_plan_date' => 'date:Y/m/d',
            'work_action_date' => 'date:Y/m/d',
            'kddi_check_date' => 'date:Y/m/d',
            'stop_plan_date' => 'date:Y/m/d',
            'stop_action_date' => 'date:Y/m/d',
            'add_order_date' => 'date:Y/m/d',
            'add_receive_date' => 'date:Y/m/d',
            'add_design_receive_date' => 'date:Y/m/d',
            'complete_order_date' => 'date:Y/m/d',
            'complete_receive_date' => 'date:Y/m/d',
            'cancel_order_date' => 'date:Y/m/d',
            'cancel_report_receive_date' => 'date:Y/m/d',
            'cancel_design_receive_date' => 'date:Y/m/d',
            'conduct_receive_date' => 'date:Y/m/d',
            't_work_receive_date' => 'date:Y/m/d',
            'complete_design_receive_date' => 'date:Y/m/d',
            'wire_change_order_date' => 'date:Y/m/d',
            'gemini_order_date' => 'date:Y/m/d',
            'complete_report_date' => 'date:Y/m/d',
    ];

    public function trader() {
        return $this->belongsTo('App\Models\MstTrader', 'trader_cd', 'code');
    }

    public function branch() {
        return $this->belongsTo('App\Models\MstBranch', 'branch_cd', 'code');
    }

    public function kddiReportType()
    {
        return $this->belongsTo(MstKddiReport::class, 'kddi_report_type', 'code');
    }

    public function conductStartMember()
    {
        return $this->belongsTo(MstMember::class, 'conduct_start_mcd', 'code');
    }

    public function conductEndMember()
    {
        return $this->belongsTo(MstMember::class, 'conduct_end_mcd', 'code');
    }

    public function tSetupStartMember()
    {
        return $this->belongsTo(MstMember::class, 't_setup_start_mcd', 'code');
    }

    public function tSetupFinishMember()
    {
        return $this->belongsTo(MstMember::class, 't_setup_finish_mcd', 'code');
    }

    public function setupStartMember()
    {
        return $this->belongsTo(MstMember::class, 'setup_start_mcd', 'code');
    }

    public function setupFinishMember()
    {
        return $this->belongsTo(MstMember::class, 'setup_finish_mcd', 'code');
    }

    public function checkMember()
    {
        return $this->belongsTo(MstMember::class, 'check_mcd', 'code');
    }

    public function status()
    {
        return $this->belongsTo(MstStatus::class, 'status_cd', 'code');
    }

    public function request()
    {
        return $this->belongsTo(MstRequest::class, 'request_cd', 'code');
    }

    public function setup()
    {
        return $this->belongsTo(MstSetup::class, 'setup_cd', 'code');
    }

    public function apply()
    {
        return $this->belongsTo(MstApply::class, 'apply_type', 'code');
    }

}
