<?php

namespace App\Jobs;

use App\Events\DouyinCookieInvalid;
use App\Exceptions\DouyinException;
use App\Helpers\Douyin\DouyinApp570Api;
use App\Helpers\Douyin\DouyinWebApi;
use App\Services\DouyinUserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class UpdateDouyinUserPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = new DouyinUserService();
        $api = new DouyinWebApi();
        $apiApp = new DouyinApp570Api();

        $service->getWorkAccount()->each(function ($user) use ($service, $api, $apiApp) {
            try {
                $res = $api->getUserInfo($user->sessionid);
                $pid = $apiApp->getSubPid($user->sessionid);

                $service->update($user, $res['user']);
                $service->updateSubPid($user, $pid['data']['sub_pid']);
            } catch (DouyinException $douyinException) {
                $resArr = json_decode($douyinException->getMessage(), 1);
                //cookie失效
                if (Arr::get($resArr, 'status_code') === 8) {
                    event(new DouyinCookieInvalid($user));
                }
            }
        });
    }
}
