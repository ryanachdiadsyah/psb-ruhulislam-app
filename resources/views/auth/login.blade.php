@extends('layouts.auth.base')

@section('content')
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
            <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="text-center mb-11">
                            <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
                            <div class="text-gray-500 fw-semibold fs-6">To Get Access to this application</div>
                        </div>
                        <div class="fv-row mb-8">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" placeholder="0812xxxx" name="phone_number" id="phone_number" class="form-control bg-transparent" required />
                        </div>
                        <div class="fv-row mb-3">
                            <label for="password">Password</label>
                            <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" required />
                        </div>
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div></div>
                            <a href="{{ route('password.request') }}" class="link-primary">Forgot Password ?</a>
                        </div>
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <span class="indicator-label">Sign In</span>
                                <span class="indicator-progress">Please wait... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <div class="text-gray-500 text-center fw-semibold fs-6">I don't have an account. 
                        <a href="{{ route('register') }}" class="link-primary">Sign up</a></div>
                    </form>
                </div>
                <div class="d-flex flex-stack">
                    <div class="d-flex fw-semibold text-primary fs-base gap-5">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalTos">Terms and Conditions</a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacyPolicy">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection