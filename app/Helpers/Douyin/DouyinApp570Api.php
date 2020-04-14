<?php


namespace App\Helpers\Douyin;


use App\Exceptions\DouyinException;
use App\Exceptions\XgException;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class DouyinApp570Api
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * 获取淘宝sub_pid
     * @param $cookie
     * @return array
     */
    public function getSubPid($cookie)
    {
        $query = [
            'version_code' => '8.1.0',
            'pass-region' => '1',
            'pass-route' => '1',
            'js_sdk_version' => '1.32.2.1',
            'app_name' => 'aweme',
            'vid' => '53601C0B-AA28-4270-BE99-CC45410FE646',
            'app_version' => '8.1.0',
            'device_id' => '66493333807',
            'channel' => 'App%20Store',
            'mcc_mnc' => '46002',
            'aid' => '1128',
            'screen_width' => '1125',
            'openudid' => 'e6012c91eff5a4fd33c0b617979c4e498eab218f',
            'os_api' => '18',
            'ac' => 'WIFI',
            'os_version' => '13.0',
            'device_platform' => 'iphone',
            'build_number' => '81017',
            'device_type' => 'iPhone10,3',
            'iid' => '87445999129',
            'idfa' => '51CA298D-F332-4976-8668-DBE8A28A699B',
            'b_type_new' => '2',
            'os' => 'iOS',
            'pid_type' => '1',
            'request_tag_from' => 'h5'
        ];

        $response = (new Client())->request(
            'GET',
            config('douyin_api.app_api.sub_pid'),
            [
                'query' => $query,
                'headers' => [
                    'Cookie' => $cookie
                ]
            ]
        )->getBody()->getContents();

        return json_decode($response, 1);
    }

    public function getShopPromotion($aweme_id)
    {
        $query = [
            'version_code' => '8.1.0',
            'pass-region' => '1',
            'pass-route' => '1',
            'js_sdk_version' => '1.17.4.3',
            'app_name' => 'aweme',
            'vid' => '53601C0B-AA28-4270-BE99-CC45410FE646',
            'app_version' => '8.1.0',
            'device_id' => '66493333807',
            'channel' => 'App%20Store',
            'mcc_mnc' => '46002',
            'aid' => '1128',
            'screen_width' => '1125',
            'openudid' => 'e6012c91eff5a4fd33c0b617979c4e498eab218f',
            'os_api' => '18',
            'ac' => 'WIFI',
            'os_version' => '13.0',
            'device_platform' => 'iphone',
            'build_number' => '81017',
            'device_type' => 'iPhone10,3',
            'iid' => '87445999129',
            'idfa' => '51CA298D-F332-4976-8668-DBE8A28A699B',
            'sec_author_id' => 'MS4wLjABAAAA8h9X7OQ0800M42pkNNO6yYq4JwC0eYUSls7Y8hazV5M',
            'author_id' => '14570499127',
            'aweme_id' => $aweme_id
        ];

        $response = (new Client())->request(
            'GET',
            config('douyin_api.app_api.shop_promotion'),
            [
                'query' => $query,
            ]
        )->getBody()->getContents();

        $res = json_decode($response, 1);

        return Arr::get(json_decode(Arr::get($res, 'promotion'), 1), '0.product_id');
    }

    public function taskList($cookie, $page = 1, $limit = 20)
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

        $xg = $this->getXg($this->getUrl(config('douyin_api.app_api.douplus_list'), $query));

        $resJson = $resJson = $this->xgRequest($xg, $cookie);

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

        $resJson = $this->xgRequest($xg, $cookie);

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

    protected function xgRequest($xg, $cookie, $method = 'get')
    {
        return $this->client->request(
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
    }

    protected function getXg($url)
    {
        $resJson = $this->client->request(
            'GET',
            '59.48.153.185:47106/api?url=' . urlencode($url)
        )->getBody()->getContents();

        $resArr = json_decode($resJson, 1);

        if ($resArr['status'] === 1) {
            return $resArr;
        }

        throw new XgException($resJson);
    }
}
