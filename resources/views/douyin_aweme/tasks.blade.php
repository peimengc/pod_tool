@extends('layouts.app')

@inject('taskModel','\App\DouplusTask')

@section('content')
    <div class="row bg-white py-4 px-2">
        <div class="col-md-12">
            <h4>订单列表</h4>
            <p>抖+订单列表，默认展示最近今天内的订单;当前视频: <u>{{ $aweme->desc }}</u></p>
        </div>
        <div class="col-md-12">
            <form>
                <div class="form-row align-items-center">
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">开始时间</span>
                            </div>
                            <input class="form-control date" id="start-date" name="start-date"
                                   value="{{ request('start-date',$taskModel->defaultStartDate()) }}" type="text"
                                   placeholder="开始时间">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">结束时间</span>
                            </div>
                            <input class="form-control date" id="end-date" name="end-date"
                                   value="{{ request('end-date',$taskModel->defaultEndDate()) }}" type="text"
                                   placeholder="结束时间">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary mb-2">提交</button>
                        <a href="{{route('douyin_awemes.tasks',$aweme)}}" class="btn btn-secondary mb-2">清空</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table data-table" style="min-width: 60rem">
                    <thead>
                    <tr>
                        <th scope="col">投放时间</th>
                        <th scope="col">投放时长</th>
                        <th scope="col">投放金额</th>
                        <th scope="col">消耗金额</th>
                        <th scope="col">状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->create_time }}</td>
                            <td>{{ $task->duration }}</td>
                            <td>{{ $task->budget }}</td>
                            <td>{{ $task->cost }}</td>
                            <td>{{ $task->state }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            {{$tasks->links()}}
        </div>
    </div>
@endsection
