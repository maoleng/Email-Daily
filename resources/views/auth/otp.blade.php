@extends('auth.master')
@section('head')

<div class="fxt-transformX-L-50 fxt-transition-delay-5">
    <div class="fxt-middle-content">
        <h1 class="fxt-main-title">Validate OTP</h1>
        <div class="fxt-switcher-description1">Please enter the OTP (one time password) to verify your account. A Code has been sent to +2*******337</div>
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
    <form method="POST" id="otp-form">
        <label for="reset" class="fxt-label">Enter OTP Code Here</label>
        <div class="fxt-otp-row">
            <input type="text" class="fxt-otp-col otp-input form-control" maxlength="1" required="required">
            <input type="text" class="fxt-otp-col otp-input form-control" maxlength="1" required="required">
            <input type="text" class="fxt-otp-col otp-input form-control" maxlength="1" required="required">
            <input type="text" class="fxt-otp-col otp-input form-control" maxlength="1" required="required">
        </div>
        <div class="fxt-otp-btn">
            <button type="submit" class="fxt-btn-fill">Verify</button>
        </div>
    </form>
    <div class="fxt-switcher-description3">Not received your code?<a href="" class="fxt-switcher-text ms-1">Resend code</a></div>
</div>
@endsection
