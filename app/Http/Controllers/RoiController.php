<?php

namespace App\Http\Controllers;

use App\AlimamaOrder;
use App\DouplusTaskBook;
use App\DouyinUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoiController extends Controller
{
    public function hour(DouyinUser $douyinUser, Request $request)
    {
        $date = $request->query('date', now()->toDateString());

        $taskBook = DouplusTaskBook::query()
            ->selectRaw('
                date_format(created_at,\'%H:00\') as hour,
                cost_inc as cost,
                0 as order_amount,
                0 as tk_status,
                0 as num
            ')
            ->whereDate('douplus_task_books.created_at', $date)
            ->where('douplus_task_books.aweme_author_id', '1279426502601851');

        $order = AlimamaOrder::query()
            ->selectRaw('
                date_format(tk_create_time,\'%H:00\') as hour,
                0 as cost,
                pub_share_pre_fee*0.9 as order_amount,
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
                sum(order_amount) as total_amount,
                sum(num) as total_num,
                sum(case when tk_status = 0 || tk_status = '.AlimamaOrder::TK_STATUS_CLOSED.' then 0 else order_amount end) as valid_amount,
                sum(case when tk_status = 0 || tk_status = '.AlimamaOrder::TK_STATUS_CLOSED.' then 0 else 1 end) as valid_num,
                sum(case when tk_status = '.AlimamaOrder::TK_STATUS_CLOSED.' then order_amount else 0 end) as invalid_amount,
                sum(case when tk_status = '.AlimamaOrder::TK_STATUS_CLOSED.' then 1 else 0 end) as invalid_num
            ')
            ->fromSub($order, 'order')
            ->groupBy('hour')
            ->orderByDesc('hour')
            ->get();

        return view('roi.hour',compact('roi','douyinUser'));
    }
}
