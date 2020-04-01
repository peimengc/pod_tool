@extends('layouts.app')

@section('content')
    <div class="row bg-white py-4 px-2">
        <div class="col-md-12">
            <h4>抖音视频列表</h4>
            <p>所有抖音账号视频</p>
        </div>
        <div class="col-md-12">
            <form>
                <div class="form-row align-items-center">
                    <div class="col-md-3">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">抖音账号</span>
                            </div>
                            <select name="author_user_id" id="author_user_id" class="form-control">
                                <option value="">全部抖音号</option>
                                @foreach($douyinUsers as $k=>$v)
                                    <option @if(request('author_user_id')==$k) selected
                                            @endif value="{{$k}}">{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary mb-2">提交</button>
                        <a href="{{route('douyin_awemes.index')}}" class="btn btn-secondary mb-2">清空</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table account-table" style="min-width: 45rem">
                    <thead>
                    <tr>
                        <th scope="col">视频</th>
                        <th scope="col">转发</th>
                        <th scope="col">评论</th>
                        <th scope="col">点赞</th>
                        <th scope="col">播放</th>
                        <th scope="col">分享</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($awemes as $aweme)
                        <tr>
                            <td>
                                <div class="row middle-xs account">
                                    <div class="col-xs img"
                                         style="background-image: url('{{ $aweme->cover }}');height: 100px;max-width: 75px"></div>
                                    <div class="col-xs content">
                                        <b><a target="_blank" href="{{ $aweme->share_url }}">{{ $aweme->desc ?: '暂无标题' }}</a></b>
                                        <p>发布时间:{{ $aweme->create_time }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $aweme->forward_count }}</td>
                            <td>{{ $aweme->comment_count }}</td>
                            <td>{{ $aweme->digg_count }}</td>
                            <td>{{ $aweme->play_count }}</td>
                            <td>{{ $aweme->share_count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            {{$awemes->links()}}
        </div>
    </div>
@endsection
