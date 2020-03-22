<?php

namespace App\Jobs;

use App\DouplusTask;
use App\DouyinUser;
use App\Events\DouyinCookieInvalid;
use App\Exceptions\DouyinException;
use App\Helpers\Douyin\DouyinApp570Api;
use App\Services\DouplusTaskBookService;
use App\Services\DouplusTaskService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetTaskInfoPodcast implements ShouldQueue
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
        $taskService = new DouplusTaskService();
        $taskBookService = new DouplusTaskBookService();
        $api = new DouyinApp570Api();

        $data = [];

        try {
            $this->douyinUser->douplusTasks()
                ->whereNotIn('state', [DouplusTask::STATE_OVER, DouplusTask::STATE_REJECT])
                ->orWhereNull('cost')
                ->each(function (DouplusTask $douplusTask) use ($api, $taskService, &$data) {

                    $resArr = $api->taskInfo($douplusTask->task_id, $this->douyinUser->sessionid);

                    $resArr['douplus_task'] = $douplusTask->toArray();

                    $data[] = $resArr;

                    $taskService->updateByTaskInfo($douplusTask, $resArr);

                });

            $taskBookService->save($data);

        } catch (DouyinException $exception) {

            $taskBookService->save($data);

            $resArr = json_decode($exception->getMessage(), 1);

            //cookie失效
            if (Arr::get($resArr, 'status_code') === 8) {
                event(new DouyinCookieInvalid($this->douyinUser));
            }

            throw new DouyinException($exception->getMessage());
        }

    }
}
