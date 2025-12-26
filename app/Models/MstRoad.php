<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstRoad extends Model
{
    protected $table = 'mst_road';

    protected $guarded = [
        'id',
    ];

    // タイムスタンプ無効化
    public $timestamps = false;
}
