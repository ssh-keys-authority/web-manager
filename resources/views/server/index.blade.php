@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Серверы</h1>
        <a href="{{ route('server.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Новый сервер</a>
    </div>

    @if (session('server.destroyed'))
        <div class="alert alert-success">
            <h4 class="alert-heading">Сервер удален</h4>

            <p>Для завершения вам необходимо удалить клиента с вашего сервера с помощью следующей команды:</p>

            <pre>sudo rm /etc/cron.d/ssh-authority-manager && sudo rm -r /etc/ssh-authority-manager && sudo rm /usr/local/bin/ssh-authority-manager</pre>
        </div>
    @endif

    @component('components.card')
        @slot('title')
            Список серверов
        @endslot

        @if(count($servers) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>Сервер</th>
                    <th>Пользователей</th>
                    <th>Последнее обновление</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($servers as $server)
                    <tr>
                        <td class="sorting_1">{{ $server->name }}</td>
                        <td>{{ $server->accounts->count() }}</td>
                        <td>
                            @if($server->isActivated())
                                <span class="badge badge-pill badge-success py-2 px-3">
                                    <i class="fas fa-check-circle text-white-50 mr-1"></i>
                                    {{ $server->last_sync->diffForHumans() }}
                                </span>
                            @else
                                <span class="badge badge-pill badge-danger py-2 px-3">
                                    <i class="fas fa-times-circle text-white-50 mr-1"></i>
                                    Сервер не настроен
                                </span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('server.show', $server) }}"
                               class="btn btn-sm btn-primary shadow-sm">Управление</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Вы еще не добавили ни одного сервера.</p>
        @endif
    @endcomponent
@endsection
