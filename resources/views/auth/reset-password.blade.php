@extends('layouts.auth.base')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-12 col-lg-4">
            <div class="card login-box-container">
                <div class="card-body">
                    <div class="authent-logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="">
                    </div>
                    <div class="authent-text">
                        <h4>Enter Your New Password</h4>
                        <small>One step closer to accessing your account.</small>
                    </div>
                    <form method="POST" action="{{ route('password.otp.update') }}" onsubmit="return processForm(this)">
                        @csrf
                        <input type="hidden" name="phone_number" id="phone_number" value="{{ old('phone_number', request('phone_number')) }}">
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp" name="otp" placeholder="Your OTP" required autofocus>
                                <label for="otp">OTP</label>
                                @error('otp')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Your Password" required>
                                <label for="password">Password</label>
                                @error('password')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Your Password" required>
                                <label for="password_confirmation">Confirm Password</label>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-info m-b-xs">Reset Password</button>
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








