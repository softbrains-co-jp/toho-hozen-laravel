<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenance';
    //
    // タイムスタンプ無効化
    public $timestamps = false;

    // プライマリーキーが存在しない場合
    protected $primaryKey = 'toh_cd';

    // Eloquent に自動増分を無効化させる
    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'check_date' => 'date:Y/m/d',
    ];

}
