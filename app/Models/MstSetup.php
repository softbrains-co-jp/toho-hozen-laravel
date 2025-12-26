<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstSetup extends Model
{
    protected $table = 'mst_setup';

    protected $guarded = [
        'id',
    ];

    // タイムスタンプ無効化
    public $timestamps = false;
}
