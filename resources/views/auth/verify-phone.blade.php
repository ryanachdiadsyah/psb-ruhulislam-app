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
                <h1 class="fw-bolder text-gray-900 mb-5">Please verify your phone number</h1>
                <div class="fw-semibold fs-6 text-gray-500 mb-8">This is will make your account more secure, and we can verify your are a real person.</div>

                <form method="POST" action="{{ route('phone.verify') }}">
                    @csrf

                    <div class="fv-row mb-8">
                        <label for="otp">One-Time Password (OTP)</label>
                        <input type="text" name="otp" id="otp" placeholder="Enter OTP" class="form-control bg-transparent" required />
                    </div>

                    @error('otp')
                        <div class="text-danger mb-5">{{ $message }}</div>
                    @enderror

                    <div class="d-grid mb-10">
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Verify Phone</span>
                            <span class="indicator-progress">Please wait... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
                <form method="POST" action="{{ route('phone.verify.resend') }}">
                    @csrf
                    <div class="d-grid mb-10">
                        <button type="submit" class="btn btn-secondary">
                            <span class="indicator-label">Resend OTP</span>
                            <span class="indicator-progress">Please wait... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection