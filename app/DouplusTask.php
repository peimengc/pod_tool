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
        'create_time',
        'reject_reason',
        'state_desc',
        'ad_stat',
        'item_cover'
    ];

    protected $casts = [
        'delivery_start_time' => 'datetime',
        'ad_stat' => 'json'
    ];
}
