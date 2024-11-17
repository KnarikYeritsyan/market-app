<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Knarik">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/admin/assets/images/favicon.png">
    <title>{{setting('site.title')}}</title>
    <!-- Custom CSS -->
    {{--<link href="/admin/assets/extra-libs/c3/c3.min.css" rel="stylesheet">--}}
    <!-- Custom CSS -->
    <link href="/admin/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('css')
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin6">
        <nav class="navbar top-navbar navbar-expand-md">
            <div class="navbar-header" data-logobg="skin6">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-brand">
                    <!-- Logo icon -->
                    <a href="{{route('admin.home',app()->getLocale())}}">
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="/admin/assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="/admin/assets/images/logo-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="/admin/assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo text -->
                                <img src="/admin/assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                            </span>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                   data-toggle="collapse" data-target="#navbarSupportedContent"
                   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                    <!-- Notification -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="{{route('admin.new-messages',app()->getLocale())}}" id="bell">
                            <span><i data-feather="mail" class="svg-icon"></i></span>
                            <span class="badge badge-primary notify-no rounded-circle">{{$contact_count?$contact_count:''}}</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown">
                            <span><i data-feather="bell" class="svg-icon"></i></span>
                            <span class="badge badge-primary notify-no rounded-circle">5</span>
                        </a>
                    </li>
                    <!-- End Notification -->
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">
                            @php $locale = app()->getLocale(); @endphp
                            @switch($locale)
                                @case('ru')
                                @php $lang = 'Russian' @endphp
                                @break
                                @case('am')
                                @php $lang = 'Armenian' @endphp
                                @break
                                @default
                                @php $lang = 'English' @endphp
                            @endswitch
                            <div class="customize-input">
                                <select style="padding-top: 0;padding-bottom: 0;text-align-last: center;line-height: 20px"
                                        onchange="location = this.options[this.selectedIndex].value;"
                                        class="custom-select form-control bg-white custom-radius custom-shadow border-0">
                                    @foreach(config('app.available_locales') as $key=>$value)
                                        <option {{ app()->getLocale() == $key ? 'selected':'' }} value="{{route(\Illuminate\Support\Facades\Route::currentRouteName(),[$key,request()->id])}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-right">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <img src="/admin/assets/images/profile-pic.png" alt="user" class="rounded-circle"
                                 width="40">
                            <span class="ml-2 d-none d-lg-inline-block"><span>{{__('Hello')}},</span> <span
                                        class="text-dark">{{Auth::user()->name}}</span> <i data-feather="chevron-down"
                                                                              class="svg-icon"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                            <a class="dropdown-item" href="{{route('admin.profile',app()->getLocale())}}"><i data-feather="user"
                                                                                  class="svg-icon mr-2 ml-1"></i>
                                {{__('My Profile')}}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout',app()->getLocale()) }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i data-feather="power" class="svg-icon mr-2 ml-1"></i>{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('admin-logout',app()->getLocale()) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{route('admin.home',app()->getLocale())}}"
                                                 aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                    class="hide-menu">{{__('Dashboard')}}</span></a></li>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">{{__('Products data')}}</span></li>

                    <li class="sidebar-item"> <a class="sidebar-link" href="{{route('admin.categories',app()->getLocale())}}"
                                                 aria-expanded="false"><i data-feather="list" class="feather-icon"></i><span
                                    class="hide-menu">{{__('Categories')}}
                                </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{route('admin.brands',app()->getLocale())}}"
                                                 aria-expanded="false"><i data-feather="award" class="feather-icon"></i><span
                                    class="hide-menu">{{__('Brands')}}</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{route('admin.products',app()->getLocale())}}"
                                                 aria-expanded="false"><i data-feather="paperclip" class="feather-icon"></i><span
                                    class="hide-menu">{{__('Products')}}</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{route('admin.tags',app()->getLocale())}}"
                                                 aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span
                                    class="hide-menu">{{__('Tags')}}</span></a></li>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">{{__('Components')}}</span></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{route('admin.menus',app()->getLocale())}}"
                       aria-expanded="false"><i data-feather="menu" class="feather-icon"></i><span
                       class="hide-menu">{{__('Menus')}}</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{route('admin.social-media',app()->getLocale())}}"
                        aria-expanded="false"><i data-feather="aperture" class="feather-icon"></i><span
                        class="hide-menu">{{__('Social Media')}}</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{route('admin.pages',app()->getLocale())}}"
                        aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span
                        class="hide-menu">{{__('Pages')}}</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{route('admin.posts',app()->getLocale())}}"
                        aria-expanded="false"><i data-feather="bookmark" class="feather-icon"></i><span
                        class="hide-menu">{{__('Posts')}}</span></a>
                    </li>
                    {{--<li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{route('admin.videos',app()->getLocale())}}"
                                                 aria-expanded="false"><i data-feather="video" class="feather-icon"></i><span
                                    class="hide-menu">{{__('Videos')}}</span></a>
                    </li>--}}
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                                 aria-expanded="false"><i data-feather="grid" class="feather-icon"></i><span
                                    class="hide-menu">{{__('CMS')}}
                                </span></a>
                        <ul aria-expanded="false" class="collapse first-level base-level-line">
                            <li class="sidebar-item"><a href="{{route('admin.sliders',app()->getLocale())}}" class="sidebar-link">
                                    <i data-feather="image" class="feather-icon"></i>
                                    <span class="hide-menu"> {{__('Sliders')}} </span></a></li>

                            <li class="sidebar-item"><a href="{{route('admin.setting-contact',app()->getLocale())}}" class="sidebar-link">
                                    <i data-feather="sliders" class="feather-icon"></i>
                                    <span class="hide-menu"> {{__('Contact')}} </span></a></li>
                            <li class="sidebar-item"><a href="{{route('admin.setting',app()->getLocale())}}" class="sidebar-link">
                                    <i data-feather="settings" class="feather-icon"></i>
                                    <span class="hide-menu"> {{__('Settings')}} </span></a></li>
                            {{--<li class="sidebar-item"><a href="#" class="sidebar-link">
                                    <i data-feather="align-center" class="feather-icon"></i>
                                    <span class="hide-menu"> {{__('Footer Links')}} </span></a></li>--}}
                        </ul>
                    </li>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Authentication</span></li>

                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="authentication-login1.html"
                                                 aria-expanded="false"><i data-feather="lock" class="feather-icon"></i><span
                                    class="hide-menu">Login
                                </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                                 href="authentication-register1.html" aria-expanded="false"><i data-feather="lock"
                                                                                                               class="feather-icon"></i><span class="hide-menu">Register
                                </span></a>
                    </li>

                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                                 aria-expanded="false"><i data-feather="feather" class="feather-icon"></i><span
                                    class="hide-menu">Icons
                                </span></a>
                        <ul aria-expanded="false" class="collapse first-level base-level-line">
                            <li class="sidebar-item"><a href="icon-fontawesome.html" class="sidebar-link"><span
                                            class="hide-menu"> Fontawesome Icons </span></a></li>

                            <li class="sidebar-item"><a href="icon-simple-lineicon.html" class="sidebar-link"><span
                                            class="hide-menu"> Simple Line Icons </span></a></li>
                        </ul>
                    </li>

                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                                 aria-expanded="false"><i data-feather="crosshair" class="feather-icon"></i><span
                                    class="hide-menu">Multi
                                    level
                                    dd</span></a>
                        <ul aria-expanded="false" class="collapse first-level base-level-line">
                            <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span
                                            class="hide-menu"> item 1.1</span></a>
                            </li>
                            <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span
                                            class="hide-menu"> item 1.2</span></a>
                            </li>
                            <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                         aria-expanded="false"><span class="hide-menu">Menu 1.3</span></a>
                                <ul aria-expanded="false" class="collapse second-level base-level-line">
                                    <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span
                                                    class="hide-menu"> item
                                                    1.3.1</span></a></li>
                                    <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span
                                                    class="hide-menu"> item
                                                    1.3.2</span></a></li>
                                    <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span
                                                    class="hide-menu"> item
                                                    1.3.3</span></a></li>
                                    <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span
                                                    class="hide-menu"> item
                                                    1.3.4</span></a></li>
                                </ul>
                            </li>
                            <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span
                                            class="hide-menu"> item
                                            1.4</span></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <div id="main-content">
            <div style="width: 2.5em;height: 2.5em;cursor: pointer" class="btn-toggle-fullwidth">
                <div class="open-close-menu close-menu"></div>
            </div>
        @yield('breadcrumb')
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            @yield('modal')
            @yield('content')
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        {{--<footer class="footer text-center text-muted">
            All Rights Reserved by Adminmart. Designed and Developed by <a
                    href="https://wrappixel.com">WrapPixel</a>.
        </footer>--}}
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="/admin/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/admin/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="/admin/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- apps -->
<!-- apps -->
<script src="/admin/dist/js/app-style-switcher.js"></script>
<script src="/admin/dist/js/feather.min.js"></script>
<script src="/admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="/admin/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="/admin/dist/js/custom.min.js"></script>
@yield('script')
</body>

</html>