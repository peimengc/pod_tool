@extends('layouts.app')

@section('content')
    <div class="row bg-white py-4 px-2">
        <div class="col-md-12">
            <h4>ROI统计</h4>
            <p>当前账号: "{{ $douyinUser->dy_nickname }}" </p>
        </div>
        <div class="col-md-12">
            <form>
                <div class="form-row align-items-center">
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">日期</span>
                            </div>
                            <input class="form-control date" name="date"
                                   value="{{ request('date',now()->toDateString()) }}" type="text"
                                   placeholder="日期">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-2">提交</button>
                        <a href="{{route('roi.hour',$douyinUser)}}" class="btn btn-secondary mb-2">重置</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table" style="min-width: 50rem">
                    <thead>
                    <tr>
                        <th>时间</th>
                        <th>总佣金</th>
                        <th>有效佣金</th>
                        <th>失效佣金</th>
                        <th>DOU+消耗</th>
                        <th>净利</th>
                        <th>ROI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>合计</th>
                        <th>{{ $roiSum['total_amount'] }}({{ $roiSum['total_num'] }})</th>
                        <th>{{ $roiSum['valid_amount'] }}({{ $roiSum['valid_num'] }})</th>
                        <th>{{ $roiSum['invalid_amount'] }}({{ $roiSum['invalid_num'] }})</th>
                        <th>{{ $roiSum['cost'] }} </th>
                        <th>{{  $roiSum['valid_amount'] - $roiSum['cost'] }} </th>
                        <th>
                            @if($roiSum['cost'] > 0)
                                {{ round($roiSum['valid_amount'] / $roiSum['cost'],2)  }}
                            @else
                                0
                            @endif
                        </th>
                    </tr>
                    @foreach($roi as $value)
                        <tr>
                            <td>{{ $value->hour }}</td>
                            <td>{{ $value->total_amount }}({{ $value->total_num }})</td>
                            <td>{{ $value->valid_amount }}({{ $value->valid_num }})</td>
                            <td>{{ $value->invalid_amount }}({{ $value->invalid_num }})</td>
                            <td>{{ $value->cost }} </td>
                            <td>{{  $value->valid_amount - $value->cost }} </td>
                            <td>
                                @if($value->cost > 0)
                                    {{ round($value->valid_amount / $value->cost,2)  }}
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
