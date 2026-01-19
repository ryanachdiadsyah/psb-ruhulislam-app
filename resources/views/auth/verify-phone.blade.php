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

                @if (session('status'))
                    <div class="alert alert-dismissible bg-light-{{ session('status') }} d-flex flex-column flex-sm-row p-5 mb-10">
                        <i class="ki-duotone ki-notification-bing fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <h4 class="fw-semibold"></h4>
                            <span>{{ session('message') }}</span>
                        </div>
                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                            <i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                        </button>
                    </div>
                @endif

                <form method="POST" action="{{ route('phone.verify.request') }}">
                @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="submit" class="btn-check" name="channel" value="whatsapp" id="channel_whatsapp"/>
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-10" for="channel_whatsapp">
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
                            <input type="submit" class="btn-check" name="channel" value="sms" id="channel_sms"/>
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="channel_sms">
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
                    </div>
                </form>

                <form method="POST" action="{{ route('phone.verify') }}">
                    @csrf
                    <div class="fv-row mb-8">
                        <input type="text" name="otp" id="otp" placeholder="Enter OTP" class="form-control bg-transparent @error('otp') is-invalid @enderror" required />
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
            </div>
        </div>
    </div>
@endsection