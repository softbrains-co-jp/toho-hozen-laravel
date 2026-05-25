<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QueryPreset extends Model
{
    use SoftDeletes;

    protected $table = 'query_presets';

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'display_columns' => 'array',
        'conditions' => 'array',
    ];
}
