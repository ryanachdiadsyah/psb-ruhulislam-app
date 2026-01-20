@extends('layouts.auth.base')

@section('title', 'Login')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-12 col-lg-4">
            <div class="card login-box-container">
                <div class="card-body">
                    <div class="authent-logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="">
                    </div>
                    <div class="authent-text">
                        <h4>Welcome to {{ env('APP_NAME') }}</h4>
                        <small>Please Sign-in to your account.</small>
                    </div>
                    <form method="POST" action="{{ route('login') }}" onsubmit="return processForm(this)">
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
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Your Password" required>
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-info m-b-xs">Sign In</button>
                        </div>
                    </form>
                    <div class="authent-reg">
                        <p>I don't have an account. <a href="{{ route('register') }}">Create an account</a></p>
                        <p>I lost my password. <a href="{{ route('password.request') }}" class="text-danger">Reset password</a></p>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4 px-4 mb-4">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalTos">Terms and Conditions</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacyPolicy">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>
@endsection








