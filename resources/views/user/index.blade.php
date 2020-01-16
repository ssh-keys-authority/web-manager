@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Пользователи</h1>
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Новый пользователь</a>
    </div>

    @component('components.card')
        @slot('title')
            Список пользователей
        @endslot

        @if(count($users) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Эл. почта</th>
                    <th>Ключей</th>
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
                               class="btn btn-sm btn-primary shadow-sm">Управление</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Вы еще не добавили ни одного пользователя.</p>
        @endif
    @endcomponent
@endsection
