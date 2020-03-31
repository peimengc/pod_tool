<?php


namespace App\Services;


use App\AlimamaOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

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
        $date = now()->toDateTimeString();
        return collect($attributes)->map(function ($item) use ($tk_auth_id, $adzoneIdArr, $date) {
            $attr = [];

            $attr['tk_auth_id'] = $tk_auth_id;
            $attr['douyin_user_id'] = Arr::get($adzoneIdArr, $item['adzone_id']);
            $attr['created_at'] = $date;
            $attr['updated_at'] = $date;

            foreach ($this->model->getFillable() as $value) {
                $attr[$value] = Arr::get($item, $value);
            }

            return $attr;
        });
    }

    protected function getExistsTradeId($tradeIds)
    {
        return $this->model->whereIn('trade_id', $tradeIds)->pluck('trade_id');
    }

    public function paginate($perPage = null, $columns = ['*'])
    {
        return $this->model
            ->with('douyinUser')
            ->scopes(['date'])
            ->when(request('tk_status'), function ($builder, $tk_status) {
                $builder->whereIn('tk_status', Arr::wrap($tk_status));
            })
            ->when(request('douyin_user_id'), function ($builder, $douyin_user_id) {
                $builder->whereIn('douyin_user_id', Arr::wrap($douyin_user_id));
            })
            ->orderByDesc('tk_create_time')
            ->paginate($perPage, $columns)
            ->appends(request()->all());
    }
}
