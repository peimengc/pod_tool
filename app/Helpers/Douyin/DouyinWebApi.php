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
        $cookies = null;

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

                $res = [
                    'data' => compact('status'),
                ];
                break;
            default:
                throw new \Exception('抖音二维码登录异常');
        }

        return [$res, $cookies];
    }

    /**
     * 根据cookie获取userinfo
     * @param $cookieStr
     * @return array
     */
    public function getUserInfo($cookieStr)
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

        return json_decode($response, 1);
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
     * 获取视频列表
     * @param $cookie
     * @param int $max_cursor 分页数据,原样传
     * @return mixed
     */
    public function getAwemePost($cookie,$max_cursor=0)
    {
        $query = [
            'scene' => 'mix',
            'status' => '1',
            'count' => '12',
            'max_cursor' => $max_cursor
        ];

        $resJson = (new Client())->request('get',config('douyin_api.web_api.media_aweme_post'),[
            'query' => $query,
            'headers' => [
                'Cookie' => $cookie,
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36',
            ]
        ])->getBody()->getContents();

        return json_decode($resJson,1);
    }
}
