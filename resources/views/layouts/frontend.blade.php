<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="{{ asset('/') }}"/>

    <title>Sportrauma Center | @yield('title')</title>

    <!-- Bootstrap core CSS -->

    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/font.css') }}" rel="stylesheet">
<!--<link href="{{ asset('assets/js/calendar/bootstrap_calendar.css') }}" rel="stylesheet">-->
    @stack('styles')
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/js/remodal/remodal.css') }}" rel="stylesheet">

    <!-- Custom styling plus plugins -->
<!--<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">-->
<!--<link href="{{ asset('assets/css/maps/jquery-jvectormap-2.0.3.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('assets/css/icheck/flat/green.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/floatexamples.css') }}" rel="stylesheet" type="text/css" />-->

<!--<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/js.cookie.js') }}"></script>-->
<!--<script src="{{ asset('assets/js/nprogress.js') }}"></script>-->
<!--<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet" type="text/css" />-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body id="app-layout">
<section class="vbox">


    <section>
        <section class="hbox stretch">
            <section id="content">
                <section class="vbox">
                    <section class="scrollable @yield('content-classes')">
                        @yield('content')
                    </section>
                </section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
            </section>
            <aside class="bg-light lter b-l aside-md hide" id="notes">
                <div class="wrapper">Notification</div>
            </aside>
        </section>
    </section>
</section>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>


<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/app.plugin.js') }}"></script>
<script src="{{ asset('assets/js/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/js/remodal/remodal.min.js') }}"></script>

@stack('scripts')
</body>
</html>
