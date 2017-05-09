<!DOCTYPE html>
<html>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Sep 2015 21:24:28 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>{{config('global.siteTitle')}}</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="{{config('global.baseURL')}}/favicon.ico" />

    <!-- Vendor styles -->
    {!! HTML::style('admintheme/vendor/fontawesome/css/font-awesome.css') !!}
    {!! HTML::style('admintheme/vendor/metisMenu/dist/metisMenu.css') !!}
    {!! HTML::style('admintheme/vendor/animate.css/animate.css') !!}
    {!! HTML::style('admintheme/vendor/bootstrap/dist/css/bootstrap.css') !!}

    <!-- App styles -->

    {!! HTML::style('admintheme/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css') !!}
    {!! HTML::style('admintheme/fonts/pe-icon-7-stroke/css/helper.css') !!}
    {!! HTML::style('admintheme/styles/style.css') !!}

</head>
<body class="blank">

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>{{config('global.siteTitle')}}</h1>
{!!HTML::image('admintheme/images/loading-bars.svg', 'Loading...', array('width'=>'64', 'height'=>'64'))!!}
<!-- <img src="images/loading-bars.svg" width="64" height="64" /> -->
 </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="color-line">
    <!-- Authentication Links -->
    {{-- @if (Auth::guest())
        <li><a href="{{ url('/login') }}">Login</a></li>
        <li><a href="{{ url('/register') }}">Register</a></li>
    @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
            </ul>
        </li>
    @endif --}}
</div>

<!-- <div class="back-link">
    <a href="/photoadmin" class="btn btn-primary">Back to WebView</a>
</div> -->

@yield('content')


<!-- Vendor scripts -->

{!! HTML::script('admintheme/vendor/jquery/dist/jquery.min.js') !!}
{!! HTML::script('admintheme/vendor/jquery-ui/jquery-ui.min.js') !!}
{!! HTML::script('admintheme/vendor/slimScroll/jquery.slimscroll.min.js') !!}
{!! HTML::script('admintheme/vendor/bootstrap/dist/js/bootstrap.min.js') !!}
{!! HTML::script('admintheme/vendor/metisMenu/dist/metisMenu.min.js') !!}
{!! HTML::script('admintheme/vendor/iCheck/icheck.min.js') !!}
{!! HTML::script('admintheme/vendor/sparkline/index.js') !!}

<!-- App scripts -->

{!! HTML::script('admintheme/scripts/homer.js') !!}

</body>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Sep 2015 21:24:28 GMT -->
</html>
