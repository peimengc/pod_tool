<?php


namespace App\Helpers\Douyin;


use App\Exceptions\DouyinException;
use App\Exceptions\XgException;
use GuzzleHttp\Client;

class DouyinApp570Api
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function taskList($cookie, $page = 1, $limit = 30)
    {
        $query = [
            'page' => $page,
            'limit' => $limit,
            'pay_status' => '0',
            'retry_type' => 'no_retry',
            'iid' => '108394680254',
            'device_id' => '67947929528',
            'ac' => 'wifi',
            'channel' => 'wandoujia_aweme1',
            'aid' => '1128',
            'app_name' => 'aweme',
            'version_code' => '570',
            'version_name' => '5.7.0',
            'device_platform' => 'android',
            'ssmix' => 'a',
            'device_type' => 'MX6',
            'device_brand' => 'Meizu',
            'language' => 'zh',
            'os_api' => '25',
            'os_version' => '7.1.1',
            'uuid' => '863328035679803',
            'openudid' => 'fa779aa3cc5ad731',
            'manifest_version_code' => '570',
            'resolution' => '1080*1920',
            'dpi' => '480',
            'update_version_code' => '5702',
            '_rticket' => '1584681608215',
            'ts' => '1584681607',
            'js_sdk_version' => '1.13.10',
            'as' => 'a1b565c7e748ee92e42000',
            'cp' => '5b8de15a78437122e1KeSi',
            'mas' => '01441fc37be363e678931ccc1b1ebed1f70c0c0c4c2ca64c9ca6a6'
        ];

        $resJson = $this->client->request(
            'GET',
            config('douyin_api.app_api.douplus_list'),
            [
                'query' => $query,
                'headers' => [
                    'User-Agent' => 'com.ss.android.ugc.aweme/570 (Linux; U; Android 7.1.1; zh_CN; MX6; Build/NMF26O; Cronet/58.0.2991.0)',
                    'Cookie' => $cookie
                ]
            ]
        )->getBody()->getContents();

        $resArr = json_decode($resJson, 1);

        if ($resArr['status_code'] === 0) {
            return $resArr;
        }

        throw new DouyinException($resJson);
    }

    public function taskInfo($task_id, $cookie)
    {
        $query = [
            'task_id' => $task_id,
            'retry_type' => 'no_retry',
            'iid' => '108559877914',
            'device_id' => '67947929528',
            'ac' => 'wifi',
            'channel' => 'wandoujia_aweme1',
            'aid' => '1128',
            'app_name' => 'aweme',
            'version_code' => '570',
            'version_name' => '5.7.0',
            'device_platform' => 'android',
            'ssmix' => 'a',
            'device_type' => 'MX6',
            'device_brand' => 'Meizu',
            'language' => 'zh',
            'os_api' => '23',
            'os_version' => '6.0',
            'uuid' => '863328035679803',
            'openudid' => 'fda26571d3114761',
            'manifest_version_code' => '570',
            'resolution' => '1080*1920',
            'dpi' => '480',
            'update_version_code' => '5702',
            '_rticket' => '1584798862220',
            'mcc_mnc' => '46000',
            'ts' => '1584798863',
            'js_sdk_version' => '1.13.10',
            'as' => 'a1e5a1170f68de3cd64333',
            'cp' => '178dea58f46177cce1OaWe',
            'mas' => '01da73bae966d4f9ab674ae8dac22bf3c5cccccc2c6c26c6cca626'
        ];

        $xg = $this->getXg($this->getUrl(config('douyin_api.app_api.douplus_info'), $query));

        $resJson = $this->client->request(
            'GET',
            $xg['url'],
            [
                'headers' => [
                    'User-Agent' => 'com.ss.android.ugc.aweme/570 (Linux; U; Android 7.1.1; zh_CN; MX6; Build/NMF26O; Cronet/58.0.2991.0)',
                    'Cookie' => $cookie,
                    'X-Gorgon' => $xg['gorgon'],
                    'X-Khronos' => $xg['khronos'],
                ]
            ]
        )->getBody()->getContents();

        $resArr = json_decode($resJson, 1);

        if ($resArr['status_code'] === 0) {
            return $resArr;
        }

        throw new DouyinException($resJson);
    }

    protected function getUrl($url, array $query)
    {
        return $url . '?' . http_build_query($query);
    }

    protected function getXg($url)
    {
        $resJson = $this->client->request(
            'GET',
            '47.114.43.205:47101/api?url=' . urlencode($url)
        )->getBody()->getContents();

        $resArr = json_decode($resJson, 1);

        if ($resArr['status'] === 1) {
            return $resArr;
        }

        throw new XgException($resJson);
    }
}
