<?php

return [
    'web_api' => [
        //获取抖音用户信息
        'media_user_info' => 'https://media.douyin.com/web/api/media/user/info/',
        'get_qrcode' => 'https://creator.douyin.com/passport/web/get_qrcode/?next=https:%2F%2Fcreator.douyin.com%2F&aid=2906',
        'check_qrconnect' => 'https://creator.douyin.com/passport/web/check_qrconnect/?next=https:%2F%2Fcreator.douyin.com%2F&aid=2906&token=',
        'media_aweme_post'=>'https://media.douyin.com/web/api/media/aweme/post/'
    ],
    'app_api' => [
        'douplus_list' => 'https://api-lq.amemv.com/aweme/v2/douplus/ad/list/',
        'douplus_info' => 'https://api-lq.amemv.com/aweme/v2/douplus/ad/',
    ]
];
