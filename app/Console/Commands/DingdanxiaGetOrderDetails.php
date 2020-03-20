<?php

namespace App\Console\Commands;

use App\Jobs\DingdanxiaGetOrderDetailsPodcast;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DingdanxiaGetOrderDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dingdanxia:get-order-details {--ST|start=} {--ET|end=} {--S|status=} {--T|type=} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '订单侠获取淘宝订单';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = $this->option('start');
        $end = $this->option('end');
        $status = $this->option('status');
        $type = $this->option('type');

        if ($start && $end) {
            $start = strtotime($start);
            $end = strtotime($end);
        } else {
            $end = time();
            $start = $end - (60 * 10);
        }
        foreach (config('dingdanxia.auth_id') as $auth_id) {

            do {
                $start_time = $end_time ?? $start;

                $end_time = $start_time + (60 * 60 * 3);

                $end_time = $end > $end_time ? $end_time : $end;

                DingdanxiaGetOrderDetailsPodcast::dispatch($auth_id,
                    date('Y-m-d H:i:s', $start_time),
                    date('Y-m-d H:i:s', $end_time),
                    $status,
                    $type);

            } while ($end > $end_time);

            unset($end_time);
        }
    }
}
