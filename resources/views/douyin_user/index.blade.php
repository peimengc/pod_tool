@extends('layouts.app')

@section('content')
    <div class="row bg-white py-4 px-2">
        <div class="col-md-12">
            <div class="btn-group float-right">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        扫码录入
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button class="dropdown-item" data-toggle="modal" data-type="1" data-target="#qrcode">投产账号
                        </button>
                        <button class="dropdown-item" data-toggle="modal" data-type="2" data-target="#qrcode">橱窗账号
                        </button>
                    </div>
                </div>
            </div>

            <h4>抖音账号列表</h4>
            <p>所有抖音账号</p>
        </div>
        <div class="col-md-12">
            <form>
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label class="sr-only" for="keywords">账号/昵称</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="keywords" name="keywords"
                                   value="{{ request('keywords') }}" placeholder="账号/昵称">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-2">提交</button>
                        <a href="{{route('douyin_users.index')}}" class="btn btn-secondary mb-2">清空</a>
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
                        <th scope="col">类型</th>
                        <th scope="col">登录状态</th>
                        <th scope="col">粉丝</th>
                        <th scope="col">赞</th>
                        <th scope="col">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="row middle-xs account">
                                    <div class="col-xs img"
                                         style="background-image: url('{{ $user->dy_avatar_url }}')"></div>
                                    <div class="col-xs content">
                                        <h4>{{ $user->dy_nickname }}</h4>
                                        <p>{{ $user->dy_unique_id ?: $user->dy_short_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->type == 1)
                                    <span class="badge badge-pill badge-warning">投产号</span>
                                @else
                                    <span class="badge badge-pill badge-primary">橱窗号</span>
                                @endif
                            </td>
                            <td>
                                @if($user->dy_cookie)
                                    <span class="badge badge-pill badge-success">已登录</span>
                                @else
                                    <span class="badge badge-pill badge-danger">登录失效</span>
                                @endif
                            </td>
                            <td>{{ $user->follower }}</td>
                            <td>{{ $user->favorited }}</td>
                            <td>
                                <div class="btn-group-sm">
                                    <a href="{{ route('roi.hour',$user) }}" class="btn btn-primary">ROI</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            {{$users->links()}}
        </div>
    </div>
    {{--扫码modal--}}
    <div class="modal fade" id="qrcode" tabindex="-1" role="dialog" aria-labelledby="qrcodeLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrcodeLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .account-table td {
            vertical-align: middle!important;
        }
        .account .img {
            border-radius: 10px;
            background: no-repeat;
            background-size: cover;
            width: 80px;
            height: 80px;
        }

    </style>
@endsection

@section('js')
    <script !src="">
        var checkQrconnect = null
        var $img = $('<img src="" width="100%">');
        $('#qrcode').on('show.bs.modal', function (e) {
            var $modal = $(this);
            var $modalBody = $modal.find('.modal-body');
            var $modalTitle = $modal.find('.modal-title');
            var $button = $(e.relatedTarget)
            var type = $button.data('type')
            if (parseInt(type) === 1) {
                $modalTitle.text('录入投产账号')
            } else {
                $modalTitle.text('录入橱窗账号')
            }
            var token;
            $.ajax({
                url: '/douyin_users/get_qrcode?type=' + type,
                dataType: 'json',
                success: function (res) {
                    token = res.data.token
                    $img.attr('src', 'data:image/jpeg;base64, ' + res.data.qrcode)
                    $modalBody.append($img)
                    checkQrconnect = setInterval(function () {
                        $.ajax({
                            url: '/douyin_users/' + token + '/check_qrconnect?type=' + type,
                            dataType: 'json',
                            success: function (res) {
                                switch (res.data.status) {
                                    case 'expired':
                                        token = res.data.token
                                        $img.attr('src', 'data:image/jpeg;base64, ' + res.data.qrcode)
                                        break;
                                    case 'confirmed':
                                        window.location.reload()
                                        break;
                                }
                            },
                            error: function () {
                                clearInterval(checkQrconnect)
                                alert('错误,请重试')
                            }
                        })
                    }, 2000)
                },
                error: function () {
                    alert('错误,请重试')
                }
            })
        })
        $('#qrcode').on('hide.bs.modal', function () {
            clearInterval(checkQrconnect)
            $img.remove();
        })
    </script>
@endsection
