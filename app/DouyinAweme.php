<?php

namespace App;

use App\Scopes\DateScopeTrait;
use Illuminate\Database\Eloquent\Model;

class DouyinAweme extends Model
{
    use DateScopeTrait;

    protected $casts = [
        'create_time' => 'datetime'
    ];


    public function defaultStartDate()
    {
        return now()->toDateString();
    }

    protected function getDateField()
    {
        return 'create_time';
    }
}
