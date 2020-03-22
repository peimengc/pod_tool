<?php


namespace App\Helpers;


use App\Exceptions\DingdanxiaException;
use GuzzleHttp\Client;

class DingdanxiaApi
{
    public $api_key;
    public $client;

    public function __construct()
    {
        $this->api_key = config('dingdanxia.api_key');
        $this->client = new Client();
    }

    public function tbkOrderDetails($params = [])
    {
        $formParams = [
            'apikey' => $this->api_key,
            'start_time' => null,
            'end_time' => null,
            'page_size' => 100,
            'page_no' => 1,
        ];

        $resJson = $this->client->request(
            'POST',
            config('dingdanxia.api.tbk_order_details'),
            [
                'form_params' => array_merge($formParams,$params)
            ]
        )->getBody()->getContents();

        $resArr = json_decode($resJson, 1);

        if ($resArr['code'] === 200) {
            return $resArr;
        }

        throw new DingdanxiaException(json_encode($resArr));
    }
}
