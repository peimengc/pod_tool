<?php

namespace App\Jobs;

use App\DouyinUser;
use App\Events\DouyinCookieInvalid;
use App\Exceptions\DouyinException;
use App\Helpers\Douyin\DouyinApp570Api;
use App\Services\DouplusTaskService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class GetTaskListPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var DouyinUser
     */
    protected $douyinUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DouyinUser $douyinUser)
    {
        $this->douyinUser = $douyinUser;
    }

    /**
     * @throws DouyinException
     */
    public function handle()
    {
        $douplusTaskService = new DouplusTaskService();
        $api = new DouyinApp570Api();
        $page = 1;

        try {

            do {
                //获取list
                $taskList = $api->taskList($this->douyinUser->sessionid, $page);
                //下一页
                $page++;

                //存储并返回是否需要下一页
            } while ($douplusTaskService->save($this->douyinUser, $taskList['ad_list_full']));

        } catch (DouyinException $douyinException) {

            $resArr = json_decode($douyinException->getMessage(), 1);

            //cookie失效
            if (Arr::get($resArr, 'status_code') === 8) {
                event(new DouyinCookieInvalid($this->douyinUser));
            }

            throw new DouyinException($douyinException->getMessage());
        }


    }
}
