@extends('auth.master')

@section('head')

<div class="fxt-transformX-L-50 fxt-transition-delay-5">
    <div class="fxt-middle-content">
        <h1 class="fxt-main-title">Reset Password</h1>
        <div class="fxt-switcher-description1">Enter the email address or mobile number associated</div>
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
    <form method="POST" action="{{route('auth.reset_password')}}">
        @csrf
        <input name="device_id" id="device_id" type="hidden">
        <div class="form-group">
            <label for="email" class="fxt-label">Email</label>
            <input type="email" id="email" class="form-control" name="email" placeholder="Enter Email or Mobile Number" required="required">
            @if ($errors->default->get('email'))
                {{ $errors->default->get('email')[0] }}
            @endif
        </div>
        <div class="form-group">
            <button type="submit" class="fxt-btn-fill">Sign In</button>
        </div>
    </form>
    <div class="fxt-switcher-description3">Return to?<a href="{{route('auth.login')}}" class="fxt-switcher-text ms-1">Log in</a></div>
</div>
@endsection

@section('script')
    <script src="{{asset('js/device-uuid.js')}}"></script>
    <script>
        let device_id = new DeviceUUID().get()
        $('#device_id').val(device_id)
    </script>
@endsection

