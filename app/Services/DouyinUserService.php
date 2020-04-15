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

    public function create($cookie, array $user, $type = 2)
    {
        $attr = $this->filterUserInfoRes($user) + ['dy_cookie' => $cookie, 'type' => $type];

        return $this->douyinUser->create($attr);
    }

    public function update($id, array $user, $cookie = null, $type = null)
    {
        if ($id instanceof DouyinUser) {
            $model = $id;
        } else {
            $model = $this->find($id);
        }

        $attr = $this->filterUserInfoRes($user);

        $cookie ? $attr['dy_cookie'] = $cookie : null;
        $type ? $attr['type'] = $type : null;

        $model->fill($attr)->save();

        return $model;
    }

    /**
     * 过滤api response
     * @param array $user
     * @return array
     */
    public function filterUserInfoRes(array $user)
    {
        return [
            'dy_avatar_url' => $user['avatar_thumb']['url_list'][0],
            'dy_uid' => $user['uid'],
            'dy_unique_id' => $user['unique_id'],
            'dy_short_id' => $user['short_id'],
            'dy_nickname' => $user['nickname'],
            'favorited' => $user['total_favorited'],
            'follower' => $user['follower_count'],
        ];
    }

    /**
     * 更新淘宝pid
     * @param $id
     * @param $subPid
     * @return DouyinUser|Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function updateSubPid($id, $subPid)
    {
        if ($id instanceof DouyinUser) {
            $model = $id;
        } else {
            $model = $this->find($id);
        }

        $model->tb_sub_pid = $subPid;
        $model->save();

        return $model;
    }

    /**
     * @param $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        return $this->douyinUser->findOrFail($id);
    }

    /**
     * @param array $where
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByWhere(array $where)
    {
        return $this->douyinUser->where($where)->get();
    }

    /**
     * 获取投产账号
     */
    public function getWorkAccount()
    {
        return $this->douyinUser
            ->where('type', DouyinUser::TYPE_WORK)
            ->whereNotNull('dy_cookie')
            ->get();
    }

    public function pluck($column, $key = null)
    {
        return $this->douyinUser
            ->pluck($column, $key);
    }
}
