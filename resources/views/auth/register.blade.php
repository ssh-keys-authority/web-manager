@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">{{ __('New account!') }}</h1>
                            </div>
                            <form class="user" method="post" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text"
                                               class="form-control form-control-user @error('name') is-invalid @enderror"
                                               id="name"
                                               name="name"
                                               value="{{ old('name') }}"
                                               placeholder="{{ __('Name') }}"
                                               required autocomplete="name" autofocus>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text"
                                               class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                               id="last_name"
                                               name="last_name"
                                               value="{{ old('last_name') }}"
                                               placeholder="{{ __('Last Name') }}"
                                               required autocomplete="last_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email"
                                           class="form-control form-control-user @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="{{ __('Email') }}"
                                           required autocomplete="email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password"
                                               class="form-control form-control-user @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               placeholder="{{ __('Password') }}"
                                               required autocomplete="new-password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password"
                                               class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               placeholder="{{ __('Confirm Password') }}"
                                               required autocomplete="new-password">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    {{ __('Sign up') }}
                                </button>
                            </form>
                            <hr>
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="small"
                                       href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                                </div>
                            @endif
                            <div class="text-center">
                                <a class="small"
                                   href="{{ route('login') }}">{{ __('Already registered? Sign in!') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
