<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DouyinUser extends Model
{
    protected $fillable = [
        'type', 'dy_uid', 'dy_unique_id', 'dy_short_id', 'dy_nickname', 'dy_avatar_url',
        'dy_cookie',
        'tb_sub_pid', 'tb_adzone_id',
        'favorited', 'follower', 'aweme_count',
    ];

    protected $casts = [
        'dy_cookie' => 'array',
    ];

    const TYPE_WORK = 1;
    const TYPE_PROFIT = 2;

    public function getSessionidAttribute()
    {
        return 'sessionid=' . ($this->dy_cookie['sessionid'] ?? '');
    }

}
