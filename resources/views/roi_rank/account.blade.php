@extends('layouts.app')

@inject('orderModel','\App\AlimamaOrder')

@section('content')
    <div class="row bg-white py-4 px-2">
        <div class="col-md-12">
            <h4>ROI统计-账号排行榜</h4>
            <p>所有抖音账号最近七天的盈利排行榜</p>
        </div>
        <div class="col-md-12">
            <form>
                <div class="form-row align-items-center">
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">账号/昵称</span>
                            </div>
                            <input type="text" class="form-control" id="keywords" name="keywords"
                                   value="{{ request('keywords') }}" placeholder="账号/昵称">
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
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-2">提交</button>
                        <a href="{{route('roi.rank.account')}}" class="btn btn-secondary mb-2">清空</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table account-table" style="min-width: 45rem">
                    <thead>
                    <tr>
                        <th scope="col">账号</th>
                        <th scope="col">产出比</th>
                        <th scope="col">净利</th>
                        <th scope="col">总消耗</th>
                        <th scope="col">总佣金</th>
                        <th scope="col">有效佣金</th>
                        <th scope="col">失效佣金</th>
                        <th scope="col">退款数/率</th>
                        <th scope="col">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>
                                <div class="row middle-xs account">
                                    <div class="col-xs img"
                                         style="background-image: url('{{ $account->dy_avatar_url }}')"></div>
                                    <div class="col-xs content">
                                        <h4>{{ $account->dy_nickname }}</h4>
                                        <p>{{ $account->dy_unique_id ?: $account->dy_short_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($account->cost > 0)
                                    {{ round($account->valid_amount / $account->cost,2)  }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>{{ $account->valid_amount - $account->cost }}</td>
                            <td>{{ (float)$account->cost }}</td>
                            <td>{{ (float)$account->total_amount }}({{ (int)$account->total_num }})</td>
                            <td>{{ (float)$account->valid_amount }}({{ (int)$account->valid_num }})</td>
                            <td>{{ (float)$account->invalid_amount }}({{ (int)$account->invalid_num }})</td>
                            <td>
                                {{ (int)$account->refund_num }} /
                                @if($account->total_num > 0)
                                {{ round($account->refund_num / $account->total_num,2)  }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                <div class="btn-group-sm">
                                    <a href="{{ route('roi.hour',$account) }}" class="btn btn-primary">ROI</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            {{$accounts->links()}}
        </div>
    </div>
@endsection

@section('css')
    <style>
        .account-table td {
            vertical-align: middle !important;
        }

        .account .img {
            border-radius: 10px;
            background: no-repeat;
            background-size: cover;
            max-width: 80px;
            height: 80px;
        }

    </style>
@endsection
