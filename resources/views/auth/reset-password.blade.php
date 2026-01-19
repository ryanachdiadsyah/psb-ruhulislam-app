@extends('layouts.auth.base2')
@section('content')
    <div class="d-flex flex-column flex-center text-center p-10">
        <div class="card card-flush w-lg-650px py-5">
            <div class="card-body py-15 py-lg-20">
                <div class="mb-14">
                    <a href="index.html" class="">
                        <img alt="Logo" src="{{ asset('assets/media/logos/custom-2.svg') }}" class="h-40px" />
                    </a>
                </div>
                <h1 class="fw-bolder text-gray-900 mb-5">Enter Your New Password</h1>
                <div class="fw-semibold fs-6 text-gray-500 mb-8">One step closer to accessing your account.</div>

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

                <form method="POST" action="{{ route('password.otp.update') }}">
                @csrf
                    <div class="fv-row mb-8">
                        <input type="hidden" name="phone_number" id="phone_number" value="{{ session('phone_number') ?? '' }}" required/>
                    </div>
                    <div class="fv-row mb-8">
                        <input type="text" name="otp" id="otp" placeholder="Enter OTP" class="form-control bg-transparent @error('otp') is-invalid @enderror" required/>
                    </div>
                    @error('otp')
                        <div class="text-danger mb-5">{{ $message }}</div>
                    @enderror
                    <div class="fv-row mb-3">
                        <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent @error('password') is-invalid @enderror" value="{{ old('password') ?? '' }}" required />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fv-row mb-3">
                        <input type="password" placeholder="Confirm Password" name="password_confirmation" autocomplete="off" class="form-control bg-transparent @error('password_confirmation') is-invalid @enderror" required />
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid mb-10">
                        <button type="submit" class="btn btn-primary" id="kt_password_reset_submit">
                            <span class="indicator-label">Reset Password</span>
                            <span class="indicator-progress">Please wait... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
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
