<?php


namespace App\Services;


use App\DouplusTask;
use App\DouyinUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class DouplusTaskService
{
    /**
     * @var DouplusTask|Builder
     */
    protected $douplusTask;

    public function __construct()
    {
        $this->douplusTask = new DouplusTask();
    }

    public function updateByTaskInfo(DouplusTask $douplusTask, $attr)
    {
        $douplusTask->fill([
            'state' => $attr['ad_info']['state'],
            'cost' => $attr['ad_stat']['cost'],
            'state_desc' => $attr['ad_info']['state_desc'],
            'reject_reason' => $attr['ad_info']['extra']['reject_reason'] ?? '',
            'duration' => $attr['ad_info']['duration'],
        ])->save();
    }

    public function save(DouyinUser $douyinUser, array $attributes)
    {
        $attributes = $this->filterAttributes($douyinUser, $attributes);

        $allTaskId = $attributes->pluck('task_id');

        $existsTaskId = $this->getExistsTaskId($allTaskId);

        $this->douplusTask->insert($attributes->whereNotIn('task_id', $existsTaskId)->all());

        //所有都已存在则不需要下一页
        return $existsTaskId->count() !== $allTaskId->count();

    }

    protected function getExistsTaskId($taskIds)
    {
        return $this->douplusTask->whereIn('task_id', $taskIds)->pluck('task_id');
    }

    protected function filterAttributes(DouyinUser $douyinUser, array $attributes)
    {
        $date = now()->toDateTimeString();

        $attrCollection = collect($attributes);

        $productIds = (new DouyinAwemeService())->getProductIds($attrCollection->pluck('ad_info.item_id'));

        return $attrCollection->map(function ($item) use ($douyinUser, $date, $productIds) {
            return [
                'douyin_auth_id' => $douyinUser->id,
                'aweme_id' => $item['ad_info']['item_id'],
                'aweme_author_id' => $item['ad_info']['item_author_id'],
                'product_id' => Arr::get($productIds, $item['ad_info']['item_id']),
                'task_id' => $item['ad_info']['task_id'],
                'state' => $item['ad_info']['state'],
                'budget' => $item['ad_info']['budget_int'] / 1000,
                'create_time' => $item['ad_info']['create_time'],
                'reject_reason' => $item['ad_info']['extra']['reject_reason'] ?? '',
                'state_desc' => $item['ad_info']['state_desc'],
                'created_at' => $date,
                'updated_at' => $date,
            ];
        });
    }
}
