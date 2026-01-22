@extends('layouts.wizard.base')

@section('title', 'Step 2')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-12 col-lg-6">
            <div class="card login-box-container">
                <div class="card-body">
                    <div class="authent-logo">
                        <h3>Step 2 - Almost Finish</h3>
                    </div>
                    <div class="authent-text">
                        <p>Dari mana Anda mengetahui informasi PSB Ruhul Islam Anak Bangsa?</p>
                        <small></small>
                    </div>

                    {{-- GLOBAL ERROR (kalau ada) --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            Silakan pilih salah satu.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('wizard.step2') }}">
                        @csrf

                        {{-- LIST SOURCE --}}
                        @foreach ($sources as $source)
                            <div class="form-check mb-2">
                                <input
                                    class="form-check-input @error('information_source_id') is-invalid @enderror"
                                    type="radio"
                                    name="information_source_id"
                                    id="source_{{ $source->id }}"
                                    value="{{ $source->id }}"
                                    @checked(old('information_source_id') == $source->id)
                                >
                                <label class="form-check-label" for="source_{{ $source->id }}">
                                    {{ $source->description }}
                                </label>
                            </div>
                        @endforeach

                        @error('information_source_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="d-flex justify-content-center mt-4 gap-2">
                            <button type="submit" class="btn btn-primary">
                                Selesai & Masuk Dashboard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
