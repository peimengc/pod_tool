<?php

namespace App\Http\Controllers;

use App\DouyinAweme;
use App\Services\DouyinUserService;
use Illuminate\Http\Request;

class DouyinAwemeController extends Controller
{
    public function index(Request $request)
    {
        $awemes = DouyinAweme::query()
            ->when($request->query('author_user_id'), function ($builder, $author_user_id) {
                $builder->where('author_user_id', $author_user_id);
            })
            ->orderByDesc('create_time')->paginate();
        $douyinUsers = app(DouyinUserService::class)->pluck('dy_nickname', 'dy_uid');

        return view('douyin_aweme.index', compact('awemes', 'douyinUsers'));
    }
}
