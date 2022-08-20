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
@include('auth.socials')
@endsection

@section('script')
    <script src="{{asset('js/device-uuid.js')}}"></script>
    <script>
        $(document).ready(function() {
            let device_id = new DeviceUUID().get()
            $('#device_id').val(device_id)

            $("li.fxt").on('click', function() {
                let type = this.className.split('-')[1]
                let input_device_id = "#form_" + type + "> input"
                $(input_device_id).val(device_id)
                $("#form_" + type).submit()
            })
        })
    </script>
@endsection
