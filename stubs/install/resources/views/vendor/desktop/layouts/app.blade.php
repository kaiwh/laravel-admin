<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8"/>
        <title>@yield('title')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" name="viewport"/>
        <meta name="description" content="@yield('meta_description')" />
        <meta name="keywords" content= "@yield('meta_keywords')" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('vendor/bootstrap-3.3.7/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/bootstrap-3.3.7/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        @stack('styles')
        <link href="{{ asset('vendor/desktop/css/stylesheet.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="container">
            <header class="navbar navbar-static-top" id="header">
                <div class="navbar-header">
                    <a id="button-menu" class="hidden"></a>
                    <a class="navbar-brand">
                        {{ config('app.name') }}
                    </a>
                </div>
                <ul class="nav pull-right">
                    
                    @if(Auth::guard()->check())            
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::user()->name }} <i class="fa fa-caret-down fa-fw"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            {{-- <li><a >en</a></li> --}}
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('logout') }}">
                            <span class="hidden-xs hidden-sm hidden-md">
                                @Lang('desktop::app.button.logout')
                            </span>
                            <i class="fa fa-sign-out fa-lg"></i>
                        </a>
                    </li>
                    @else
                        <li>
                            <a href="{{ url('login') }}">
                                <span class="hidden-xs">@Lang('desktop::app.button.login')</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('register') }}">
                                <span class="hidden-xs">@Lang('desktop::app.button.register')</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </header>
            
            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('vendor/jquery/jquery-2.1.1.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap-3.3.7/dist/js/bootstrap.min.js') }}"></script>
        @stack('scripts')
        <script src="{{ asset('vendor/desktop/js/common.js') }}"></script>
       
        @yield('script')
        
    </body>
</html>
