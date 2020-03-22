<?php

namespace App\Console\Commands;

use App\DouyinUser;
use App\Jobs\GetTaskInfoPodcast;
use App\Services\DouyinUserService;
use Illuminate\Console\Command;

class GetTaskInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'douyin:get-task-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '运行抖音投放详情job';

    /**
     * @var DouyinUserService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
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
        $this->service->getWorkAccount()
            ->each(function (DouyinUser $douyinUser) {
                GetTaskInfoPodcast::dispatch($douyinUser);
            });
    }
}
