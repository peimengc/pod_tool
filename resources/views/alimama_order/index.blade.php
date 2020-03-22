@extends('layouts.app')

@section('content')
    <div class="row bg-white py-4 px-2">
        <div class="col-md-12">
            <h4>抖音账号列表</h4>
            <p>所有抖音账号
        </div>
        <div class="col-md-12">
            <form>
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label class="sr-only" for="douyin_user_id">抖音账号</label>
                        <div class="input-group mb-2">
                            <select name="douyin_user_id" id="douyin_user_id" class="form-control">
                                <option value="">请选择抖音账号</option>
                                @foreach($douyinUsers as $k=>$v)
                                    <option @if(request('tk_status')==$k) selected @endif value="{{$k}}">{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="input-group mb-2">
                            <label class="sr-only" for="tk_status">订单状态</label>
                            <select name="tk_status" id="tk_status" class="form-control">
                                <option value="">请选择订单状态</option>
                                @foreach(\App\AlimamaOrder::$tkStatusArr as $k=>$v)
                                    <option @if(request('tk_status')==$k) selected @endif value="{{$k}}">{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-2">提交</button>
                        <a href="{{route('alimama_orders.index')}}" class="btn btn-secondary mb-2">清空</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">商品</th>
                    <th scope="col">状态</th>
                    <th scope="col">提成比例</th>
                    <th scope="col">付款金额</th>
                    <th scope="col">佣金</th>
                    <th scope="col">账号</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ $order->item_link }}" target="_blank">
                                {{ $order->item_title }}
                            </a>
                        </td>
                        <td>{{ $order->tk_status_desc }}</td>
                        <td>{{ $order->tk_total_rate }}%</td>
                        <td>{{ $order->alipay_total_price }}</td>
                        <td>{{ $order->pub_share_pre_fee }}</td>
                        <td>{{ $order->douyinUser->dy_nickname }} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            {{$orders->links()}}
        </div>
    </div>
@endsection
