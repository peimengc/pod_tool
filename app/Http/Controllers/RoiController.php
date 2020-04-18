<?php

namespace App\Http\Controllers;

use App\AlimamaOrder;
use App\DouplusTaskBook;
use App\DouyinAweme;
use App\DouyinUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoiController extends Controller
{
    public function hour(DouyinUser $douyinUser, Request $request)
    {
        $date = $request->query('date', now()->toDateString());

        $awemes = DouyinAweme::query()
            ->whereHas('taskBooks', function ($builder) use ($date, $douyinUser) {
                $builder->whereDate('douplus_task_books.created_at', $date)
                    ->where('douplus_task_books.aweme_author_id', $douyinUser->dy_uid);
            })
            ->orderBy('create_time', 'desc')
            ->limit(3)
            ->get();

        $taskBook = DouplusTaskBook::query()
            ->selectRaw('
                date_format(created_at,\'%H:00\') as hour,
                cost_inc as cost,
                0 as order_amount,
                0 as tk_status,
                0 as num
            ')
            ->whereDate('douplus_task_books.created_at', $date)
            ->where('douplus_task_books.aweme_author_id', $douyinUser->dy_uid);

        $order = AlimamaOrder::query()
            ->selectRaw('
                date_format(tk_create_time,\'%H:00\') as hour,
                0 as cost,
                pub_share_pre_fee*0.9 as pub_share_pre_fee,
                1 as num,
                tk_status
            ')
            ->whereDate('alimama_orders.tk_create_time', $date)
            ->where('alimama_orders.douyin_user_id', $douyinUser->id)
            ->unionAll($taskBook);

        $roi = DB::query()
            ->selectRaw('
                hour,
                sum(cost) as cost,
                sum(pub_share_pre_fee) as total_amount,
                sum(num) as total_num,
                sum(case when tk_status = 0 || tk_status = ' . AlimamaOrder::TK_STATUS_CLOSED . ' then 0 else pub_share_pre_fee end) as valid_amount,
                sum(case when tk_status = 0 || tk_status = ' . AlimamaOrder::TK_STATUS_CLOSED . ' then 0 else 1 end) as valid_num,
                sum(case when tk_status = ' . AlimamaOrder::TK_STATUS_CLOSED . ' then pub_share_pre_fee else 0 end) as invalid_amount,
                sum(case when tk_status = ' . AlimamaOrder::TK_STATUS_CLOSED . ' then 1 else 0 end) as invalid_num
            ')
            ->fromSub($order, 'order')
            ->groupBy('hour')
            ->orderByDesc('hour')
            ->get();
        //合计
        $roiSum = [
            'cost' => $roi->sum('cost'),
            'total_amount' => $roi->sum('total_amount'),
            'total_num' => $roi->sum('total_num'),
            'valid_amount' => $roi->sum('valid_amount'),
            'valid_num' => $roi->sum('valid_num'),
            'invalid_amount' => $roi->sum('invalid_amount'),
            'invalid_num' => $roi->sum('invalid_num'),
        ];

        return view('roi.hour', compact('roi', 'douyinUser', 'roiSum', 'awemes'));
    }
}
