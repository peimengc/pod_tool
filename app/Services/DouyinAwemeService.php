<?php


namespace App\Services;


use App\DouyinAweme;
use App\Helpers\Douyin\DouyinApp570Api;
use Illuminate\Database\Eloquent\Builder;

class DouyinAwemeService
{

    /**
     * @var DouyinAweme|Builder
     */
    protected $douyinAweme;

    public function __construct()
    {
        $this->douyinAweme = new DouyinAweme();
    }

    public function save($attributes)
    {
        $attributes = $this->filterAttributes($attributes);
        $allAwemeId = $attributes->pluck('aweme_id');

        $existsAwemeId = $this->getExistsAwemeId($allAwemeId);

        $this->douyinAweme->insert($attributes->whereNotIn('aweme_id', $existsAwemeId)->all());

        //所有都已存在则不需要下一页
        return $existsAwemeId->count() !== $allAwemeId->count();
    }

    protected function getExistsAwemeId($allAwemeId)
    {
        return $this->douyinAweme->whereIn('aweme_id', $allAwemeId)->pluck('aweme_id');
    }

    public function filterAttributes(array $attributes)
    {
        $date = now()->toDateTimeString();

        $api = new DouyinApp570Api();

        return collect($attributes)->map(function ($item) use ($date, $api) {
            return [
                'aweme_id' => $item['aweme_id'],
                'author_user_id' => $item['author_user_id'],
                'product_id' => $api->getShopPromotion($item['aweme_id']),
                'desc' => $item['desc'],
                'create_time' => $item['create_time'],
                'cover' => $item['video']['cover']['url_list'][0],
                'share_url' => $item['share_url'],
                'is_private' => $item['status']['is_private'],
                'with_goods' => $item['status']['with_goods'],
                'forward_count' => $item['statistics']['forward_count'],
                'comment_count' => $item['statistics']['comment_count'],
                'digg_count' => $item['statistics']['digg_count'],
                'play_count' => $item['statistics']['play_count'],
                'share_count' => $item['statistics']['share_count'],
                'created_at' => $date,
                'updated_at' => $date,
            ];
        });
    }
}
