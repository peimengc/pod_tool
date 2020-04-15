<?php

namespace App\Http\Controllers;

use App\Services\AlimamaOrderService;
use App\Services\DouyinUserService;
use Illuminate\Http\Request;

class AlimamaOrderController extends Controller
{

    protected $service;

    public function __construct(AlimamaOrderService $service)
    {
        $this->service = $service;
    }

    public function index(DouyinUserService $douyinUserService)
    {
        $orders = $this->service->paginate();

        $douyinUsers = $douyinUserService->all(['dy_nickname', 'id', 'dy_short_id', 'dy_unique_id']);

        return view('alimama_order.index',compact('orders','douyinUsers'));
    }
}
