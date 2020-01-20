@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Добавление пользователя</h1>
        <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-list fa-sm text-white-50"></i> Вернуться к списку</a>
    </div>

    @component('components.card')
        @slot('title')
            Новый пользователь
        @endslot
        <form class="form" method="post" action="{{ route('user.store') }}">
            @csrf

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Имя</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           id="name" value="{{ old('name') }}" required autocomplete="name">
                </div>
            </div>

            <div class="form-group row">
                <label for="last_name" class="col-sm-2 col-form-label">Фамилия</label>
                <div class="col-sm-10">
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                           id="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Эл. почта</label>
                <div class="col-sm-10">
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" value="{{ old('email') }}" required autocomplete="email">
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Пароль</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" value="{{ old('password') }}" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row">
                <label for="password_confirmation" class="col-sm-2 col-form-label">Пароль еще раз</label>
                <div class="col-sm-10">
                    <input type="password" name="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           id="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Добавить пользователя</button>
        </form>
    @endcomponent
@endsection
