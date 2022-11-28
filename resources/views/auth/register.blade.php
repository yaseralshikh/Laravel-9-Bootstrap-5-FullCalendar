@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-end">
                                    {{ __('Name') }} :
                                </label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- E-Mail Address -->
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-end">
                                    {{ __('E-Mail Address') }} :
                                </label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Specialization -->
                            <div class="mb-3 row">
                                <label for="specialization_id" class="col-md-4 col-form-label text-end">
                                    {{ __('Specialization') }} :
                                </label>

                                <div class="col-md-6">
                                    {{-- <input id="specialization" type="text" class="form-control @error('specialization') is-invalid @enderror"
                                        name="specialization" value="{{ old('specialization') }}" required autocomplete="specialization" autofocus> --}}

                                    <select name="specialization_id" class="form-select" aria-label="Default select example" @error('specialization_id') is-invalid @enderror>
                                        {{-- <option selected>Open this select menu</option> --}}
                                        @foreach ($specializations as $specialization)
                                            <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('specialization_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mobile -->
                            <div class="mb-3 row">
                                <label for="mobile" class="col-md-4 col-form-label text-end">
                                    {{ __('Mobile') }} :
                                </label>

                                <div class="col-md-6">
                                    <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                                        name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>

                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-end">
                                    {{ __('Password') }} :
                                </label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-end">
                                    {{ __('Confirm Password') }} :
                                </label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
