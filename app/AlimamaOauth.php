<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlimamaOauth extends Model
{
    protected $fillable = [
        'taobao_user_id',
        'taobao_user_nick',
        'access_token',
        'status',
        'expire_time',
        'oauth_json',
    ];

    protected $casts = [
        'oauth_json' => 'json'
    ];
}
