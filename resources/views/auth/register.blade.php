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
                                <h1 class="h4 text-gray-900 mb-4">Новый аккаунт!</h1>
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
                                               placeholder="Имя"
                                               required autocomplete="name" autofocus>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text"
                                               class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                               id="last_name"
                                               name="last_name"
                                               value="{{ old('last_name') }}"
                                               placeholder="Фамилия"
                                               required autocomplete="last_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email"
                                           class="form-control form-control-user @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="Электронная почта"
                                           required autocomplete="email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password"
                                               class="form-control form-control-user @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               placeholder="Пароль"
                                               required autocomplete="new-password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password"
                                               class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               placeholder="Пароль еще раз  "
                                               required autocomplete="new-password">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Зарегистрироваться
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('password.request') }}">Забыли пароль?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Уже зарегистрированы? Войти!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
