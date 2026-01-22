@extends('layouts.auth.base')

@section('title', 'Verification')

@php
    $otpSent = session('otp_sent');
@endphp
@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-12 col-lg-4">
            <div class="card login-box-container">
                <div class="card-body">
                    <div class="authent-logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="">
                    </div>
                    <div class="authent-text">
                        <h4>Please verify your phone number</h4>
                    </div>
                    <div class="d-flex flex-column gap-5">
                        <form method="POST" action="{{ route('phone.verify.request') }}">
                            @csrf
                            <span class="mt-2">Choose your preferred verification method</span>
                            <div class="d-flex justify-content-between mt-2 gap-2">
                                <button type="submit" class="btn btn-primary w-100 me-2" name="channel" value="whatsapp" id="channel_whatsapp" {{ $otpSent ? 'disabled' : '' }}><i class="fab fa-whatsapp"></i> WhatsApp</button>
                                <button type="submit" class="btn btn-success w-100" name="channel" value="sms" id="channel_sms" {{ $otpSent ? 'disabled' : '' }}><i class="fas fa-envelope"></i> SMS</button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('phone.verify') }}" onsubmit="return processForm(this)">
                            @csrf
                            @if (session('otp_sent_at'))
                            <div class="text-danger">
                                You can request a new OTP in
                                <span id="otp-timer">60</span> seconds.
                            </div>
                            @endif
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp" name="otp" required>
                                    <label for="otp">YourOTP</label>
                                    @error('otp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" {{ !session('otp_sent') ? 'disabled' : '' }}>Verify Phone Number</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4 px-4 mb-4">
                    <form action="{{ route('logout') }}" method="POST">
                        <p>I'm give up 😩 
                        @csrf
                        <a href="javascript:void(0)" onclick="this.closest('form').submit();">Logout</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection




@push('scripts')
    @if (session('otp_sent_at'))
    <script>
        (function () {
            const sentAt = {{ session('otp_sent_at') }};
            const cooldown = 60; // seconds
            const timerEl = document.getElementById('otp-timer');

            function tick() {
                const now = Math.floor(Date.now() / 1000);
                const left = cooldown - (now - sentAt);

                if (left <= 0) {
                    timerEl.innerText = '0';
                    return;
                }

                timerEl.innerText = left;
                setTimeout(tick, 1000);
            }
            tick();
        })();
    </script>
    @endif
@endpush
