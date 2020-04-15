<?php

namespace Tests\Feature;

use App\Helpers\Douyin\DouyinApp570Api;
use App\Helpers\Douyin\DouyinWebApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DouyinApiTest extends TestCase
{
    public function testGetAwemePost()
    {
        $cookie = 'sessionid=1a904662ffdfcd8fb565d800c491b00d';
        $api = new DouyinWebApi();

        $res = $api->getAwemePost($cookie);

        $this->assertTrue($res['status_code'] === 0);
    }

    public function testGetSubPid()
    {
        $cookie = 'sessionid=e8385bab1eb25b504855f3b7980945ce';
        $api = new DouyinApp570Api();

        $res = $api->getSubPid($cookie);

        $this->assertTrue($res['status_code'] === 0);
    }

    public function testGetTaskList()
    {
        $cookie = 'sessionid=1f1e33a469390c49a75f705d16f7fb85';
        $api = new DouyinApp570Api();

        $res = $api->taskList($cookie);

        $this->assertTrue($res['status_code'] === 0);
    }

    public function testGetTaskInfo()
    {
        $cookie = 'sessionid=f3e1f0c1131490a3d0eb55295df34f16';
        $task_id = '6815776395084451084';

        $api = new DouyinApp570Api();

        $res = $api->taskInfo($task_id, $cookie);
        dd($res);
        $this->assertTrue($res['status_code'] === 0);
    }

    public function testShopPromotion()
    {
        $aweme_id = '6812555208627932420';

        $api = new DouyinApp570Api();

        $res = $api->getShopPromotion($aweme_id);

        $this->assertTrue($res['status_code'] === 0);
    }
}
