@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $user->full_name }}</h1>
        <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-list fa-sm text-white-50"></i> Вернуться к списку</a>
    </div>

    @if ($key = session('key.destroyed'))
        <div class="alert alert-success">
            <h4 class="alert-heading">Ключ удален</h4>

            <p>Ключ {{ $key }} будет удален с сервера при следующей синхронизации</p>
        </div>
    @endif

    @component('components.card')
        @slot('title')
            Управление пользователем
        @endslot
        @slot('actions')
            <a href="#" data-toggle="modal" data-target="#destroyUser" class="btn btn-sm btn-danger shadow-sm">
                <i class="fas fa-trash fa-sm mr-1 text-white-50"></i> Удалить</a>
        @endslot

        <table class="table">
            <tr>
                <td>Пользователь</td>
                <td>{{ $user->full_name }}</td>
            </tr>
            <tr>
                <td>Эл. почта</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td>Дата регистрации</td>
                <td>{{ $user->created_at->isoFormat('DD MMMM YYYY') }}</td>
            </tr>

        </table>
    @endcomponent

    @component('components.card')
        @slot('title')
            Управление ключами
        @endslot
        <table class="table">
            <thead>
            <tr>
                <th>Название</th>
                <th>Хеш</th>
                <th></th>
            </tr>
            </thead>
            @foreach($user->keys as $key)
                <tr>
                    <td>{{ $key->name }}</td>
                    <td>{{ $key->hash }}</td>
                    <td class="text-right">
                        <a href="#" data-toggle="modal" data-target="#destroyKey-{{ $key->id }}"
                           class="btn btn-sm btn-danger shadow-sm">
                            <i class="fas fa-trash fa-sm mr-1 text-white-50"></i> Удалить</a>
                    </td>
                </tr>
            @endforeach
        </table>

        <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#storeKey" role="button"
               aria-expanded="false" aria-controls="storeAccount">
                Новый ключ
            </a>
        </p>
        <div class="collapse @if($errors->any()) show @endif" id="storeKey">
            <div class="card card-body">
                <form method="POST" action="{{ route('key.store', $user) }}">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Название ключа</label>
                        <div class="col-sm-10">
                            <input type="text" name="name"
                                   class="form-control @error('last_name') is-invalid @enderror"
                                   id="name" value="{{ old('name') }}" required>
                            <small class="form-text text-muted">
                                Название ключ, по которому вы сможете его идентифицировать
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="key" class="col-sm-2 col-form-label">Название ключа</label>
                        <div class="col-sm-10">
                            <textarea name="key"
                                      class="form-control @error('key') is-invalid @enderror"
                                      id="key" rows="5" required>{{ old('key') }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Добавить аккаунт</button>
                </form>
            </div>
        </div>
    @endcomponent

    <div class="modal fade" id="destroyUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('user.destroy', $user) }}">
                @method('delete')
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Вы уверены?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Закрыть">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">После удаления, сервер невозможно будет восстановить.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Я передумал</button>
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @foreach($user->keys as $key)
        <div class="modal fade" id="destroyKey-{{ $key->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST" action="{{ route('key.destroy', [$user, $key]) }}">
                    @method('delete')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Вы уверены?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Закрыть">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">После удаления, ключ невозможно будет воостановить.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Я передумал</button>
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
