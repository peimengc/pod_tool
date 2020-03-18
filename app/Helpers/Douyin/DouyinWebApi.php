<?php


namespace App\Helpers\Douyin;

use GuzzleHttp\Client;

class DouyinWebApi
{

    public function getQrcode()
    {
        $resJson = (new Client())->request(
            'GET',
            config('douyin_api.web_api.get_qrcode')
        )->getBody()->getContents();

        $resArr = json_decode($resJson, 1);

        return [
            'data' => [
                'qrcode' => $resArr['data']['qrcode'],
                'token' => $resArr['data']['token']
            ]
        ];
    }

    /**
     * 验证二维码状态,返回内容如下
     * new 正常
     * scanned 已扫码
     * expired 已过期 需包含新的qrcode和token
     * confirmed 已成功
     * return {"data":{"qrcode":"","status":"expired","token":""}}
     * @param string $token
     * @return array
     * @throws \Exception
     */
    public function checkQrconnect(string $token)
    {
        $attr = [];

        $request = (new Client())->request(
            'GET',
            config('douyin_api.web_api.check_qrconnect') . $token
        );

        $resArr = json_decode($request->getBody()->getContents(), 1);

        $status = $resArr['data']['status'];

        switch ($status) {
            case 'new':
            case 'scanned':
                $res = [
                    'data' => compact('status')
                ];
                break;
            case 'expired':
                $res = [
                    'data' => [
                        'status' => $status,
                        'qrcode' => $resArr['data']['qrcode'],
                        'token' => $resArr['data']['token'],
                    ]
                ];
                break;
            case 'confirmed':
                //cookie
                $cookies = $this->getCookies($request->getHeaders());

                $cookieStr = 'sessionid=' . $cookies['sessionid'];
                //账号信息
                $userInfo = $this->getUserInfo($cookieStr, $cookies);
                //淘宝mm码
                $tbSubPid = $this->getSubPid($cookieStr);

                $attr = $userInfo + $tbSubPid;

                $res = [
                    'data' => compact('status'),
                ];
                break;
            default:
                throw new \Exception('抖音二维码登录异常');
        }

        return [$res, $attr];
    }

    /**
     * 根据cookie获取userinfo
     * @param $cookies
     * @return array
     */
    protected function getUserInfo($cookieStr, $cookies)
    {
        $response = (new Client())->request(
            'GET',
            config('douyin_api.web_api.media_user_info'),
            [
                'headers' => [
                    'Cookie' => $cookieStr,
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36',
                ]
            ]
        )->getBody()->getContents();

        $resArr = json_decode($response, 1);

        return [
            'dy_avatar_url' => $resArr['user']['avatar_thumb']['url_list'][0],
            'dy_uid' => $resArr['user']['uid'],
            'dy_unique_id' => $resArr['user']['unique_id'],
            'dy_short_id' => $resArr['user']['short_id'],
            'dy_nickname' => $resArr['user']['nickname'],
            'favorited' => $resArr['user']['total_favorited'],
            'follower' => $resArr['user']['follower_count'],
            'dy_cookie' => $cookies,
        ];

    }

    /**
     * 根据请求头获取cookie
     * @param array $headers
     * @return array
     * @throws \Exception
     */
    protected function getCookies(array $headers)
    {
        $cookies = [];

        foreach ($headers['Set-Cookie'] as $cookie) {

            list($name, $value) = explode('=', explode(';', $cookie)[0]);

            $cookies[$name] = $value;
        }

        return $cookies;
    }

    /**
     * 获取淘宝sub_pid
     * @param $cookies
     * @return array
     */
    protected function getSubPid($cookieStr)
    {
        $response = (new Client())->request(
            'GET',
            'https://lianmeng.snssdk.com/user/subpid/getSubpid?version_code=8.1.0&pass-region=1&pass-route=1&js_sdk_version=1.32.2.1&app_name=aweme&vid=53601C0B-AA28-4270-BE99-CC45410FE646&app_version=8.1.0&device_id=66493333807&channel=App%20Store&mcc_mnc=46002&aid=1128&screen_width=1125&openudid=e6012c91eff5a4fd33c0b617979c4e498eab218f&os_api=18&ac=WIFI&os_version=13.0&device_platform=iphone&build_number=81017&device_type=iPhone10,3&iid=87445999129&idfa=51CA298D-F332-4976-8668-DBE8A28A699B&b_type_new=2&os=iOS&pid_type=1&request_tag_from=h5',
            [
                'headers' => [
                    'Cookie' => $cookieStr,
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36'
                ]
            ]
        )->getBody()->getContents();

        $resArr = json_decode($response, 1);

        return [
            'tb_sub_pid' => $resArr['data']['sub_pid'],
            'tb_adzone_id' => $resArr['data']['sub_pid'] ? explode('_', $resArr['data']['sub_pid'])[3] : ''
        ];

    }
}
