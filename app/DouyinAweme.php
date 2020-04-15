<?php

namespace App;

use App\Scopes\DateScopeTrait;
use Illuminate\Database\Eloquent\Model;

class DouyinAweme extends Model
{

    protected $casts = [
        'create_time' => 'datetime'
    ];

    public function tasks()
    {
        return $this->hasMany(DouplusTask::class,'aweme_id','aweme_id');
    }
}
