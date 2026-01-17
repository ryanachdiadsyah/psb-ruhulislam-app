@extends('layouts.auth.base')

@section('content')
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
            <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="#">
                        <div class="text-center mb-11">
                            <h1 class="text-gray-900 fw-bolder mb-3">Forgot Password</h1>
                            <div class="text-gray-500 fw-semibold fs-6">Enter your phone number to reset your password</div>
                        </div>
                        <div class="fv-row mb-8">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" placeholder="0812xxxx" name="phone_number" id="phone_number" class="form-control bg-transparent" required />
                        </div>
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <span class="indicator-label">Reset Password</span>
                                <span class="indicator-progress">Please wait... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="d-flex flex-stack">
                    <div class="d-flex fw-semibold text-primary fs-base gap-5">
                        <a href="pages/team.html" target="_blank">Terms</a>
                        <a href="pages/contact.html" target="_blank">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection