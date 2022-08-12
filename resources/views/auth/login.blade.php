@extends('auth.master')

@section('head')
<div class="fxt-transformX-L-50 fxt-transition-delay-5">
    <div class="fxt-middle-content">
        <h1 class="fxt-main-title">Sign In</h1>
        <div class="fxt-switcher-description1">If you don’t have an account You can<a href="{{route('auth.register')}}" class="fxt-switcher-text ms-2">Sign Up</a></div>
    </div>
</div>
<div class="fxt-transformX-L-50 fxt-transition-delay-7">
    <div class="fxt-qr-code">
        <img src="{{asset('img/elements/qr-login-34.png')}}" alt="QR">
    </div>
</div>
@endsection

@section('content')
<div class="fxt-form">
    <form method="POST">
        <div class="form-group">
            <input type="email" id="email" class="form-control" name="email" placeholder="Enter Email or Mobile Number" required="required">
        </div>
        <div class="form-group">
            <input id="password" type="password" class="form-control" name="password" placeholder="********" required="required">
            <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
        </div>
        <div class="form-group">
            <div class="fxt-switcher-description2 text-right">
                <a href="{{route('auth.forgot_password')}}" class="fxt-switcher-text">Recovery Password</a>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="fxt-btn-fill">Sign In</button>
        </div>
    </form>
</div>
<div class="fxt-style-line">
    <span>Or continue with</span>
</div>
<ul class="fxt-socials">
    <li class="fxt-google">
        <a href="{{route('auth.redirect', ['social' => 'google'])}}" title="google"><i class="fab fa-google"></i></a>
    </li>
    <li class="fxt-github">
        <a href="{{route('auth.redirect', ['social' => 'github'])}}" title="github"><i class="fab fa-github"></i></a>
    </li>
    <li class="fxt-gitlab">
        <a href="{{route('auth.redirect', ['social' => 'gitlab'])}}" title="gitlab"><i class="fab fa-gitlab"></i></a>
    </li>
    <li class="fxt-linkedin">
        <a href="{{route('auth.redirect', ['social' => 'linkedin'])}}" title="linkedin"><i class="fab fa-linkedin"></i></a>
    </li>
    <li class="fxt-facebook">
        <a href="{{route('auth.redirect', ['social' => 'facebook'])}}" title="Facebook"><i class="fab fa-facebook-f"></i></a>
    </li>
</ul>
@endsection
