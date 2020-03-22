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

    public function index()
    {
        $orders = $this->service->paginate();
        $douyinUsers = app(DouyinUserService::class)->pluck('dy_nickname','id');

        return view('alimama_order.index',compact('orders','douyinUsers'));
    }
}
