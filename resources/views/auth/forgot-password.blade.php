@extends('layouts.auth.base')

@section('title', 'Forgot Password')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-12 col-lg-4">
            <div class="card login-box-container">
                <div class="card-body">
                    <div class="authent-logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="">
                    </div>
                    <div class="authent-text">
                        <h4>Reset Password</h4>
                        <small>Don't worry, we'll help you reset your password.</small>
                    </div>
                    <form method="POST" action="{{ route('password.otp.request') }}" onsubmit="return processForm(this)">
                        @csrf
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" placeholder="Your Phone Number" required autofocus>
                                <label for="phone_number">Phone Number</label>
                                @error('phone_number')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-info m-b-xs">Send OTP</button>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-between mt-4 px-4 mb-4">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalTos">Terms and Conditions</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacyPolicy">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>
@endsection








