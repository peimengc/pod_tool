<?php

namespace App\Http\Controllers;

use App\AlimamaOrder;
use App\DouplusTaskBook;
use App\DouyinUser;

class RoiRankController extends Controller
{
    public function account()
    {
        $taskBookQuery = DouplusTaskBook::query()
            ->selectRaw('
                aweme_author_id,
                sum(cost_inc) as cost
            ')
            ->scopes(['date'])
            ->groupBy('aweme_author_id');

        $orderQuery = AlimamaOrder::query()
            ->selectRaw('
                douyin_user_id,
                sum(pub_share_pre_fee*0.9) as total_amount,
                count(*) as total_num,
                sum(case when tk_status = ' . AlimamaOrder::TK_STATUS_CLOSED . ' then 0 else pub_share_pre_fee*0.9 end) as valid_amount,
                sum(case when tk_status = ' . AlimamaOrder::TK_STATUS_CLOSED . ' then 0 else 1 end) as valid_num,
                sum(case when tk_status = ' . AlimamaOrder::TK_STATUS_CLOSED . ' then pub_share_pre_fee*0.9 else 0 end) as invalid_amount,
                sum(case when tk_status = ' . AlimamaOrder::TK_STATUS_CLOSED . ' then 1 else 0 end) as invalid_num,
                sum(case when pub_share_pre_fee=\'0.00\' && tk_status = ' . AlimamaOrder::TK_STATUS_CLOSED . ' then 1 else 0 end) as refund_num
            ')
            ->scopes(['date'])
            ->groupBy('douyin_user_id');

        $accounts = DouyinUser::query()
            ->leftjoinSub($taskBookQuery, 'atb', 'douyin_users.dy_uid', '=', 'atb.aweme_author_id')
            ->leftjoinSub($orderQuery, 'ao', 'douyin_users.id', '=', 'ao.douyin_user_id')
            ->scopes(['nickname'])
            ->orderByDesc('total_num')
            ->paginate()
            ->appends(\request()->all());

        return view('roi_rank.account', compact('accounts'));
    }
}
