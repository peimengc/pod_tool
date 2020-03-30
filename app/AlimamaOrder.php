<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AlimamaOrder extends Model
{
    //12-付款，13-关闭，14-确认收货，3-结算成功
    const TK_STATUS_CLOSED = 13;
    const TK_STATUS_PAID = 3;
    const TK_STATUS_PAYMENT = 12;
    const TK_STATUS_GET = 14;

    public static $tkStatusArr = [
        self::TK_STATUS_CLOSED => '已失效',
        self::TK_STATUS_PAID => '已结算',
        self::TK_STATUS_PAYMENT => '已付款',
        self::TK_STATUS_GET => '已收货',
    ];

    protected $fillable = [
//        'douyin_user_id',
//        'tk_auth_id',
        'adzone_id',
        'adzone_name',
        'alimama_rate',
        'alimama_share_fee',
        'alipay_total_price',
        'click_time',
        'deposit_price',
        'flow_source',
        'income_rate',
        'item_category_name',
        'item_id',
        'item_img',
        'item_link',
        'item_num',
        'item_price',
        'item_title',
        'order_type',
        'pub_id',
        'pub_share_fee',
        'pub_share_pre_fee',
        'pub_share_rate',
        'refund_tag',
        'seller_nick',
        'seller_shop_title',
        'site_id',
        'site_name',
        'subsidy_fee',
        'subsidy_rate',
        'subsidy_type',
        'tb_deposit_time',
        'tb_paid_time',
        'terminal_type',
        'tk_commission_fee_for_media_platform',
        'tk_commission_pre_fee_for_media_platform',
        'tk_commission_rate_for_media_platform',
        'tk_create_time',
        'tk_deposit_time',
        'tk_order_role',
        'tk_paid_time',
        'tk_status',
        'tk_total_rate',
        'total_commission_fee',
        'total_commission_rate',
        'trade_id',
        'tk_earning_time',
        'pay_price',
        'special_id',
        'relation_id',
    ];

    public function getFillable()
    {
        return $this->fillable;
    }

    public function getTkStatusDescAttribute()
    {
        return Arr::get(self::$tkStatusArr, $this->tk_status);
    }

    public function getHesitateTimeAttribute()
    {
        return $this->tk_paid_time ? Carbon::parse($this->click_time)->diffForHumans($this->tk_paid_time) : '';
    }

    public function douyinUser()
    {
        return $this->belongsTo(DouyinUser::class, 'douyin_user_id', 'id')
            ->withDefault(['dy_nickname' => '']);
    }
}
