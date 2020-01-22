@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Users') }}</h1>
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> {{ __('New User') }}</a>
    </div>

    @if (session('user.destroyed'))
        <div class="alert alert-success">
            <h4 class="alert-heading">{{ __('User deleted') }}</h4>

            <p>{{ __('Server access will be updated during the next synchronization') }}</p>
        </div>
    @endif

    @component('components.card')
        @slot('title')
            {{ __('User list') }}
        @endslot

        @if(count($users) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Keys') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="sorting_1">{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->keys->count() }}</td>
                        <td class="text-right">
                            <a href="{{ route('user.show', $user) }}"
                               class="btn btn-sm btn-primary shadow-sm">{{ __('Manage') }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>{{ __('You have not added any users yet') }}</p>
        @endif
    @endcomponent
@endsection
