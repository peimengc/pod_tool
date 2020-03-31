<?php

namespace App\Http\Controllers;

use App\DouyinUser;
use App\Helpers\Api\ApiResponse;
use App\Helpers\Douyin\DouyinApp570Api;
use App\Helpers\Douyin\DouyinWebApi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DouyinUserController extends Controller
{
    use ApiResponse;

    public $douyinWebApi;

    public function __construct(DouyinWebApi $douyinWebApi)
    {
        $this->douyinWebApi = $douyinWebApi;
    }

    public function index(DouyinUser $douyinUser, Request $request)
    {
        $users = $douyinUser->newQuery()
            ->scopes(['nickname'])
            ->orderByDesc('updated_at')
            ->paginate()
            ->appends($request->all());

        return view('douyin_user.index', compact('users'));
    }

    public function getQrcode()
    {
        return $this->sucWithData($this->douyinWebApi->getQrcode());
    }

    /**
     * @param $token
     * @param Request $request
     * @param DouyinUser $douyinUser
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function checkQrconnect($token, Request $request, DouyinUser $douyinUser, DouyinApp570Api $api)
    {
        list($res, $cookies) = $this->douyinWebApi->checkQrconnect($token);

        if ($cookies) {
            $douyinUser->dy_cookie = $cookies;
            //账号信息
            $userInfoRes = $this->douyinWebApi->getUserInfo($douyinUser->sessionid);

            $userInfo = [
                'dy_avatar_url' => $userInfoRes['user']['avatar_thumb']['url_list'][0],
                'dy_uid' => $userInfoRes['user']['uid'],
                'dy_unique_id' => $userInfoRes['user']['unique_id'],
                'dy_short_id' => $userInfoRes['user']['short_id'],
                'dy_nickname' => $userInfoRes['user']['nickname'],
                'favorited' => $userInfoRes['user']['total_favorited'],
                'follower' => $userInfoRes['user']['follower_count'],
                'dy_cookie' => $cookies,
            ];
            //淘宝mm码
            $tbSubPidRes = $api->getSubPid($douyinUser->sessionid);

            $tbSubPid = [
                'tb_sub_pid' => $tbSubPidRes['data']['sub_pid'],
                'tb_adzone_id' => $tbSubPidRes['data']['sub_pid'] ? explode('_', $tbSubPidRes['data']['sub_pid'])[3] : ''
            ];

            $attr = $userInfo + $tbSubPid;

            $douyinUser->newQuery()
                ->updateOrCreate(Arr::only($attr, ['dy_uid']), $attr + $request->only('type'));
        }

        return $this->sucWithData($res);
    }
}
