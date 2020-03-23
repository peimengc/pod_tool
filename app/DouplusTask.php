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
        'budget',
        'create_time',

        'state',
        'cost',
        'state_desc',
        'reject_reason',
        'duration',

    ];

    protected $casts = [
        'delivery_start_time' => 'datetime',
        'ad_stat' => 'json'
    ];

    const STATE_RUN = 1;
    const STATE_REVIEW = 2;
    const STATE_REJECT = 3;
    const STATE_OVER = 4;

    public static $stateArr = [
        self::STATE_OVER => '投放完成',
        self::STATE_RUN => '投放中',
        self::STATE_REJECT => '被拒绝',
        self::STATE_REVIEW => '审核中',
    ];

}
