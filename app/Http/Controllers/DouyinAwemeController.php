<?php

namespace App\Http\Controllers;

use App\DouyinAweme;
use App\Services\DouyinUserService;
use Illuminate\Http\Request;

class DouyinAwemeController extends Controller
{
    public function index(Request $request, DouyinUserService $douyinUserService)
    {
        $awemes = DouyinAweme::query()
            ->when($request->query('author_user_id'), function ($builder, $author_user_id) {
                $builder->whereIn('author_user_id', $author_user_id);
            })
            ->when($request->query('aweme'), function ($builder, $aweme) {
                if ($aweme_id = getAwemeIdByUrl($aweme)) {
                    $builder->where('aweme_id', $aweme_id);
                } else {
                    $builder->where('desc', 'like', "%{$aweme}%");
                }
            })
            ->orderByDesc('create_time')
            ->paginate();

        $douyinUsers = $douyinUserService->all(['dy_nickname', 'dy_uid', 'dy_short_id', 'dy_unique_id']);

        return view('douyin_aweme.index', compact('awemes', 'douyinUsers'));
    }

    public function tasks(DouyinAweme $aweme)
    {
        $tasks = $aweme->tasks()->date()->orderByDesc('create_time')->paginate();

        return view('douyin_aweme.tasks', compact('tasks', 'aweme'));
    }
}
