@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Добавление сервера</h1>
        <a href="{{ route('server.index') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-list fa-sm text-white-50"></i> Вернуться к списку</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Новый сервер</h6>
        </div>
        <div class="card-body">
            <form class="form" method="post" action="{{ route('server.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название сервера</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control @error('last_name') is-invalid @enderror"
                               id="name" value="{{ old('name') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="users" class="col-sm-2 col-form-label">Серверные пользователи</label>
                    <div class="col-sm-10">
                        <input type="text" name="users" class="form-control @error('users') is-invalid @enderror"
                               id="users" value="{{ old('users') }}" placeholder="например, root,admin,deploy" required>
                        <small class="form-text text-muted">
                            Список пользователей, указанный через запятую, доступ к которым необходимо предоставить на
                            сервере
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="system_os" class="col-sm-2 col-form-label">Операционная система</label>
                    <div class="col-sm-10">
                        <select name="system_os" class="form-control @error('system_os') is-invalid @enderror"
                                id="system_os">
                            <option>Выберите операционную систему сервера</option>
                            @foreach($systemOs as $system)
                                <option value="{{ $system->id }}">{{ $system->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Добавить сервер</button>
            </form>
        </div>
    </div>
@endsection
