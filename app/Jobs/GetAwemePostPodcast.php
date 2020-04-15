<?php

namespace App\Jobs;

use App\DouyinAweme;
use App\DouyinUser;
use App\Events\DouyinCookieInvalid;
use App\Helpers\Douyin\DouyinWebApi;
use App\Services\DouyinAwemeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class GetAwemePostPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var DouyinUser
     */
    protected $douyinUser;

    /**
     * GetAwemePostPodcast constructor.
     * @param DouyinUser $douyinUser
     */
    public function __construct(DouyinUser $douyinUser)
    {
        $this->douyinUser = $douyinUser;
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

        $data = $api->getAwemePost($this->douyinUser->sessionid);

        if (Arr::get($data, 'status_code') === 8) {
            event(new DouyinCookieInvalid($this->douyinUser));
            return;
        }

        $service->save($data['aweme_list']);

    }
}
