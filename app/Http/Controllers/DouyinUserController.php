<?php

namespace App\Http\Controllers;

use App\DouyinUser;
use App\Helpers\Api\ApiResponse;
use App\Helpers\Douyin\DouyinApp570Api;
use App\Helpers\Douyin\DouyinWebApi;
use App\Services\DouyinUserService;
use Illuminate\Http\Request;

class DouyinUserController extends Controller
{
    use ApiResponse;

    public $douyinWebApi;
    public $service;

    public function __construct(DouyinWebApi $douyinWebApi, DouyinUserService $service)
    {
        $this->douyinWebApi = $douyinWebApi;
        $this->service = $service;
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
     * @param DouyinApp570Api $api
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
            //是否存在
            if ($user = $this->service->getByWhere(['dy_uid' => $userInfoRes['user']['uid']])->first()) {
                $this->service->update($user, $userInfoRes['user'], $cookies, $request->query('type'));
            } else {
                $user = $this->service->create($cookies, $userInfoRes['user'], $request->query('type'));
            }
            //淘宝mm码
            $tbSubPidRes = $api->getSubPid($douyinUser->sessionid);

            $this->service->updateSubPid($user, $tbSubPidRes['data']['sub_pid']);
        }

        return $this->sucWithData($res);
    }
}
