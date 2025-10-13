<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exclusion extends Model
{
    protected $table = 'exclusion';

    // タイムスタンプ無効化
    public $timestamps = false;

    // プライマリーキーが存在しない場合
    protected $primaryKey = null;

    // Eloquent に自動増分を無効化させる
    public $incrementing = false;

    protected $guarded = []; // ← 全カラムを代入可能に

    protected $casts = [
        'add_datetime' => 'datetime:Y/m/d H:i:s',
        'edit_datetime' => 'datetime:Y/m/d H:i:s',
    ];
}
