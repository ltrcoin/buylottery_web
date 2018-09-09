<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <title>BuyLottery | @yield('title')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="Lottery Services Global">
    <meta name="description" content="{{ empty($pageDesc) ? 'Helping to buy lottery global' : $pageDesc }}">

    <meta property="og:title" content="Lottery Services Global" />
    <meta property="og:description" content="{{ empty($pageDesc) ? 'Helping to buy lottery global' : $pageDesc }}" />

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <!-- <link rel="shortcut icon" href="images/default/favicon.png" -->
    <link rel="shortcut icon" href="{{ asset('frontend/images/default/logo.png') }}">
    <!-- Web Fonts  -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700|Playfair+Display:400,900italic,900,700italic,700,400italic' rel='stylesheet' type='text/css'>

    <!-- Lib CSS -->
    <link rel="stylesheet" href="{{ asset("frontend/css/lib/bootstrap.min.css") }}">
    <link rel="stylesheet" href="{{ asset("frontend/css/lib/animate.min.css") }}">
    <link rel="stylesheet" href="{{ asset("frontend/css/lib/font-awesome.min.css") }}">
    <link rel="stylesheet" href="{{ asset("frontend/css/lib/gloryicon.css") }}">
    <link rel="stylesheet" href="{{ asset("frontend/css/lib/gap-icons.css") }}">
    <link rel="stylesheet" href="{{ asset("frontend/css/lib/owl.carousel.css") }}">
    <link rel="stylesheet" href="{{ asset("frontend/css/lib/prettyPhoto.css") }}">
    <link rel="stylesheet" href="{{ asset("frontend/css/lib/menu.css") }}">
    <link rel="stylesheet" href="{{ asset("frontend/css/lib/timeline.css") }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset("frontend/css/theme.css") }}">
    <link rel="stylesheet" href="{{ asset("frontend/css/theme-responsive.css") }}">

    <!--[if IE]>
    <link rel="stylesheet" href="{{ asset('frontend/css/ie.css') }}">
    <![endif]-->

    <!-- Head Libs -->
    <script src="{{ asset("frontend/js/lib/modernizr.js") }}"></script>

    <!-- Skins CSS -->
    <link rel="stylesheet" href="{{ asset("frontend/css/skins/default.css") }}">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset("frontend/css/custom.css") }}">
    <link rel="stylesheet" href="{{ asset("frontend/css/style.css") }}">

    @yield('css')

    <script>
      window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>

@include('frontend.layouts.header')

<!-- Page Header -->
@yield('page_header')
<!-- /Page Header -->

<!-- Page Main -->
<div role="main" class="main">
    @yield('content')
</div><!-- Page Main -->

@include('frontend.layouts.footer')
<input type="hidden" id="url-winner-detail" value="{{url('winner-detail')}}">
<div id="modal-winner-detail" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> 
                <h4 class="modal-title" id="myModalLabel">Our Winner!</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-5 col-md-5">
                        <img id="modal-image" alt="" class="img-responsive" src="">
                    </div>
                    <div class="col-sm-7 col-md-7">
                        <h3 id="winner-name"></h3>
                        <h4 id="prize" class="color-red" style="margin-top: -15px; font-size: 20px;"></h4>
                        <p id="description" class="mrg-t-10"></p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- library -->
<script src="{{ asset("frontend/js/lib/jquery.js") }}"></script>
<script src="{{ asset("frontend/js/lib/bootstrap.min.js") }}"></script>
<script src="{{ asset("frontend/js/lib/bootstrapValidator.min.js") }}"></script>
<script src="{{ asset("frontend/js/lib/jquery.appear.min.js") }}"></script>
<script src="{{ asset("frontend/js/lib/jquery.easing.min.js") }}"></script>
<script src="{{ asset("frontend/js/lib/owl.carousel.min.js") }}"></script>
<script src="{{ asset("frontend/js/lib/countdown.js") }}"></script>
<script src="{{ asset("frontend/js/lib/counter.js") }}"></script>
<script src="{{ asset("frontend/js/lib/charts.js") }}"></script>
<script src="{{ asset("frontend/js/lib/isotope.pkgd.min.js") }}"></script>
<script src="{{ asset("frontend/js/lib/jquery.easypiechart.min.js") }}"></script>
<script src="{{ asset("frontend/js/lib/jquery.mb.YTPlayer.min.js") }}"></script>
<script src="{{ asset("frontend/js/lib/jquery.prettyPhoto.js") }}"></script>
<script src="{{ asset("frontend/js/lib/jquery.stellar.min.js") }}"></script>
<script src="{{ asset("frontend/js/lib/menu.js") }}"></script>
<script src="{{ asset("frontend/js/lib/theme-panel.js") }}"></script>

<script src="{{ asset("frontend/js/lib/theme-rs.js") }}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{ asset("frontend/js/theme.js") }}"></script>

<!-- Theme Custom -->
<script src="{{ asset("frontend/js/custom.js") }}"></script>

<script src="{{ asset("frontend/js/common.js") }}"></script>

@yield('js')

</body>
</html>