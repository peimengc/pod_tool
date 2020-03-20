<?php

namespace App\Console\Commands;

use App\DouyinUser;
use App\Jobs\GetTaskListPodcast;
use App\Services\DouyinUserService;
use Illuminate\Console\Command;

class GetTaskList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'douyin:get-task-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '运行获取抖音投放列表job';

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
                GetTaskListPodcast::dispatch($douyinUser);
            });
    }
}
