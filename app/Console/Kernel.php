<?php

namespace App\Console;

use App\Jobs\UpdateDouyinUserPodcast;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //提供任务和队列等待时间和吞吐量信息
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        //定时获取抖音投放任务
        $schedule->command('douyin:get-task-list')->everyFiveMinutes();
        //定时获取抖音消耗详情
        $schedule->command('douyin:get-task-info')->everyFifteenMinutes();
        //获取淘宝订单
        $schedule->command('dingdanxia:get-order-details')->everyFiveMinutes();
        //定时获取账号视频
        $schedule->command('douyin:get-aweme-post')->everyFiveMinutes();
        //定时更新抖音账号信息
        $schedule->job(new UpdateDouyinUserPodcast())->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
