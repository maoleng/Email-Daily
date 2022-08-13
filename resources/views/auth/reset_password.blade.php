@extends('auth.master')

@section('head')
<div class="fxt-transformX-L-50 fxt-transition-delay-5">
    <div class="fxt-middle-content">
        <h1 class="fxt-main-title">New Password</h1>
        <div class="fxt-switcher-description1">Enter your new password</div>
    </div>
</div>
<div class="fxt-transformX-L-50 fxt-transition-delay-7">
    <div class="fxt-qr-code">
        <img src="{{asset('img/elements/qr-forgot-password-34.png')}}" alt="QR">
    </div>
</div>
@endsection

@section('content')
<div class="fxt-form">
    <form method="POST" action="{{route('auth.update_password')}}">
        @csrf
        <input type="hidden" name="email" value="{{$email}}">
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
        <div class="form-group">
            <button type="submit" class="fxt-btn-fill">Sign In</button>
        </div>
    </form>
    <div class="fxt-switcher-description3">Return to?<a href="{{route('auth.login')}}" class="fxt-switcher-text ms-1">Log in</a></div>
</div>
@endsection
