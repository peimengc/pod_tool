<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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


    public function setTbSubPidAttribute($value)
    {
        $this->attributes['tb_sub_pid'] = $value;
        $this->attributes['tb_adzone_id'] = $value ? explode('_', $value)[3] : null;
    }

    public function getSessionidAttribute()
    {
        return 'sessionid=' . ($this->dy_cookie['sessionid'] ?? '');
    }

    public function douplusTasks()
    {
        return $this->hasMany(DouplusTask::class, 'douyin_auth_id', 'id');
    }

    public function scopeNickname(Builder $builder, $nickname = null)
    {
        $builder->when($nickname ?: request('keywords'), function (Builder $builder, $keywords) {
            $builder->where('dy_nickname', 'like', "%{$keywords}%");
        });
    }

    public function getUniqueShortIdAttribute()
    {
        return $this->dy_unique_id ?: $this->dy_short_id;
    }

}
