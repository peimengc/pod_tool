@extends('layouts.app')

@inject('orderModel','\App\AlimamaOrder')

@section('content')
    <div class="row bg-white py-4 px-2">
        <div class="col-md-12">
            <h4>订单列表</h4>
            <p>淘宝订单列表，默认展示最近七天内的订单</p>
        </div>
        <div class="col-md-12">
            <form>
                <div class="form-row align-items-center">
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">时间类型</span>
                            </div>
                            <select name="date-type" id="date-type" class="form-control">
                                @foreach($orderModel->dateTypeArr as $k=>$v)
                                    <option @if(request('date-type',$orderModel->defaultDateType)==$k) selected
                                            @endif value="{{$k}}">{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">开始时间</span>
                            </div>
                            <input class="form-control date" id="start-date" name="start-date"
                                   value="{{ request('start-date',$orderModel->defaultStartDate()) }}" type="text"
                                   placeholder="开始时间">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">结束时间</span>
                            </div>
                            <input class="form-control date" id="end-date" name="end-date"
                                   value="{{ request('end-date',$orderModel->defaultEndDate()) }}" type="text"
                                   placeholder="结束时间">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">抖音账号</span>
                            </div>
                            <select name="douyin_user_id" id="douyin_user_id" class="form-control">
                                <option value="">全部抖音号</option>
                                @foreach($douyinUsers as $k=>$v)
                                    <option @if(request('douyin_user_id')==$k) selected
                                            @endif value="{{$k}}">{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">订单状态</span>
                            </div>
                            <select name="tk_status" id="tk_status" class="form-control">
                                <option value="">全部状态</option>
                                @foreach($orderModel->tkStatusArr as $k=>$v)
                                    <option @if(request('tk_status')==$k) selected
                                            @endif value="{{$k}}">{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary mb-2">提交</button>
                        <a href="{{route('alimama_orders.index')}}" class="btn btn-secondary mb-2">清空</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table data-table" style="min-width: 60rem">
                    <thead>
                    <tr>
                        <th scope="col">商品</th>
                        <th scope="col">状态</th>
                        <th scope="col">提成比例</th>
                        <th scope="col">佣金</th>
                        <th scope="col">账号</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <div class="row middle-xs data">
                                    <div class="img" style="background-image: url('{{$order->item_img}}')"></div>
                                    <div class="content">
                                        <a href="{{ $order->item_link }}" target="_blank">
                                            {{ $order->item_title }}
                                        </a><br>
                                        <span>点击时间: {{ $order->click_time }}</span>
                                        <span>犹豫时长: {{ $order->hesitate_time }}</span><br>
                                        <span>创建时间: {{ $order->tk_create_time }}</span><br>
                                        <span>付款时间: {{ $order->tk_paid_time }}</span>
                                        <span>付款金额: {{ $order->alipay_total_price }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $order->tk_status_desc }}</td>
                            <td>{{ $order->tk_total_rate }}%</td>
                            <td>
                                付款预估: {{ $order->pub_share_pre_fee }}<br>
                            </td>
                            <td>{{ $order->douyinUser->dy_nickname }} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            {{$orders->links()}}
        </div>
    </div>
@endsection

@section('css')
    <style>
        .data-table td {
            vertical-align: middle !important;
        }

        .data .img {
            border-radius: 10px;
            background: no-repeat;
            background-size: cover;
            width: 90px;
            height: 90px;
        }

        .data .content {
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            margin-left: 5px;
            font-size: 13px;
        }
    </style>
@endsection
