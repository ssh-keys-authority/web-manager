@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Add new Server') }}</h1>
        <a href="{{ route('server.index') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-list fa-sm text-white-50"></i> {{ __('Back to list') }}</a>
    </div>

    @component('components.card')
        @slot('title')
            {{ __('New Server') }}
        @endslot
        <form class="form" method="post" action="{{ route('server.store') }}">
            @csrf

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">{{ __('Server name') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           id="name" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="users" class="col-sm-2 col-form-label">{{ __('Server users') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="users" class="form-control @error('users') is-invalid @enderror"
                           id="users" value="{{ old('users') }}" placeholder="например, root,admin,deploy" required>
                    <small class="form-text text-muted">
                        {{ __('A comma-separated list of users that must be accessed on the server') }}
                    </small>
                </div>
            </div>

            <div class="form-group row">
                <label for="system_os" class="col-sm-2 col-form-label">{{ __('Operating System') }}</label>
                <div class="col-sm-10">
                    <select name="system_os" class="form-control @error('system_os') is-invalid @enderror"
                            id="system_os">
                        <option>{{ __('Select Server Operating System') }}</option>
                        @foreach($systemOs as $system)
                            <option value="{{ $system->id }}">{{ $system->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Add Server') }}</button>
        </form>
    @endcomponent
@endsection
