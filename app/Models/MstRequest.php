<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstRequest extends Model
{
    protected $table = 'mst_request';

    protected $guarded = [
        'id',
    ];

    // タイムスタンプ無効化
    public $timestamps = false;
}
