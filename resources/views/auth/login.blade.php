@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Добро пожаловать!</h1>
                                    </div>

                                    <form method="POST" action="{{ route('login') }}" class="user">
                                        @csrf

                                        <div class="form-group">
                                            <input type="email"
                                                   class="form-control form-control-user @error('email') is-invalid @enderror"
                                                   id="email"
                                                   name="email"
                                                   value="{{ old('email') }}"
                                                   required autocomplete="email" autofocus
                                                   placeholder="Электронная почта">
                                        </div>
                                        <div class="form-group">
                                            <input type="password"
                                                   class="form-control form-control-user @error('email') is-invalid @enderror"
                                                   id="password"
                                                   name="password"
                                                   required autocomplete="current-password"
                                                   placeholder="Пароль">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input class="custom-control-input" type="checkbox"
                                                       name="remember"
                                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="remember">
                                                    Запомнить меня на этом устройстве</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Войти
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('password.request') }}">Забыли пароль?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">Создать новый аккаунт!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
