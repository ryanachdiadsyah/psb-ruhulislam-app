@extends('layouts.wizard.base')

@section('title', 'Step 1')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-12 col-lg-6">
            <div class="card login-box-container">
                <div class="card-body">
                    <div class="authent-logo">
                        <h3>Step 1 - Welcome</h3>
                    </div>
                    <div class="authent-text">
                        <h4>Tentukan Jalur Pendaftaran</h4>
                        <small></small>
                    </div>
                    <form method="POST" action="{{ route('wizard.step1') }}" onsubmit="return processForm(this)">
                    @csrf

                        {{-- OVERRIDE CODE (muncul hanya kalau backend error) --}}
                        @error('override_code')
                            <div class="alert alert-warning">
                                {{ $message }}
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kode Izin Daftar Panitia</label>
                                <input type="text"
                                    name="override_code"
                                    class="form-control @error('override_code') is-invalid @enderror"
                                    value="{{ old('override_code') }}">
                            </div>
                        @enderror

                        {{-- PILIH JALUR --}}
                        <div class="mb-3">
                            <label class="form-label">Jalur Pendaftaran</label>
                            <select name="path_code"
                                    class="form-select @error('path_code') is-invalid @enderror"
                                    required>
                                <option value="" disabled selected>Pilih Jalur</option>
                                <option value="INVITATION" @selected(old('path_code') === 'INVITATION')>
                                    Undangan
                                </option>
                                <option value="REGULAR" @selected(old('path_code') === 'REGULAR')>
                                    Reguler 
                                </option>
                            </select>
                            @error('path_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- INVITATION CODE --}}
                        <div class="mb-3">
                            <label class="form-label">Kode Undangan</label>
                            <input type="text"
                                name="invite_code"
                                class="form-control form-control-lg @error('invite_code') is-invalid @enderror"
                                value="{{ old('invite_code') }}">
                            @error('invite_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Next Step
                        </button>
                    </form>
                </div>
                <div class="d-flex justify-content-center mt-4 px-4 mb-4">
                    <form action="{{ route('logout') }}" method="POST">
                        <p>I'm give up 😩
                        @csrf
                        <a href="javascript:void(0)" onclick="this.closest('form').submit();">Logout</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection