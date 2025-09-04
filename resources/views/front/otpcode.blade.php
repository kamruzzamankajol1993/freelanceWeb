@extends('front.master.master')
@section('title')
OTP Verification
@endsection

@section('css')
<style>
    .otp-input { width: 50px; height: 50px; text-align: center; font-size: 1.5rem; margin: 0 5px; border-radius: 8px; border: 1px solid #ced4da; }
    .otp-input:focus { border-color: #80bdff; outline: 0; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); }
    #resendOtpLink { cursor: pointer; color: #0d6efd; }
    #resendOtpLink.disabled { color: #6c757d; cursor: not-allowed; text-decoration: none; }
</style>
@endsection

@section('body')
<div class="profile-container-fluid overflow-hidden py-4">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <div class="otp-container text-center" style="max-width: 450px;">
                <h6>Please check your email</h6>
                <p>We've sent a code to <strong id="otpEmail">{{ session('email') }}</strong></p>
                
                @if (session('status'))
                    <div class="alert alert-success mt-3">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
                    @csrf
                    <div class="d-flex justify-content-center my-4">
                        <input type="text" name="otp_1" class="otp-input" maxlength="1" data-index="0" placeholder="0" required>
                        <input type="text" name="otp_2" class="otp-input" maxlength="1" data-index="1" placeholder="0" required>
                        <input type="text" name="otp_3" class="otp-input" maxlength="1" data-index="2" placeholder="0" required>
                        <input type="text" name="otp_4" class="otp-input" maxlength="1" data-index="3" placeholder="0" required>
                    </div>
                    <input type="hidden" name="otp" id="otp" />
                    <div class="text-center">
                        <button type="submit" class="btn access-now-btn px-5">Verify OTP</button>
                    </div>
                </form>

                <!-- Dynamic Resend Section -->
                <div class="resend-text mb-3 mt-4">
                    Didn't get a code? 
                    <a href="#" id="resendOtpLink">Click to resend.</a>
                    <span id="resendTimer" class="text-muted" style="display: none;">Resend in <span id="timerValue">60</span>s</span>
                </div>

                <!-- Hidden form for the resend action -->
                <form id="resendForm" action="{{ route('otp.resend') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection

