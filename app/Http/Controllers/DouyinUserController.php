<?php

namespace App\Http\Controllers;

use App\DouyinUser;
use App\Helpers\Api\ApiResponse;
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

    public function index(DouyinUser $douyinUser,Request $request)
    {
        $users = $douyinUser->newQuery()
            ->when($request->query('keywords'),function (Builder $builder,$keywords) {
                $builder->where('dy_nickname','like',"%{$keywords}%");
            })
            ->orderByDesc('updated_at')
            ->paginate();

        return view('douyin_user.index',compact('users'));
    }

    public function getQrcode()
    {
        return $this->sucWithData($this->douyinWebApi->getQrcode());
    }

    public function checkQrconnect($token, Request $request, DouyinUser $douyinUser)
    {
        list($res, $attr) = $this->douyinWebApi->checkQrconnect($token);

        if ($attr) {
            $douyinUser->newQuery()
                ->updateOrCreate(Arr::only($attr, ['dy_uid']), $attr + $request->only('type'));
        }

        return $this->sucWithData($res);
    }
}
