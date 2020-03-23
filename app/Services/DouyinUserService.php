<?php


namespace App\Services;


use App\DouyinUser;
use Illuminate\Database\Eloquent\Builder;

class DouyinUserService
{
    /**
     * @var DouyinUser|Builder
     */
    protected $douyinUser;

    public function __construct()
    {
        $this->douyinUser = new DouyinUser();
    }

    /**
     * 获取投产账号
     */
    public function getWorkAccount()
    {
        return $this->douyinUser/*->where('type', DouyinUser::TYPE_WORK)*/
            ->whereNotNull('dy_cookie')
            ->get();
    }

    public function pluck($column, $key = null)
    {
        return $this->douyinUser
            ->pluck($column, $key);
    }
}
