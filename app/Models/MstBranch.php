<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstBranch extends Model
{
    protected $table = 'mst_branch';

    protected $guarded = [
        'id',
    ];

    // タイムスタンプ無効化
    public $timestamps = false;
}
