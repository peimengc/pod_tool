<?php

namespace App\Console\Commands;

use App\DouyinUser;
use App\Jobs\GetAwemePostPodcast;
use App\Jobs\GetTaskListPodcast;
use App\Services\DouyinUserService;
use Illuminate\Console\Command;

class GetAwemePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'douyin:get-aweme-post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'media.douyin 获取视频列表';

    /**
     * @var DouyinUserService
     */
    protected $service;

    /**
     * GetAwemePost constructor.
     * @param DouyinUserService $service
     */
    public function __construct(DouyinUserService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->service->getShopAccount()
            ->chunk(20)
            ->each(function ($douyinUsers) {
                GetAwemePostPodcast::dispatch($douyinUsers);
            });
    }
}
