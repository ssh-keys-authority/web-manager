@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Сервер {{ $server->name }}</h1>
        <a href="{{ route('server.index') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-list fa-sm text-white-50"></i> Вернуться к списку</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Управление сервером</h6>
            <a href="#" data-toggle="modal" data-target="#destroyModal" class="btn btn-sm btn-danger shadow-sm">
                <i class="fas fa-trash fa-sm mr-1 text-white-50"></i> Удалить</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    @if($server->last_sync !== null)
                        <p>управление</p>
                    @else
                        <p>Чтобы завершить настройку, вам необходимо установить на сервер клиент, который будет
                            периодически обновлять ваши SSH-ключи.</p>
                        <p>Клиент не дает доступ к серверу и не мешает его работе.</p>

                        <h2>Установка на {{ $server->system->name }}</h2>

                        <p>Чтобы установить клиент и настроить сервер для работы с системными учетными записями, которые
                            вы уже указали, войдите в систему как пользователь root и выполните следующую команду:</p>

                        <pre>sudo bash -c "$(curl -L {{ config('app.url') }}/api/v1/setup/{{ $server->uuid }}/install.sh)"</pre>

                        <h3>Что дальше?</h3>
                        <p>После выполнения команды, она сообщит вам, что установка завершилась. После этого вы можете
                            обновить эту страницу для управления сервером.</p>
                        <p>Если ваша установка не была завершена (или завершилась, но вы все еще видите этот экран),
                            пожалуйста, проверьте наличие ошибок в программе установки.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="destroyModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('server.destroy', $server) }}">
                @method('delete')
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Вы уверены?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Закрыть">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">После удаления, сервер невозможно будет воостановить.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Я передумал</button>
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
