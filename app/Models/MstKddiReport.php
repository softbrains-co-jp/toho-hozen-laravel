<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstKddiReport extends Model
{
    protected $table = 'mst_kddi_report';

    protected $guarded = [
        'id',
    ];

    // タイムスタンプ無効化
    public $timestamps = false;
}
