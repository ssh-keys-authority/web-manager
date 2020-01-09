@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Сброс пароля</h1>
                                        <p class="mb-4">Уже почти все, укажите ниже ваш новый пароль</p>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('password.update') }}">
                                        @csrf

                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="form-group">
                                            <input type="email"
                                                   class="form-control form-control-user @error('email') is-invalid @enderror"
                                                   id="email"
                                                   name="email"
                                                   value="{{ $email ?? old('email') }}"
                                                   placeholder="Электронная почта"
                                                   required autocomplete="email" autofocus>
                                        </div>

                                        <div class="form-group">
                                            <input type="password"
                                                   class="form-control form-control-user @error('password') is-invalid @enderror"
                                                   id="password"
                                                   name="password"
                                                   placeholder="Новый пароль"
                                                   required autocomplete="new-password">
                                        </div>

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <div class="form-group">
                                            <input type="password"
                                                   class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   placeholder="Новый пароль еще раз"
                                                   required autocomplete="new-password">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Сбросить пароль
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
