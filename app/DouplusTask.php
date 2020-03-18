<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DouplusTask extends Model
{
    protected $fillable = [
        'douyin_auth_id',
        'aweme_id',
        'aweme_author_id',
        'product_id',
        'task_id',
        'state',
        'cost',
        'budget',
        'total_balance',
        'duration',
        'delivery_start_time',
        'create_time',
        'reject_reason'
    ];

    protected $casts = [
        'delivery_start_time' => 'datetime'
    ];
}
