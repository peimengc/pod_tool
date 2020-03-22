<?php


namespace App\Services;


use App\DouplusTask;
use App\DouplusTaskBook;
use App\DouyinUser;
use Illuminate\Database\Eloquent\Builder;

class DouplusTaskBookService
{
    /**
     * @var DouplusTaskBook|Builder
     */
    protected $model;

    public function __construct()
    {
        $this->model = new DouplusTaskBook();
    }

    public function save(array $attributes)
    {
        $this->model->insert($this->filterAttributes($attributes)->all());
    }

    protected function filterAttributes(array $attributes)
    {
        $date = now()->toDateTimeString();

        return collect($attributes)->map(function ($attribute) use ($date) {

            return [
                'douyin_auth_id' => $attribute['douplus_task']['douyin_auth_id'],
                'aweme_id' => $attribute['douplus_task']['aweme_id'],
                'aweme_author_id' => $attribute['douplus_task']['aweme_author_id'],
                'product_id' => $attribute['douplus_task']['product_id'],
                'task_id' => $attribute['douplus_task']['task_id'],
                'state' => $attribute['ad_info']['state'],
                'cost' => $attribute['ad_stat']['cost'],
                'cost_inc' => $attribute['ad_stat']['cost'] - $attribute['douplus_task']['cost'],
                'created_at' => $date,
                'updated_at' => $date,
            ];
        });
    }
}
