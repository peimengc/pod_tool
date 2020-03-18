<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('css')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row">
            @auth()
                <div class="col-md-2">
                    <ul class="list-group">
                        <a class="list-group-item {{ active_class(if_route('home')) }}" href="{{route('home')}}">
                            主页
                        </a>
                        <a class="list-group-item {{ active_class(if_route('douyin_users.index')) }}"
                           href="{{route('douyin_users.index')}}">
                            抖音账号
                        </a>
                        <div class="dropdown list-group-item">
                            <a class="dropdown-toggle" type="button" id="orderDropdown"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                淘宝订单
                            </a>
                            <div class="dropdown-menu" aria-labelledby="orderDropdown">
                                <button class="dropdown-item" data-toggle="modal" data-type="1" data-target="#qrcode">
                                    所有订单
                                </button>
                                <button class="dropdown-item" data-toggle="modal" data-type="2" data-target="#qrcode">
                                    账号统计
                                </button>
                            </div>
                        </div>
                        <div class="dropdown list-group-item">
                            <a class="dropdown-toggle" type="button" id="roiDropdown"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ROI统计
                            </a>
                            <div class="dropdown-menu" aria-labelledby="roiDropdown">
                                <button class="dropdown-item" data-toggle="modal" data-type="1" data-target="#qrcode">
                                    时段统计
                                </button>
                                <button class="dropdown-item" data-toggle="modal" data-type="2" data-target="#qrcode">
                                    账号统计
                                </button>
                            </div>
                        </div>
                        <a class="list-group-item" href="">
                            联盟授权
                        </a>
                    </ul>
                </div>
            @endauth
            <div class="col-md-10">
                @if (session('status'))
                    <div class="alert alert-{{ session('status.type','success') }}" role="alert">
                        {{ session('status.content') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</div>
</body>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</html>
