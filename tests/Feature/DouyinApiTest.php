<?php

namespace Tests\Feature;

use App\Helpers\Douyin\DouyinApp570Api;
use App\Helpers\Douyin\DouyinWebApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DouyinApiTest extends TestCase
{
    public function test570Api()
    {
        $cookie = 'sessionid=ed8f742341199ecc60142e2a06fc7b43';
        $task_id = '6815776395084451084';

//        $cookie = 'sessionid=027f5d98730ad15d8115a7f51f31fd3f';
//        $task_id = '1663945943893015';

        $api = new DouyinApp570Api();

        $res = $api->taskInfo($task_id, $cookie);

        $this->assertTrue($res['status_code'] === 0);
    }

}
