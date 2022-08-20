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
    <form method="POST" action="{{route('auth.process_login')}}">
        @csrf
        <input name="device_id" id="device_id" type="hidden">
        <div class="form-group">
            <input type="email" id="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Enter Email or Mobile Number" required="required">
            @if ($errors->default->get('email'))
                {{ $errors->default->get('email')[0] }}
            @endif
        </div>
        <div class="form-group">
            <input id="password" type="password" class="form-control" name="password" {{old('password')}} placeholder="********" required="required">
            <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
            @if ($errors->default->get('password'))
                {{ $errors->default->get('password')[0] }}
            @endif
        </div>
        <div class="form-group">
            <div class="fxt-switcher-description2 text-right">
                <a href="{{route('auth.forgot_password')}}" class="fxt-switcher-text">Recovery Password</a>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="fxt-btn-fill">Sign In</button>
        </div>
        @if(session()->has('message'))
            <div class="{{empty(session()->get('alert_class')) ? 'alert alert-danger' : session()->get('alert_class')}}" role="alert">
                {{session()->get('message')}}
            </div>
        @endif
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

