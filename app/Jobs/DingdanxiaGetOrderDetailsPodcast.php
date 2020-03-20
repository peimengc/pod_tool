<?php

namespace App\Jobs;

use App\Exceptions\DingdanxiaException;
use App\Helpers\DingdanxiaApi;
use App\Services\AlimamaOrderService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class DingdanxiaGetOrderDetailsPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $auth_id;
    public $start_time;
    public $end_time;
    public $tk_status;
    public $query_type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($auth_id, $start_time, $end_time, $tk_status, $query_type)
    {
        $this->auth_id = $auth_id;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->tk_status = $tk_status;
        $this->query_type = $query_type;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \App\Exceptions\DingdanxiaException
     */
    public function handle()
    {
        $api = new DingdanxiaApi();
        $service = new AlimamaOrderService();

        $data = [];

        $positionIndex = null;
        $pageNo = 1;

        try {
            do {
                $resArr = $api->tbkOrderDetails([
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                    'tk_status' => $this->tk_status,
                    'query_type' => $this->query_type,
                    'tb_auth_id' => $this->auth_id,
                    'position_index' => $positionIndex,
                    'page_no' => $pageNo,
                ]);

                $data = array_merge($data, Arr::wrap($resArr['data']));
                $pageNo++;
                $positionIndex = $resArr['position_index'];
            } while ($resArr['has_next']);

            $service->save($data,$this->auth_id);

        } catch (DingdanxiaException $exception) {

            if ($data) {
                $service->save($data,$this->auth_id);
            }

            throw new DingdanxiaException($exception->getMessage());
        }
    }
}
