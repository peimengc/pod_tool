<?php

return [
    'api_key' => env('DING_DAN_XIA_API_KEY'),
    'auth_id' => explode(',', env('DING_DAN_XIA_AUTH_ID','')),
    'api' => [
        'tbk_order_details' => 'http://api.tbk.dingdanxia.com/tbk/order_details',
    ]
];
