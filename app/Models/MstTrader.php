<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstTrader extends Model
{
    protected $table = 'mst_trader';

    protected $guarded = [
        'id',
    ];

    // タイムスタンプ無効化
    public $timestamps = false;
}
