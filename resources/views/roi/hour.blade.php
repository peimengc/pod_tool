@extends('layouts.app')

@section('content')
    <div class="row bg-white py-4 px-2">
        <div class="col-md-12">
            <h4>ROI统计</h4>
            <p>当前账号: "{{ $douyinUser->dy_nickname }}" </p>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">时间</th>
                    <th scope="col">总佣金</th>
                    <th scope="col">有效佣金</th>
                    <th scope="col">失效佣金</th>
                    <th scope="col">DOU+消耗</th>
                    <th scope="col">净利</th>
                    <th scope="col">ROI</th>
                </tr>
                </thead>
                <tbody>
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
@endsection
