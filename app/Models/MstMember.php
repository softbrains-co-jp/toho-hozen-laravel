<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstMember extends Model
{
    protected $table = 'mst_member';

    protected $guarded = [
        'id',
    ];

    // タイムスタンプ無効化
    public $timestamps = false;
}
