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
    <link rel="stylesheet" href="{{ asset('asset/jQuery.cxCalendar-1.5.3/css/jquery.cxcalendar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexboxgrid/6.3.1/flexboxgrid.min.css"
          type="text/css">

    <style>
        .account-table td {
            vertical-align: middle !important;
        }
        .account .img {
            border-radius: 10px;
            background: no-repeat;
            background-size: cover;
            max-width: 60px;
            height: 60px;
        }
    </style>
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
                    @auth()
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(if_route('home')) }}" href="{{route('home')}}">
                                主页
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(if_route('douyin_users.index')) }}"
                               href="{{route('douyin_users.index')}}">
                                抖音账号
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(if_route('douyin_awemes.index')) }}"
                               href="{{route('douyin_awemes.index')}}">
                                抖音视频
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(if_route('alimama_orders.index')) }}"
                               href="{{route('alimama_orders.index')}}">
                                联盟订单
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                ROI统计 <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('roi.rank.account') }}">账号统计</a>
                            </div>
                        </li>
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        {{--@if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif--}}
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

        @if (session('status.content'))
            <div class="alert alert-{{ session('status.type','success') }}" role="alert">
                {{ session('status.content') }}
            </div>
        @endif

        @yield('content')

    </div>
</div>
</body>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('asset/jQuery.cxCalendar-1.5.3/js/jquery.cxcalendar.min.js') }}"></script>
<script src="{{ asset('asset/jQuery.cxCalendar-1.5.3/js/jquery.cxcalendar.languages.js') }}"></script>
<script>
    $('input.datetime').cxCalendar({
        type: 'datetime',
        format: 'YYYY-MM-DD HH:mm:ss'
    });
    $('input.date').cxCalendar({
        type: 'date',
        format: 'YYYY-MM-DD'
    });
</script>
@yield('js')
</html>
