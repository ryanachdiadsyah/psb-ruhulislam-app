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
                        <h4>Welcome to {{ env('APP_NAME') }}</h4>
                        <small>Please Sign-up to create your account.</small>
                    </div>
                    <form method="POST" action="{{ route('register') }}" onsubmit="return processForm(this)">
                        @csrf
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Your Full Name" required autofocus>
                                <label for="name">Full Name</label>
                                @error('name')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
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
                            <button type="submit" class="btn btn-info m-b-xs">Sign Up</button>
                        </div>
                    </form>
                    <div class="authent-reg">
                        <p>I already have an account. <a href="{{ route('login') }}">Sign In</a></p>
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








