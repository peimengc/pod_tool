<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlimamaOrder extends Model
{
    //12-付款，13-关闭，14-确认收货，3-结算成功
    const TK_STATUS_CLOSED = 13;
    const TK_STATUS_PAID = 3;
    const TK_STATUS_PAYMENT = 12;
    const TK_STATUS_GET = 14;
}
