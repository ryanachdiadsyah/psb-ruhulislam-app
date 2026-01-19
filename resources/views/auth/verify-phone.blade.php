@extends('layouts.auth.base2')
@php
    $otpSent = session('otp_sent');
@endphp
@section('content')
    <div class="d-flex flex-column flex-center text-center p-10">
        <div class="card card-flush w-lg-650px py-5">
            <div class="card-body py-15 py-lg-20">
                <div class="mb-14">
                    <a href="index.html" class="">
                        <img alt="Logo" src="{{ asset('assets/media/logos/custom-2.svg') }}" class="h-40px" />
                    </a>
                </div>
                <h1 class="fw-bolder text-gray-900 mb-5">Please verify your phone number</h1>
                <div class="fw-semibold fs-6 text-gray-500 mb-8">This is will make your account more secure, and we can verify your are a real person.</div>

                @if (session('status'))
                    <div class="alert alert-dismissible bg-light-{{ session('status') }} d-flex flex-column flex-sm-row p-5 mb-10">
                        <i class="ki-duotone ki-notification-bing fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <h4 class="fw-semibold"></h4>
                            <p>{{ session('message') }}</p>
                        </div>
                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                            <i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                        </button>
                    </div>
                @endif

                <form method="POST" action="{{ route('phone.verify.request') }}">
                @csrf
                    <div class="row mb-10">
                        <div class="col-lg-6">
                            <input type="submit" class="btn-check" name="channel" value="whatsapp" id="channel_whatsapp" {{ $otpSent ? 'disabled' : '' }}/>
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-10" for="channel_whatsapp" {{ $otpSent ? 'disabled opacity-50' : '' }}>
                                <i class="ki-duotone ki-whatsapp fs-3x me-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                                <span class="d-block fw-semibold text-start">
                                    <span class="text-gray-900 fw-bold d-block fs-4 mb-2">WhatsApp</span>
                                    <span class="text-muted fw-semibold fs-6">We will send the OTP via WhatsApp</span>
                                </span>
                            </label>
                        </div>
                        <div class="col-lg-6">
                            <input type="submit" class="btn-check" name="channel" value="sms" id="channel_sms" {{ $otpSent ? 'disabled' : '' }}/>
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="channel_sms" {{ $otpSent ? 'disabled opacity-50' : '' }}>
                                <i class="ki-duotone ki-sms fs-3x me-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="d-block fw-semibold text-start">
                                    <span class="text-gray-900 fw-bold d-block fs-4 mb-2">SMS</span>
                                    <span class="text-muted fw-semibold fs-6">We will send the OTP via SMS</span>
                                </span>
                            </label>
                        </div>
                        <div class="col-lg-12">
                            <p>Dengan ini saya menyatakan bahwa saya telah menerima dan menyetujui <a href="javascript:void(0);">Syarat & Ketentuan</a> serta <a href="javascript:void(0);">Kebijakan Privasi</a> yang berlaku.</p>
                        </div>
                    </div>
                </form>


                <form method="POST" action="{{ route('phone.verify') }}" onsubmit="this.querySelector('button').disabled = true;">
                    @csrf
                    <div class="fv-row mb-8">
                        <input type="text" name="otp" id="otp" placeholder="Enter OTP" class="form-control bg-transparent @error('otp') is-invalid @enderror" required {{ !session('otp_sent') ? 'disabled' : '' }} />
                    </div>
                    @error('otp')
                        <div class="text-danger mb-5">{{ $message }}</div>
                    @enderror
                    @if (session('otp_sent_at'))
                    <div class="text-muted mb-5">
                        You can request a new OTP in
                        <span id="otp-timer">60</span> seconds.
                    </div>
                    @endif
                    <div class="d-grid mb-10">
                        <button type="submit" class="btn btn-primary" {{ !session('otp_sent') ? 'disabled' : '' }}>
                            <span class="indicator-label">Verify Phone</span>
                            <span class="indicator-progress">Please wait... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
                <form action="{{ route('logout') }}" method="POST">
                    <p>I'm give up, 
                    @csrf
                    <a href="javascript:void(0)" onclick="this.closest('form').submit();">Logout</a>
                    </p>
                </form>
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
