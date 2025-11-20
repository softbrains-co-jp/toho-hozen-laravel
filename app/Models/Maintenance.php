<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
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

}
