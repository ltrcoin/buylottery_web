<!-- Page Loader -->
<div id="pageloader">
    <div class="loader-inner">
        <img src="{{ asset('frontend/images/default/preloader.gif') }}" alt="Pre Loader" height="100" width="100">
    </div>
</div><!-- Page Loader -->

<!-- Back to top -->
<a href="#0" class="cd-top">Top</a>

<!-- Header Begins -->
<header id="header" class="default-header colored flat-menu mega-menu-contain-screen">
    <div class="header-top">
        <div class="container">
            <nav>
                <ul class="nav nav-pills nav-top">
                    <!-- <li class="language">
                        <div class="dropdown">
                            <button class="btn" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="true"><i class="icon icon-Dollar"></i>English</button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#">German</a></li>
                                <li><a href="#">French</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="phone">
                        <span><i class="icon icon-Phone2"></i>+ (044 569 5877)</span>
                    </li> -->
                    <li class="email">
                        <span>
                            <i class="icon icon-Mail"></i>
                            <a href="mailto:admin@ltrcoin.com" title="admin@ltrcoin.com" target="_top">admin@ltrcoin.com</a>
                        </span>
                    </li>
                    <li class="address">
                        <span><i class="icon icon-Pointer"></i>Tera Building, 87 Wing Lok Street, Hong Kong.</span>
                    </li>
                </ul>
            </nav>
            <nav class="pull-right">
                <ul class="nav nav-pills nav-top">
                    @if(Auth::guard('web')->check())
                    <!--<li class="language">
                        <div class="dropdown">
                            <button class="btn" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="true"><i class="icon uni-key"></i></button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="" title="Logout">Logout</a></li>
                            </ul>
                        </div>
                    </li>-->

                    <li>
                        <a href="{{route('frontend.account.profile')}}" class="btn"><i class="icon uni-key"></i>{{Auth::guard('web')->user()->fullname}}</a>
                    </li>
                    <li>
                        <a href="{{route('frontend.site.logout')}}" class="btn" title="Logout"><i class="icon icon-Exit"></i>Logout</a>
                    </li>

                    @else
                    @if(\Session::has('2fa:isLogged'))
                    <li><a href="{{route('frontend.site.vUseanotheraccount')}}" class="btn"><i class="icon uni-key"></i>Use another account</a></li>
                    @else
                    <li><a href="{{route('frontend.site.vLogin')}}" class="btn"><i class="icon uni-key"></i>Sign In</a></li>
                    @endif
                    <li><a href="{{route('frontend.site.vRegister')}}" class="btn"><i class="icon icon-Dollar"></i>Sign Up</a></li>
                    @endif
                </ul>
            </nav>
            <!-- <ul class="social-icons color">
                <li class="googleplus"><a title="googleplus" target="_blank" href="http://www.googleplus.com/">googleplus</a></li>
                <li class="facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook">Facebook</a></li>
                <li class="twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter">Twitter</a></li>
                <li class="pinterest"><a title="pinterest" target="_blank" href="http://www.pinterest.com/">pinterest</a></li>
                <li class="rss"><a title="rss" target="_blank" href="http://www.rss.com/">rss</a></li>
            </ul> -->
        </div>
    </div>
    <div class="container">
        <div class="logo">
            <a href="{{route('frontend.site.index')}}">
                <img alt="BuyLottery" width="170" height="50" data-sticky-width="130" data-sticky-height="40" src="{{ asset('frontend/images/default/logo.png') }}">
            </a>
        </div>
        <button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <div class="navbar-collapse nav-main-collapse collapse">
        <div class="container mega-menu-wide-container">
            <nav class="nav-main mega-menu">
                <ul class="nav nav-pills nav-main" id="mainMenu">
                    <li>
                        <a href="{{route('frontend.site.index')}}">Home</a>
                    </li>

                    <li>
                        <a href="{{route('frontend.winning.index')}}">Lottery Results</a>
                    </li>

                    <li>
                        <a href="{{route('frontend.winner.index')}}">Our Winners</a>
                    </li>

                    <!--<li class="dropdown mega-menu-item mega-menu-fullwidth mega-menu-wide">
                        <a class="dropdown-toggle" href="#">
                            Features
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="mega-menu-content">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <ul class="sub-menu menu-border">
                                                <li>
                                                    <span class="mega-menu-sub-title">Header</span>
                                                    <ul class="sub-menu">
                                                        <li><a href="header-1.html">Header 1 - Default</a></li>
                                                        <li><a href="header-2-center.html">Header 2 - Center</a></li>
                                                        <li><a href="header-3-login.html">Header 3 - Login<span class="tip">Trend</span></a></li>
                                                        <li><a href="header-4-profile.html">Header 4 - Profile</a></li>
                                                        <li><a href="header-5-fullwidth.html">Header 5 - Full Width</a></li>
                                                        <li><a href="header-6-blowslider.html">Header 6 - Below Slider</a></li>
                                                        <li><a href="header-7-sticky.html">Header 7 - Sticky</a></li>
                                                        <li><a href="header-8-transparent.html">Header 8 - Transparent</a></li>
                                                        <li><a href="header-9-semitransparent.html">Header 9- Semi Transparent</a></li>
                                                        <li><a href="header-10-semitransparent-light.html">Header 10 - Semi Transparent - Light</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-md-3">
                                            <ul class="sub-menu menu-border">
                                                <li>
                                                    <span class="mega-menu-sub-title">Extra Pages</span>
                                                    <ul class="sub-menu">
                                                        <li><a href="page-404.html">404</a></li>
                                                        <li><a href="page-404-2.html">404 - 2</a></li>
                                                        <li><a href="page-construction.html">Under Construction</a></li>
                                                        <li><a href="page-comingsoon.html">Coming Soon</a></li>
                                                        <li><a href="page-signup.html">Signup</a></li>
                                                        <li><a href="page-login.html">Login</a></li>
                                                        <li><a href="page-widgets.html">Widgets<span class="tip red">Hot</span></a></li>
                                                        <li><a href="page-faq.html">Faq</a></li>
                                                        <li><a href="page-sitemap.html">Sitemap</a></li>
                                                        <li><a href="page-blank.html">Blank Template</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3">
                                            <ul class="sub-menu menu-border">
                                                <li>
                                                    <span class="mega-menu-sub-title">Layout</span>
                                                    <ul class="sub-menu">
                                                        <li><a href="layout-fullwidth.html">Full Width</a></li>
                                                        <li><a href="layout-boxed.html">Boxed<span class="tip yellow">Elegant</span></a></li>
                                                        <li><a href="layout-wide.html">Wide</a></li>
                                                        <li><a href="layout-left.html">Left Sidebar</a></li>
                                                        <li><a href="layout-right.html">Right Sidebar</a></li>
                                                        <li><a href="layout-both.html">Both Sidebar</a></li>
                                                        <li><a href="layout-both-left.html">Both Left Sidebar</a></li>
                                                        <li><a href="layout-both-right.html">Both Right Sidebar</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3">
                                            <ul class="sub-menu menu-border">
                                                <li>
                                                    <span class="mega-menu-sub-title">Footer</span>
                                                    <ul class="sub-menu">
                                                        <li><a href="footer-1.html#footer">Footer 1</a></li>
                                                        <li><a href="footer-2.html#footer">Footer 2</a></li>
                                                        <li><a href="footer-3.html#footer">Footer 3<span class="tip pink">New</span></a></li>
                                                        <li><a href="footer-4.html#footer">Footer 4</a></li>
                                                        <li><a href="footer-5.html#footer">Footer 5</a></li>
                                                        <li><a href="footer-6.html#footer">Footer 6</a></li>
                                                        <li><a href="footer-7.html#footer">Footer 7</a></li>
                                                        <li><a href="footer-8.html#footer">Footer 8<span class="tip green">New</span></a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li> -->
                    @if(Auth::guard('web')->check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle sticky-menu-active">
                            My Account
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('frontend.account.transaction')}}">Transaction history</a></li>
                            <li><a href="{{route('frontend.account.win')}}">Wins history</a></li>
                            <li><a href="{{route('frontend.account.profile')}}">Profile</a></li>
                            <li><a href="{{route('frontend.ps.2fasetting')}}">2fa Verification</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(Auth::guard('web')->check())
                    <li class="menu-mobile">
                        <a href="{{route('frontend.account.profile')}}"><i class="icon uni-key"></i> {{Auth::guard('web')->user()->fullname}}</a>
                    </li>
                    <li class="menu-mobile">
                        <a href="{{route('frontend.site.logout')}}"><i class="icon icon-Exit"></i> Logout</a>
                    </li>

                    @else
                    @if(\Session::has('2fa:isLogged'))
                    <li class="menu-mobile">
                        <a href="{{route('frontend.site.vUseanotheraccount')}}">Use another account</a>
                    </li>
                    @else
                    <li class="menu-mobile">
                        <a href="{{route('frontend.site.vLogin')}}">Sign In</a>
                    </li>
                    @endif
                    <li class="menu-mobile">
                        <a href="{{route('frontend.site.vRegister')}}">Sign Up</a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</header><!-- Header Ends