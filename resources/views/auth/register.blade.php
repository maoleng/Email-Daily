@extends('auth.master')
@section('head')

<div class="fxt-transformX-L-50 fxt-transition-delay-5">
    <div class="fxt-middle-content">
        <h1 class="fxt-main-title">Sign Up to Rechage Direct</h1>
        <div class="fxt-switcher-description1">If you have an account You can<a href="{{route('auth.login)}}" class="fxt-switcher-text ms-2">Sign In</a></div>
    </div>
</div>
<div class="fxt-transformX-L-50 fxt-transition-delay-7">
    <div class="fxt-qr-code">
        <img src="{{asset('img/elements/qr-register-34.png')}}" alt="QR">
    </div>
</div>
@endsection

@section('content')
<div class="fxt-form">
    <form method="POST">
        <div class="form-group">
            <input type="text" id="l_name" class="form-control" name="l_name" placeholder="Last Name" required="required">
        </div>
        <div class="form-group">
            <input type="email" id="email" class="form-control" name="email" placeholder="E-mail Address" required="required">
        </div>
        <div class="form-group">
            <input id="password" type="password" class="form-control" name="password" placeholder="********" required="required">
            <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
        </div>
        <div class="form-group">
            <div class="fxt-checkbox-box">
                <input id="checkbox1" type="checkbox">
                <label for="checkbox1" class="ps-4">I agree with <a
                        class="terms-link" href="#">Terms</a> and <a class="terms-link" href="#">Privacy Policy</a></label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="fxt-btn-fill">Sign Up</button>
        </div>
    </form>
</div>
<div class="fxt-style-line">
    <span>Or continue with</span>
</div>
<ul class="fxt-socials">
    <li class="fxt-google">
        <a href="#" title="google"><i class="fab fa-google"></i></a>
    </li>
    <li class="fxt-github">
        <a href="#" title="github"><i class="fab fa-github"></i></a>
    </li>
    <li class="fxt-gitlab">
        <a href="#" title="gitlab"><i class="fab fa-gitlab"></i></a>
    </li>
    <li class="fxt-linkedin">
        <a href="#" title="linkedin"><i class="fab fa-linkedin"></i></a>
    </li>
    <li class="fxt-facebook">
        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
    </li>
</ul>
@endsection
