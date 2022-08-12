<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MaoLeng | Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('font/flaticon.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
<div id="preloader" class="preloader">
    <div class='inner'>
        <div class='line1'></div>
        <div class='line2'></div>
        <div class='line3'></div>
    </div>
</div>
<section class="fxt-template-animation fxt-template-layout34" data-bg-image="{{asset('img/elements/bg1.png')}}">
    <div class="fxt-shape">
        <div class="fxt-transformX-L-50 fxt-transition-delay-1">
            <img src="{{asset('img/elements/shape1.png')}}" alt="Shape">
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="fxt-column-wrap justify-content-between">
                    <div class="fxt-animated-img">
                        <div class="fxt-transformX-L-50 fxt-transition-delay-10">
                            <img src="{{asset('img/figure/bg34-1.png')}}" alt="Animated Image">
                        </div>
                    </div>
                    <div class="fxt-transformX-L-50 fxt-transition-delay-3">
                        <a href="https://maoleng.dev" class="fxt-logo"><img style="height:100px" src="{{asset('img/logo-34.png')}}" alt="Logo"></a>
                    </div>
                    @yield('head')
                </div>
            </div>
            <div class="col-lg-4">
                <div class="fxt-column-wrap justify-content-center">
                @yield('content')
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset('js/jquery-3.5.0.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.j')}}s"></script>
<script src="{{asset('js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('js/validator.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
@yield('script')
</body>
</html>
