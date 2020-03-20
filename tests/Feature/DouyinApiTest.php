<?php

namespace Tests\Feature;

use App\Helpers\Douyin\DouyinApp570Api;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DouyinApiTest extends TestCase
{
    public function testGetTaskList()
    {
        $cookie = 'sessionid=1f1e33a469390c49a75f705d16f7fb85';
        $api = new DouyinApp570Api();

        $res = $api->taskList($cookie);
        
        return $this->assertTrue($res['status_code'] === 0);
    }
}
