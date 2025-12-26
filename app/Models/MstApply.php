<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstApply extends Model
{
    protected $table = 'mst_apply';

    // タイムスタンプ無効化
    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'sort',
        'add_datetime',
        'edit_datetime',
    ];
}
