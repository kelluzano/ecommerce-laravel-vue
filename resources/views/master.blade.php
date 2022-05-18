<!doctype html>
    <html lang="en">

    <head>

        <!--====== Required meta tags ======-->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--====== Title ======-->
        <title>ECommerce</title>


        @yield('header-styles')

        <!--====== Bootstrap css ======-->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

        <!--====== Animate css ======-->
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

        <!--====== Magnific Popup css ======-->
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">

        <!--====== Slick css ======-->
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">

        <!--====== Line Icons css ======-->
        <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.css') }}">

        <!--====== Default css ======-->
        <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">

        <!--====== Style css ======-->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        <!--====== Responsive css ======-->
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">






    </head>

    <body>

        <!--====== PRELOADER PART START ======-->

        <div id="app">

            <!--====== PRELOADER PART START ======-->

            <div class="preloader">
                <div class="spin">
                    <div class="cube1"></div>
                    <div class="cube2"></div>
                </div>
            </div>

            <!--====== PRELOADER PART START ======-->

            <!--====== HEADER PART START ======-->

            <header class="header-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <nav class="navbar navbar-fixed-top navbar-expand-lg">
                                <a class="navbar-brand" href="{{ route('main') }}">

                                </a> <!-- Logo -->
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="bar-icon"></span>
                                    <span class="bar-icon"></span>
                                    <span class="bar-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul id="nav" class="navbar-nav ml-auto">
                                        <li class="nav-item">
                                            <a href="{{ route('main') }}">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-scroll-nav="0" href="{{ route('main') }}">Products</a>
                                        </li>

                                        @if (Route::has('login'))
                                        @auth
                                        <cart></cart>

                                        <li class="nav-item">
                                        <a class="" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                        </li>
                                    @else
                                    <li class="nav-item">  
                                        <a href="{{ route('login') }}">Log in</a>
                                    </li>
                                    @if (Route::has('register'))
                                    <li class="nav-item">  
                                        <a href="{{ route('register') }}">Register</a>
                                    </li>    
                                    @endif
                                    @endauth
                                    @endif
                                </ul> <!-- navbar nav -->
                            </div>
                        </nav> <!-- navbar -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </header>
        

        @yield('content')

    </div>
    
    <!--====== HEADER PART ENDS ======-->


    <!--====== PRODUCT PART START ======-->
    

    
    <!--====== PRODUCT PART ENDS ======-->
    
    <!--====== BACK TO TOP PART START ======-->
    
    <a href="#" class="back-to-top"><i class="lni-chevron-up"></i></a>
    
    <!--====== BACK TO TOP PART ENDS ======-->
    
    

    
    
    
    <!--====== jquery js ======-->
    <script src="{{asset('assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>

    

    <!--====== Bootstrap js ======-->
    <script src="{{asset('assets/js/bootstrap.min.js') }}"></script>
    
    
    <!--====== Slick js ======-->
    <script src="{{asset('assets/js/slick.min.js') }}"></script>
    
    <!--====== Magnific Popup js ======-->
    <script src="{{asset('assets/js/jquery.magnific-popup.min.js') }}"></script>

    
    <!--====== nav js ======-->
    <script src="{{asset('assets/js/jquery.nav.js') }}"></script>
    
    <!--====== Nice Number js ======-->
    <script src="{{asset('assets/js/jquery.nice-number.min.js') }}"></script>
    
    <!--====== Main js ======-->
    <script src="{{asset('assets/js/main.js') }}"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>

    @yield('footer-scripts')

    <script>
        window.onbeforeunload = function(){
            window.scrollTo(0,0);
        }
    </script>

</body>

</html>
