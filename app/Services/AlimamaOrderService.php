<?php


namespace App\Services;


use App\AlimamaOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AlimamaOrderService
{
    /**
     * @var AlimamaOrder |Builder
     */
    public $model;

    public function __construct()
    {
        $this->model = new AlimamaOrder();
    }

    public function save($attributes, $tk_auth_id)
    {
        $attributes = $this->filterAttributes($attributes, $tk_auth_id);

        $allTradeIds = $attributes->pluck('trade_id');

        $existsTardeIds = $this->getExistsTradeId($allTradeIds);

        //添加为录入的订单
        $this->model->insert($attributes->whereNotIn('trade_id', $existsTardeIds)->all());

        //获取失效的trade_id
        $closedTradeIds = $attributes->whereIn('trade_id', $existsTardeIds)
            ->where('tk_status', AlimamaOrder::TK_STATUS_CLOSED)
            ->pluck('trade_id');

        //更新失效
        $this->model->whereIn('trade_id', $closedTradeIds)
            ->where('tk_status', '!=', AlimamaOrder::TK_STATUS_CLOSED)
            ->update(['tk_status' => AlimamaOrder::TK_STATUS_CLOSED]);
    }

    public function filterAttributes($attributes, $tk_auth_id)
    {
        $adzoneIdArr = app(DouyinUserService::class)->pluck('id', 'tb_adzone_id');

        return collect($attributes)->map(function ($item) use ($tk_auth_id, $adzoneIdArr) {
            $item['tk_auth_id'] = $tk_auth_id;
            $item['douyin_user_id'] = Arr::get($adzoneIdArr, $item['adzone_id']);
            return $item;
        });
    }

    protected function getExistsTradeId($tradeIds)
    {
        return $this->model->whereIn('trade_id', $tradeIds)->pluck('trade_id');
    }
}
