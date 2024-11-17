<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="/img/core-img/favicon.ico">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<!-- ##### Header Area Start ##### -->
<header class="header-area">

    <!-- ***** Top Header Area ***** -->
    <div class="top-header-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="top-header-content d-flex align-items-center justify-content-between">
                        <!-- Top Header Content -->
                        <div class="top-header-meta">
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="knarik.yeritsyan@gmail.com"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>@lang('messages.email'): knarik.yeritsyan@gmail.com</span></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="+374 94 09 44 59"><i class="fa fa-phone" aria-hidden="true"></i> <span>{{__('Phone')}}: +374 (94) 09 44 59</span></a>
                        </div>

                        <!-- Top Header Content -->
                        <div class="top-header-meta d-flex">
                            <!-- Language Dropdown -->
                            @php $locale = app()->getLocale(); @endphp
                            @switch($locale)
                                @case('ru')
                                @php $lang = 'Russian' @endphp
                                <img src="{{asset('img/lang/ru.png')}}" width="30px" height="20x">
                                @break
                                @case('am')
                                @php $lang = 'Armenian' @endphp
                                <img src="{{asset('img/lang/am.png')}}" width="30px" height="20x">
                                @break
                                @default
                                @php $lang = 'English' @endphp
                                <img src="{{asset('img/lang/en.png')}}" width="30px" height="20x">
                            @endswitch
                            <div class="language-dropdown">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle mr-30" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$lang}}</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach(config('app.available_locales') as $key=>$value)
                                        <a class="dropdown-item" href="{{route(\Illuminate\Support\Facades\Route::currentRouteName(),[$key,request()->token])}}">{{$value}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ***** Navbar Area ***** -->
    <div class="alazea-main-menu">
        <div class="classy-nav-container breakpoint-off">
            <div class="container">
                <!-- Menu -->
                <nav class="classy-navbar justify-content-between" id="alazeaNav">

                    <!-- Nav Brand -->
                    <a href="{{url(app()->getLocale())}}" class="nav-brand"><img width="40px" src="/img/core-img/logo.png" alt=""></a>

                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">

                        <!-- Close Button -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                    </div>
                </nav>

                <!-- Search Form -->
                <div class="search-form">
                    <form action="#" method="get">
                        <input type="search" name="search" id="search" placeholder="Type keywords &amp; press enter...">
                        <button type="submit" class="d-none"></button>
                    </form>
                    <!-- Close Icon -->
                    <div class="closeIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ##### Header Area End ##### -->

@yield('content')

<!-- ##### Footer Area Start ##### -->
<footer class="footer-area bg-img" style="background-image: url(/img/bg-img/footer-bg.jpg);">
    <!-- Main Footer Area -->
    <div class="main-footer-area">
        <div class="container">
            <div class="row">
                <!-- Single Footer Widget -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-footer-widget">
                        <div class="widget-title">
                            <h5>{{__('CONTACT')}}</h5>
                        </div>

                        <div class="contact-information">
                            <p><span>{{__('Site Made By')}}:</span> Knarik Yeritsyan</p>
                            <p><span>{{__('Phone')}}:</span> +374 (94) 09 44 59</p>
                            <p><span>{{__('messages.email')}}:</span> knarik.yeritsyan@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ##### Footer Area End ##### -->

<!-- ##### All Javascript Files ##### -->
<!-- jQuery-2.2.4 js -->
<script src="/js/jquery/jquery-2.2.4.min.js"></script>
<!-- Popper js -->
<script src="/js/bootstrap/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="/js/bootstrap/bootstrap.min.js"></script>
<!-- All Plugins js -->
<script src="/js/plugins/plugins.js"></script>
<!-- Active js -->
<script src="/js/active.js"></script>
</body>

</html>