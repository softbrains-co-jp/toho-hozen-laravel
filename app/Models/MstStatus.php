<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstStatus extends Model
{
    protected $table = 'mst_status';

    protected $guarded = [
        'id',
    ];

    // タイムスタンプ無効化
    public $timestamps = false;
}
