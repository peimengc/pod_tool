<?php

namespace App\Jobs;

use App\DouyinAweme;
use App\DouyinUser;
use App\Events\DouyinCookieInvalid;
use App\Helpers\Douyin\DouyinWebApi;
use App\Services\DouyinAwemeService;
use App\Services\DouyinUserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class GetAwemePostPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $douyinUsers;

    public function __construct(Collection $douyinUsers)
    {
        $this->douyinUsers = $douyinUsers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = new DouyinWebApi();
        $service = new DouyinAwemeService();

        $this->douyinUsers->each(function (DouyinUser $douyinUser) use ($api, $service) {

                $data = $api->getAwemePost($douyinUser->sessionid);

                if (Arr::get($data, 'status_code') === 8) {
                    event(new DouyinCookieInvalid($douyinUser));
                    return;
                }

                $service->save($data['aweme_list']);
            });


    }
}
