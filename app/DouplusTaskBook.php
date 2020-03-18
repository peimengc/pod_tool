<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DouplusTaskBook extends Model
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
    ];
}
