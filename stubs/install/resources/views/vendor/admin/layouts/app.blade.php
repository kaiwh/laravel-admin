<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8"/>
        <title>{{ config('app.name') }}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" name="viewport"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('vendor/bootstrap-3.3.7/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/bootstrap-3.3.7/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/summernote-0.8.6-dist/dist/summernote.css') }}" rel="stylesheet">
        @stack('styles')
        <link href="{{ asset('vendor/admin/css/stylesheet.css') }}" rel="stylesheet">
        <script src="{{ asset('vendor/jquery/jquery-2.1.1.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap-3.3.7/dist/js/bootstrap.min.js') }}"></script>
    </head>
    <body>
        <div id="container">
            <header class="navbar navbar-static-top" id="header">
                <div class="navbar-header">
                    @if(Auth::guard('admin')->check())
                    <a class="pull-left" id="button-menu" type="button">
                        <i class="fa fa-dedent fa-lg">
                        </i>
                    </a>
                    @endif
                    <a class="navbar-brand" href="{{ route('admin') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                @if(Auth::guard('admin')->check())
                <ul class="nav pull-right">
                    <li>
                        <a class="hidden-xs">
                            <span >
                                {{ Auth::guard('admin')->user()->name }}
                            </span>
                        </a>
                    </li>
                    
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{ Language::active()->image }}" /> {{ Language::active()->title }}<i class="fa fa-caret-down fa-fw"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            @foreach(Language::all() as $value)
                                <li><a href="{{ route('admin.language.setLocale',['code'=>$value->code]) }}"><img src="{{ $value->image }}" /> {{ $value->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('admin.logout') }}">
                            <span class="hidden-xs hidden-sm hidden-md">
                                {{ trans('admin::app.button.logout') }}
                            </span>
                            <i class="fa fa-sign-out fa-lg"></i>
                        </a>
                    </li>
                </ul>
                @endif
            </header>
            @if(Auth::guard('admin')->check())
            <nav id="column-left">
                <ul id="menu">
                    @include('admin::layouts.menu')
                </ul>
            </nav>
            @endif
            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('vendor/summernote-0.8.6-dist/dist/summernote.min.js') }}"></script>
        <script src="{{ asset('vendor/summernote-0.8.6-dist/dist/lang/summernote-zh-CN.js') }}"></script>
        @stack('scripts')
        <script src="{{ asset('vendor/admin/js/common.js') }}"></script>
       
        @yield('script')
        
    </body>
</html>
