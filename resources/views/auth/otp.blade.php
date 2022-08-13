@extends('auth.master')
@section('head')

<div class="fxt-transformX-L-50 fxt-transition-delay-5">
    <div class="fxt-middle-content">
        <h1 class="fxt-main-title">Validate OTP</h1>
        <div class="fxt-switcher-description1">Please enter the OTP (one time password) to verify your account. A Code has been sent to {{$email}}</div>
    </div>
</div>
<div class="fxt-transformX-L-50 fxt-transition-delay-7">
    <div class="fxt-qr-code">
        <img src="{{asset('img/elements/qr-otp-34.png')}}" alt="QR">
    </div>
</div>
@endsection

@section('content')
<div class="fxt-form">
    <a href="#" class="fxt-otp-logo"><img src="{{asset('img/elements/otp-icon.png')}}" alt="Otp Logo"></a>
    <form id="otp-form" method="POST" action="{{$type === 'register' ? route('auth.verify_register') : route('auth.verify_new_location') }}">
        @csrf
        <input name="device_id" id="device_id" type="hidden">
        <label for="reset" class="fxt-label">Enter OTP Code Here</label>
        <div class="fxt-otp-row">
            <input id="digit_1" type="text" class="fxt-otp-col otp-input form-control" maxlength="1" required="required" autofocus>
            <input id="digit_2" type="text" class="fxt-otp-col otp-input form-control" maxlength="1" required="required">
            <input id="digit_3" type="text" class="fxt-otp-col otp-input form-control" maxlength="1" required="required">
            <input id="digit_4" type="text" class="fxt-otp-col otp-input form-control" maxlength="1" required="required">
            <input type="hidden" name="email" value="{{$email}}">
            <input id="token_verify" type="hidden" name="token_verify">
        </div>
        @if(session()->has('message'))
            <div class="alert alert-danger" role="alert">
                {{session()->get('message')}}
            </div>
        @endif
        <div class="fxt-otp-btn">
            <button type="submit" class="fxt-btn-fill">Verify</button>
        </div>
    </form>
    <div class="fxt-switcher-description3">Not received your code?<a href="" class="fxt-switcher-text ms-1">Resend code</a></div>
</div>
@endsection

@section('script')
    <script src="{{asset('js/device-uuid.js')}}"></script>
    <script>
        let device_id = new DeviceUUID().get()
        $('#device_id').val(device_id)
    </script>
    <script>
        $( document ).ready(function () {
            $('#otp-form').submit(function () {
                let verify_token = $('#digit_1').val() + $('#digit_2').val() + $('#digit_3').val() + $('#digit_4').val()
                $('#token_verify').val(verify_token)
            })
        })
    </script>
@endsection
