@extends('auth.master')

@section('head')
<div class="fxt-transformX-L-50 fxt-transition-delay-5">
    <div class="fxt-middle-content">
        <h1 class="fxt-main-title">Sign Up to Rechage Direct</h1>
        <div class="fxt-switcher-description1">If you have an account You can<a href="{{route('auth.login')}}" class="fxt-switcher-text ms-2">Sign In</a></div>
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
    <form id="form_submit" method="post" action="{{route('auth.process_register')}}">
        @csrf
        <input name="device_id" id="device_id" type="hidden">
        <div class="form-group">
            <label for="email" class="fxt-label">Email</label>
            <input name="email" value="{{old('email')}}" type="text" id="email" class="form-control" placeholder="Email" required="required">
            @if ($errors->default->get('email'))
                {{ $errors->default->get('email')[0] }}
            @endif
        </div>
        <div class="form-group">
            <label for="email" class="fxt-label">Mật khẩu</label>
            <input name="password" value="{{old('password')}}" id="password" type="password" class="form-control" placeholder="********" required="required">
            @if ($errors->default->get('password'))
                {{ $errors->default->get('password')[0] }}
            @endif
            <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
        </div>
        <div class="form-group">
            <label for="email" class="fxt-label">Nhập lại mật khẩu</label>
            <input name="retype_password" value="{{old('retype_password')}}" id="retype_password" type="password" class="form-control" placeholder="********" required="required">
            @if ($errors->default->get('retype_password'))
                {{ $errors->default->get('retype_password')[0] }}
            @endif
            <i toggle="#retype-password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
        </div>
{{--        <div class="form-group">--}}
{{--            <div class="fxt-checkbox-box">--}}
{{--                <input id="checkbox1" type="checkbox">--}}
{{--                <label for="checkbox1" class="ps-4">I agree with <a class="terms-link" href="#">Terms</a> and <a class="terms-link" href="#">Privacy Policy</a></label>--}}
{{--            </div>--}}
{{--        </div>--}}
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

@section('script')
    <script src="{{asset('js/device-uuid.js')}}"></script>
    <script>
        let device_id = new DeviceUUID().get()
        $('#device_id').val(device_id)
    </script>
@endsection
